<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Maintenance;
use App\Models\Activity;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['tenant', 'unit'])->orderBy('created_at', 'desc')->get();
        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        // For tenant to select which room they are complaining about
        // Since tenants might only have 1 active rental, we should fetch it
        $myRentals = \App\Models\Rental::where('tenant_id', auth()->id())->with('unit')->get();
        return view('complaints.create', compact('myRentals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'description' => 'required|string|max:1000'
        ]);

        $complaint = Complaint::create([
            'tenant_id' => auth()->id(),
            'unit_id' => $request->unit_id,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Complaint Submitted',
            'module' => 'complaint',
            'description' => 'Submitted complaint for ' . $complaint->unit->name
        ]);

        return redirect()->route('dashboard')->with('success', 'Komplain berhasil dikirim! Pemilik akan segera memeriksanya.');
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,completed'
        ]);

        $oldStatus = $complaint->status; // Capture old status
        $complaint->update(['status' => $request->status]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Complaint Status Changed',
            'module' => 'complaint',
            'description' => 'Complaint #' . $complaint->id . ' status changed from ' . $oldStatus . ' to ' . $request->status
        ]);

        return redirect()->route('complaints.index')->with('success', 'Complaint status updated successfully');
    }

    // Custom helper endpoints for direct routes if needed
    public function approve($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update(['status' => 'approved']);
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Complaint Approved',
            'module' => 'complaint',
            'description' => 'Directly approved Complaint #' . $complaint->id
        ]);
        return back()->with('success', 'Complaint approved');
    }

    public function complete($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update(['status' => 'completed']);
        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Complaint Closed',
            'module' => 'complaint',
            'description' => 'Directly finalized Complaint #' . $complaint->id
        ]);
        return back()->with('success', 'Complaint completed');
    }
}