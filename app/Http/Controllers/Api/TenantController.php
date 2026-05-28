<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Booking;
use App\Models\Billing;
use App\Models\Tenant;

use App\Models\Complaint;
use App\Models\Maintenance;
use App\Models\Activity;
use App\Services\CalendarSyncService;
use App\Notifications\BookingReminder;

class TenantController extends Controller
{
    private $calendarService;

    public function __construct(CalendarSyncService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    private function logActivity($userId, $action, $module, $desc) {
        Activity::create([
            'user_id' => $userId,
            'action' => $action,
            'module' => $module,
            'description' => $desc
        ]);
    }

    public function getUnits()
    {
        return response()->json(Unit::with('estate.region')->get());
    }

    public function getUnitDetail($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    public function getBookings(Request $request)
    {
        $bookings = Booking::with('unit')->where('tenant_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($bookings);
    }

    public function createBooking(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // maksimal 2MB
        ]);

        // Check if unit is available
        $unit = Unit::find($request->unit_id);
        if ($unit->status !== 'available') {
            return response()->json(['message' => 'Unit is not available for booking'], 400);
        }

        // Check overlapping bookings
        $overlap = Booking::where('unit_id', $request->unit_id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                  ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('start_date', '<=', $request->start_date)
                         ->where('end_date', '>=', $request->end_date);
                  });
            })->exists();

        if ($overlap) {
            return response()->json(['message' => 'Unit is already booked for these dates'], 400);
        }

        // Upload KTP
        $ktpUrl = null;
        if ($request->hasFile('ktp')) {
            try {
                $response = cloudinary()->uploadApi()->upload(
                    $request->file('ktp')->getRealPath(),
                    [
                        'folder' => 'ktps',
                    ]
                );
                $ktpUrl = $response['secure_url'];
            } catch (\Exception $e) {
                // Fallback ke penyimpanan lokal jika Cloudinary gagal
                $path = $request->file('ktp')->store('public/ktps');
                $ktpUrl = asset(\Illuminate\Support\Facades\Storage::url($path));
            }
        }

        $booking = Booking::create([
            'tenant_id' => $request->user()->id,
            'unit_id' => $request->unit_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'ktp_url' => $ktpUrl,
            'status' => 'pending' // default
        ]);

        $this->logActivity($request->user()->id, 'Booking Created', 'booking', 'Requested booking for ' . $unit->name . ' with KTP.');

        return response()->json(['message' => 'Booking created successfully', 'data' => $booking]);
    }

    public function getBillings(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Billings Requested for Tenant ID: ' . $request->user()->id);
        $billings = Billing::with('unit')->where('tenant_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($billings);
    }

    public function payBilling(Request $request, $id)
    {
        $billing = Billing::with('unit', 'tenant')->findOrFail($id);
        
        // Ensure the billing belongs to the authenticated tenant
        if ($billing->tenant_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized access to billing'], 403);
        }

        if ($billing->status === 'paid') {
            return response()->json(['message' => 'Billing already paid'], 400);
        }

        $type = $request->input('type', 'full'); // dp, full, balance

        $amountToPay = $billing->amount;
        if ($type === 'dp') {
            $amountToPay = $billing->amount * 0.3;
        } elseif ($type === 'balance') {
            $amountToPay = $billing->amount - $billing->paid_amount;
        }

        $merchantCode = env('DUITKU_MERCHANT_CODE');
        $apiKey = env('DUITKU_API_KEY');
        $isProduction = env('DUITKU_ENV') === 'production';
        
        $orderId = 'BILL-' . $billing->id . '-' . time();
        $amount = (int) $amountToPay;
        $productDetails = "Payment for {$billing->unit->name} ({$billing->period}) - " . strtoupper($type);
        $email = $billing->tenant->email ?? 'tenant@example.com';
        $customerVaName = $billing->tenant->name ?? 'Tenant';
        
        $callbackUrl = url('/api/payments/notification');
        $returnUrl = url('/dashboard');
        $signature = md5($merchantCode . $orderId . $amount . $apiKey);

        $params = array(
            'merchantCode' => $merchantCode,
            'paymentAmount' => $amount,
            'merchantOrderId' => $orderId,
            'productDetails' => $productDetails,
            'email' => $email,
            'customerVaName' => $customerVaName,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => 1440
        );

        $url = $isProduction 
            ? 'https://passport.duitku.com/webapi/api/merchant/v2/inquiry' 
            : 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry';

        try {
            $response = \Illuminate\Support\Facades\Http::post($url, $params);
            $res = $response->json();
            
            if (isset($res['statusCode']) && $res['statusCode'] == '00') {
                return response()->json([
                    'success' => true,
                    'payment_url' => $res['paymentUrl'],
                    'order_id' => $orderId
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $res['statusMessage'] ?? 'Failed to generate Duitku payment url'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getComplaints(Request $request)
    {
        $complaints = Complaint::with('unit')->where('tenant_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($complaints);
    }

    public function createComplaint(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'description' => 'required|string',
        ]);

        $complaint = Complaint::create([
            'tenant_id' => $request->user()->id,
            'unit_id' => $request->unit_id,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        $this->logActivity($request->user()->id, 'Complaint Created', 'complaint', 'Created complaint for Unit ' . $request->unit_id);

        return response()->json(['message' => 'Complaint submitted successfully', 'data' => $complaint]);
    }

    public function getMaintenances(Request $request)
    {
        $maintenances = Maintenance::with('unit')->where('tenant_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($maintenances);
    }

    public function createMaintenance(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'description' => 'required|string',
        ]);

        $maintenance = Maintenance::create([
            'tenant_id' => $request->user()->id,
            'unit_id' => $request->unit_id,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        $this->logActivity($request->user()->id, 'Maintenance Request Created', 'maintenance', 'Requested maintenance for Unit ' . $request->unit_id);

        return response()->json(['message' => 'Maintenance request submitted successfully', 'data' => $maintenance]);
    }

    public function getHistory(Request $request)
    {
        $activities = Activity::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($activities);
    }

    public function syncCalendar(Request $request, $id)
    {
        $booking = Booking::with('unit')->where('id', $id)->where('tenant_id', $request->user()->id)->firstOrFail();
        
        if ($booking->status !== 'approved') {
            return response()->json(['message' => 'Only approved bookings can be synced'], 400);
        }

        $result = $this->calendarService->syncBooking($booking);
        
        $this->logActivity($request->user()->id, 'Calendar Sync', 'booking', 'Synced booking for ' . $booking->unit->name . ' to Google Calendar');

        return response()->json($result);
    }

    public function getNotifications(Request $request)
    {
        $notifications = $request->user()->notifications;
        return response()->json($notifications);
    }
}
