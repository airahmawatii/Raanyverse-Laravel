<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Unit;
use App\Models\Activity;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        // Jika tenant, hanya lihat maintenance milik mereka
        if (auth()->user()->role === 'tenant') {
            $maintenances = Maintenance::with(['unit'])->where('tenant_id', auth()->id())->orderBy('created_at', 'desc')->get();
            return view('maintenances.index', compact('maintenances'));
        }

        $maintenances = Maintenance::with(['tenant', 'unit'])->orderBy('created_at', 'desc')->get();
        return view('maintenances.index', compact('maintenances'));
    }

    public function create()
    {
        $myRentals = \App\Models\Rental::where('tenant_id', auth()->id())->with('unit')->get();
        return view('maintenances.create', compact('myRentals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'description' => 'required|string|max:1000'
        ]);

        $maintenance = Maintenance::create([
            'tenant_id' => auth()->id(),
            'unit_id' => $request->unit_id,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Maintenance Requested',
            'module' => 'maintenance',
            'description' => 'Requested maintenance for ' . $maintenance->unit->name
        ]);

        return redirect()->route('dashboard')->with('success', 'Request Maintenance berhasil dikirim!');
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,completed'
        ]);

        $maintenance->update(['status' => $request->status]);

        Activity::create([
            'user_id' => auth()->id(),
            'action' => 'Maintenance Processed',
            'module' => 'maintenance',
            'description' => 'Maintenance shift status set to ' . $request->status . ' for Unit ' . $maintenance->unit->name
        ]);

        return redirect()->route('maintenances.index')->with('success', 'Maintenance status updated successfully');
    }
}
