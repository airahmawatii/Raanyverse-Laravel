<?php

namespace App\Http\Controllers;

use App\Models\FacilityBooking;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilityBookingController extends Controller
{
    public function index()
    {
        if (!in_array(Auth::user()->role, ['admin', 'owner'])) {
            abort(403);
        }

        $bookings = FacilityBooking::with(['facility.estate', 'tenant'])
            ->orderBy('booking_date', 'desc')
            ->get();

        $role = Auth::user()->role;
        return view('facility_bookings.index', compact('bookings', 'role'));
    }

    public function updateStatus(Request $request, FacilityBooking $facilityBooking)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,cancelled',
        ]);

        $facilityBooking->update(['status' => $request->status]);

        Activity::create([
            'user_id'     => Auth::id(),
            'action'      => 'Facility Booking ' . ucfirst($request->status),
            'module'      => 'facility',
            'description' => 'Facility booking #' . $facilityBooking->id . ' (' .
                             ($facilityBooking->facility->name ?? 'N/A') . ') for ' .
                             ($facilityBooking->tenant->name ?? 'N/A') . ' set to ' . $request->status,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('facility_bookings.index')
            ->with('success', 'Status reservasi fasilitas berhasil diperbarui.');
    }
}
