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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Aksi ini hanya dapat dilakukan oleh Admin.');
        }
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
            $totalPrice = $booking->payment_type === 'sewa' 
                ? $booking->unit->price * $booking->duration_months 
                : $booking->unit->price;

            $remainingAmount = $totalPrice - $booking->dp_amount;
            $duration = $booking->duration_months;

            // Generate DP billing if dp_amount > 0
            if ($booking->dp_amount > 0) {
                Billing::create([
                    'tenant_id'   => $booking->tenant_id,
                    'unit_id'     => $booking->unit_id,
                    'amount'      => $booking->dp_amount,
                    'admin_fee'   => 10000,
                    'paid_amount' => 0,
                    'period'      => 'DP Awal - ' . $booking->unit->name,
                    'due_date'    => $startDate->toDateString(),
                    'status'      => 'unpaid'
                ]);
            }

            if ($remainingAmount > 0 && $duration > 0) {
                $baseInstallment = round($remainingAmount / $duration, 2);
                $dueDay = $booking->due_day ?? $startDate->day;
                if ($dueDay > 28) {
                    $dueDay = 28;
                }

                for ($i = 0; $i < $duration; $i++) {
                    // Calculate exact amount for this month to handle rounding issues on the last installment
                    $amountForThisMonth = ($i === $duration - 1) 
                        ? ($remainingAmount - ($baseInstallment * ($duration - 1))) 
                        : $baseInstallment;

                    $installmentDate = $startDate->copy()->addMonths($i);
                    $dueDate = $installmentDate->copy()->day($dueDay);
                    if ($dueDate->lt($startDate)) {
                        $dueDate = $startDate->copy();
                    }

                    $periodLabel = $booking->payment_type === 'cicilan' ? 'Cicilan' : 'Sewa';
                    $period = $periodLabel . ' Bulan ' . $installmentDate->translatedFormat('F Y');

                    Billing::create([
                        'tenant_id'   => $booking->tenant_id,
                        'unit_id'     => $booking->unit_id,
                        'amount'      => $amountForThisMonth,
                        'admin_fee'   => 10000,
                        'paid_amount' => 0,
                        'period'      => $period,
                        'due_date'    => $dueDate->toDateString(),
                        'status'      => 'unpaid'
                    ]);
                }
            }
            
            Activity::create([
                'user_id'    => auth()->id(),
                'action'     => 'Booking Approved',
                'module'     => 'booking',
                'description'=> 'Approved booking & Auto-generated billing schedule for ' . $booking->unit->name . ' (Tenant: ' . $booking->tenant->name . ')',
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
