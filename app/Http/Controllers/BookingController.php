<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rental;
use App\Models\Activity;
use App\Models\Billing;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['tenant', 'unit'])->orderBy('created_at', 'desc')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'start_date' => 'required|date',
            'duration' => 'required|integer|min:1'
        ]);

        $unit = Unit::findOrFail($request->unit_id);
        
        // Check if unit is currently occupied
        if ($unit->status === 'occupied') {
            return redirect()->back()->withErrors(['unit_id' => 'Kamar ini sudah terisi.']);
        }

        // Check if there is an existing approved booking that overlaps (simplification)
        $existingBooking = Booking::where('unit_id', $request->unit_id)
            ->whereIn('status', ['approved', 'pending'])
            ->first();
            
        if ($existingBooking) {
            return redirect()->back()->withErrors(['unit_id' => 'Kamar ini sudah dipesan atau sedang dalam proses booking.']);
        }

        $end_date = \Carbon\Carbon::parse($request->start_date)->addMonths((int) $request->duration);

        $booking = Booking::create([
            'tenant_id' => auth()->id(),
            'unit_id' => $request->unit_id,
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'status' => 'pending'
        ]);

        Activity::create([
            'user_id'    => auth()->id(),
            'action'     => 'Booking Submitted',
            'module'     => 'booking',
            'description'=> 'Submitted booking request for ' . $booking->unit->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Permintaan booking berhasil dikirim! Menunggu persetujuan pemilik.');
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        
        $booking->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            Rental::firstOrCreate([
                'tenant_id' => $booking->tenant_id,
                'unit_id' => $booking->unit_id,
            ], [
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date
            ]);
            
            $booking->unit->update(['status' => 'occupied']);
            
            // 🔥 ENTERPRISE: AUTO-BILLING
            $startDate = \Carbon\Carbon::parse($booking->start_date);
            $endDate = \Carbon\Carbon::parse($booking->end_date);
            $months = max(1, $startDate->diffInMonths($endDate));
            $amount = $booking->unit->price * $months;
            
            Billing::create([
                'tenant_id' => $booking->tenant_id,
                'unit_id' => $booking->unit_id,
                'amount' => $amount,
                'admin_fee' => 10000,
                'paid_amount' => 0,
                'period' => $startDate->translatedFormat('F Y') . ' - ' . $endDate->translatedFormat('F Y'),
                'due_date' => \Carbon\Carbon::parse($booking->start_date)->addDays(7)->toDateString(),
                'status' => 'unpaid'
            ]);
            
            Activity::create([
                'user_id'    => auth()->id(),
                'action'     => 'Booking Approved',
                'module'     => 'booking',
                'description'=> 'Approved booking & Auto-generated billing for ' . $booking->unit->name . ' (Tenant: ' . $booking->tenant->name . ')',
                'ip_address' => $request->ip(),
            ]);
        } else {
            Activity::create([
                'user_id'    => auth()->id(),
                'action'     => 'Booking Rejected',
                'module'     => 'booking',
                'description'=> 'Rejected booking for ' . $booking->unit->name,
                'ip_address' => $request->ip(),
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking status updated successfully');
    }

    public function contract(Booking $booking)
    {
        // Ensure only authorized users can access the contract
        if (auth()->user()->role === 'tenant' && auth()->id() !== $booking->tenant_id) {
            abort(403);
        }

        if ($booking->status !== 'approved') {
            abort(404, 'Kontrak hanya tersedia untuk pemesanan yang disetujui.');
        }

        // Load the view and pass the booking data
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bookings.contract', compact('booking'));
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Surat_Perjanjian_Sewa_' . str_replace(' ', '_', $booking->tenant->name) . '.pdf');
    }

    // This method seems to be intended for a BillingController, but is placed here as per instruction.
    public function storeBilling(Request $request)
    {
        $billing = Billing::create($request->all());
        
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Billing Generated',
            'module' => 'billing',
            'description' => 'Security generated invoice for ' . $billing->period . ' (Amt: ' . $billing->amount . ')'
        ]);

        return redirect()->route('billings.index')->with('success', 'Billing created successfully');
    }
}
