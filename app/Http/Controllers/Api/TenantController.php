<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Booking;
use App\Models\Billing;
use App\Models\Complaint;
use App\Models\Maintenance;
use App\Models\Activity;
use App\Models\Facility;
use App\Models\FacilityBooking;
use App\Models\Announcement;
use App\Services\CalendarSyncService;
use App\Notifications\BookingReminder;

class TenantController extends Controller
{
    private $calendarService;

    public function __construct(CalendarSyncService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    private function logActivity(Request $request, $userId, $action, $module, $desc)
    {
        Activity::create([
            'user_id'    => $userId,
            'action'     => $action,
            'module'     => $module,
            'description'=> $desc,
            'ip_address' => $request->ip(),
        ]);
    }

    // =====================================================================
    // UNITS
    // =====================================================================

    public function getUnits()
    {
        return response()->json(Unit::with('estate.region')->get());
    }

    public function getUnitDetail($id)
    {
        $unit = Unit::with('estate.region')->findOrFail($id);
        return response()->json($unit);
    }

    // =====================================================================
    // BOOKINGS
    // =====================================================================

    public function getBookings(Request $request)
    {
        $bookings = Booking::with('unit.estate')
            ->where('tenant_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($bookings);
    }

    public function createBooking(Request $request)
    {
        $request->validate([
            'unit_id'         => 'required|exists:units,id',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after:start_date',
            'ktp'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'payment_type'    => 'required|in:sewa,cicilan',
            'duration_months' => 'required|integer|min:1',
            'dp_amount'       => 'required|numeric|min:0',
            'due_day'         => 'nullable|integer|between:1,28',
        ]);

        $unit = Unit::find($request->unit_id);
        if ($unit->status === 'maintenance') {
            return response()->json(['message' => 'Unit is currently undergoing maintenance and cannot be booked'], 400);
        }

        if ($unit->has_pending_booking) {
            return response()->json(['message' => 'Unit tidak bisa dipesan karena ada permintaan sewa/pembelian yang belum di-approve.'], 400);
        }

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

        $ktpUrl = null;
        if ($request->hasFile('ktp')) {
            try {
                $response = cloudinary()->uploadApi()->upload(
                    $request->file('ktp')->getRealPath(),
                    ['folder' => 'ktps']
                );
                $ktpUrl = $response['secure_url'];
            } catch (\Exception $e) {
                $path   = $request->file('ktp')->store('public/ktps');
                $ktpUrl = asset(\Illuminate\Support\Facades\Storage::url($path));
            }
        }

        $booking = Booking::create([
            'tenant_id'       => $request->user()->id,
            'unit_id'         => $request->unit_id,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'ktp_url'         => $ktpUrl,
            'status'          => 'pending',
            'payment_type'    => $request->payment_type,
            'duration_months' => $request->duration_months,
            'dp_amount'       => $request->dp_amount,
            'due_day'         => $request->due_day,
        ]);

        $this->logActivity($request, $request->user()->id, 'Booking Created', 'booking',
            'Requested booking for ' . $unit->name . ' with KTP.');

        return response()->json(['message' => 'Booking created successfully', 'data' => $booking], 201);
    }

    public function cancelBooking(Request $request, $id)
    {
        $booking = Booking::where('id', $id)
            ->where('tenant_id', $request->user()->id)
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Only pending bookings can be cancelled'], 400);
        }

        $booking->update(['status' => 'rejected']);

        $this->logActivity($request, $request->user()->id, 'Booking Cancelled', 'booking',
            'Cancelled booking #' . $booking->id . ' for unit ' . ($booking->unit->name ?? $booking->unit_id));

        return response()->json(['message' => 'Booking cancelled successfully']);
    }

    // =====================================================================
    // BILLINGS & PAYMENT
    // =====================================================================

    public function getBillings(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Billings Requested for Tenant ID: ' . $request->user()->id);
        $billings = Billing::with('unit')
            ->where('tenant_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($billings);
    }

    public function payBilling(Request $request, $id)
    {
        // Fitur pembayaran Duitku telah dihapus.
        // Konfirmasi pembayaran dilakukan secara manual melalui WhatsApp.
        return response()->json([
            'success' => true,
            'message' => 'Silakan konfirmasi pembayaran secara manual melalui WhatsApp Admin.',
        ]);
    }

    public function downloadReceipt(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);

        if ($billing->status !== 'paid') {
            return response()->json(['message' => 'Hanya tagihan lunas yang dapat diunduh kuitansinya.'], 403);
        }

        if ($billing->tenant_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $billing->load(['tenant', 'unit']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billings.receipt', compact('billing'));
        return $pdf->download('kuitansi-' . $billing->id . '.pdf');
    }

    // =====================================================================
    // COMPLAINTS
    // =====================================================================

    public function getComplaints(Request $request)
    {
        $complaints = Complaint::with('unit')
            ->where('tenant_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($complaints);
    }

    public function createComplaint(Request $request)
    {
        $request->validate([
            'unit_id'     => 'required|exists:units,id',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            try {
                $response = cloudinary()->uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    ['folder' => 'complaints']
                );
                $imageUrl = $response['secure_url'];
            } catch (\Exception $e) {
                $path     = $request->file('image')->store('public/complaints');
                $imageUrl = asset(\Illuminate\Support\Facades\Storage::url($path));
            }
        }

        $complaint = Complaint::create([
            'tenant_id'   => $request->user()->id,
            'unit_id'     => $request->unit_id,
            'description' => $request->description,
            'image_url'   => $imageUrl,
            'status'      => 'pending',
        ]);

        $this->logActivity($request, $request->user()->id, 'Complaint Created', 'complaint',
            'Created complaint for Unit ' . $request->unit_id);

        return response()->json(['message' => 'Complaint submitted successfully', 'data' => $complaint], 201);
    }

    // =====================================================================
    // MAINTENANCES
    // =====================================================================

    public function getMaintenances(Request $request)
    {
        $maintenances = Maintenance::with('unit')
            ->where('tenant_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($maintenances);
    }

    public function createMaintenance(Request $request)
    {
        $request->validate([
            'unit_id'     => 'required|exists:units,id',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            try {
                $response = cloudinary()->uploadApi()->upload(
                    $request->file('image')->getRealPath(),
                    ['folder' => 'maintenances']
                );
                $imageUrl = $response['secure_url'];
            } catch (\Exception $e) {
                $path     = $request->file('image')->store('public/maintenances');
                $imageUrl = asset(\Illuminate\Support\Facades\Storage::url($path));
            }
        }

        $maintenance = Maintenance::create([
            'tenant_id'   => $request->user()->id,
            'unit_id'     => $request->unit_id,
            'description' => $request->description,
            'image_url'   => $imageUrl,
            'status'      => 'pending',
        ]);

        $this->logActivity($request, $request->user()->id, 'Maintenance Request Created', 'maintenance',
            'Requested maintenance for Unit ' . $request->unit_id);

        return response()->json(['message' => 'Maintenance request submitted successfully', 'data' => $maintenance], 201);
    }

    // =====================================================================
    // FACILITIES
    // =====================================================================

    public function getFacilities(Request $request)
    {
        $facilities = Facility::with('estate')
            ->where('is_bookable', true)
            ->get()
            ->map(function ($f) {
                return [
                    'id'           => $f->id,
                    'name'         => $f->name,
                    'description'  => $f->description,
                    'estate'       => $f->estate ? ['id' => $f->estate->id, 'name' => $f->estate->name] : null,
                    'open_time'    => $f->open_time,
                    'close_time'   => $f->close_time,
                    'max_capacity' => $f->max_capacity,
                    'booking_fee'  => $f->booking_fee,
                ];
            });

        return response()->json($facilities);
    }

    public function bookFacility(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        if (!$facility->is_bookable) {
            return response()->json(['message' => 'This facility is not available for booking'], 400);
        }

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required|date_format:H:i',
            'end_time'     => 'required|date_format:H:i|after:start_time',
            'guest_count'  => 'required|integer|min:1|max:' . $facility->max_capacity,
        ]);

        // Check capacity conflict on same date & overlapping time
        $conflict = FacilityBooking::where('facility_id', $id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('start_time', '<', $request->end_time)
                       ->where('end_time', '>', $request->start_time);
                });
            })
            ->sum('guest_count');

        if (($conflict + $request->guest_count) > $facility->max_capacity) {
            return response()->json(['message' => 'Facility is fully booked for the selected time slot'], 400);
        }

        $facilityBooking = FacilityBooking::create([
            'facility_id'  => $facility->id,
            'tenant_id'    => $request->user()->id,
            'booking_date' => $request->booking_date,
            'start_time'   => $request->start_time,
            'end_time'     => $request->end_time,
            'guest_count'  => $request->guest_count,
            'status'       => 'pending',
        ]);

        $this->logActivity($request, $request->user()->id, 'Facility Booked', 'facility',
            'Booked facility ' . $facility->name . ' on ' . $request->booking_date);

        return response()->json([
            'message' => 'Facility booking submitted successfully',
            'data'    => $facilityBooking->load('facility'),
        ], 201);
    }

    public function getFacilityBookings(Request $request)
    {
        $bookings = FacilityBooking::with('facility.estate')
            ->where('tenant_id', $request->user()->id)
            ->orderBy('booking_date', 'desc')
            ->get();
        return response()->json($bookings);
    }

    public function cancelFacilityBooking(Request $request, $id)
    {
        $booking = FacilityBooking::where('id', $id)
            ->where('tenant_id', $request->user()->id)
            ->firstOrFail();

        if (!in_array($booking->status, ['pending', 'approved'])) {
            return response()->json(['message' => 'This booking cannot be cancelled'], 400);
        }

        $booking->update(['status' => 'cancelled']);

        $this->logActivity($request, $request->user()->id, 'Facility Booking Cancelled', 'facility',
            'Cancelled facility booking #' . $booking->id);

        return response()->json(['message' => 'Facility booking cancelled successfully']);
    }

    // =====================================================================
    // ANNOUNCEMENTS
    // =====================================================================

    public function getAnnouncements(Request $request)
    {
        // Get tenant's estate via their active rental or booking
        $tenantEstateId = \App\Models\Rental::where('tenant_id', $request->user()->id)
            ->join('units', 'rentals.unit_id', '=', 'units.id')
            ->value('units.estate_id');

        $announcements = Announcement::with('estate')
            ->where('is_active', true)
            ->where(function ($q) use ($tenantEstateId) {
                // Global announcements (no specific estate) OR tenant's estate
                $q->whereNull('estate_id');
                if ($tenantEstateId) {
                    $q->orWhere('estate_id', $tenantEstateId);
                }
            })
            ->orderByRaw("FIELD(priority, 'urgent', 'high', 'normal', 'low')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($a) {
                return [
                    'id'         => $a->id,
                    'title'      => $a->title,
                    'content'    => $a->content,
                    'priority'   => $a->priority,
                    'estate'     => $a->estate ? ['id' => $a->estate->id, 'name' => $a->estate->name] : null,
                    'is_global'  => is_null($a->estate_id),
                    'created_at' => $a->created_at->toDateTimeString(),
                ];
            });

        return response()->json($announcements);
    }

    // =====================================================================
    // HISTORY & NOTIFICATIONS
    // =====================================================================

    public function getHistory(Request $request)
    {
        $activities = Activity::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($activities);
    }

    public function syncCalendar(Request $request, $id)
    {
        $booking = Booking::with('unit')
            ->where('id', $id)
            ->where('tenant_id', $request->user()->id)
            ->firstOrFail();

        if ($booking->status !== 'approved') {
            return response()->json(['message' => 'Only approved bookings can be synced'], 400);
        }

        $result = $this->calendarService->syncBooking($booking);

        $this->logActivity($request, $request->user()->id, 'Calendar Sync', 'booking',
            'Synced booking for ' . $booking->unit->name . ' to Google Calendar');

        return response()->json($result);
    }

    public function getNotifications(Request $request)
    {
        $notifications = $request->user()->notifications()->latest()->get()->map(function ($n) {
            return [
                'id'         => $n->id,
                'type'       => $n->data['type'] ?? 'info',
                'message'    => $n->data['message'] ?? '',
                'sent_at'    => $n->data['sent_at'] ?? $n->created_at->toDateTimeString(),
                'read_at'    => $n->read_at,
                'is_read'    => !is_null($n->read_at),
            ];
        });

        return response()->json($notifications);
    }

    public function markNotificationRead(Request $request, $id)
    {
        $notification = $request->user()->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();
        return response()->json(['message' => 'Notification marked as read']);
    }
}
