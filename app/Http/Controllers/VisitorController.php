<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Unit;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('unit')->latest()->get();
        return view('visitors.index', compact('visitors'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('visitors.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'vehicle_number' => 'nullable|string|max:50',
            'unit_id' => 'required|exists:units,id',
            'purpose' => 'required|string|max:255',
        ]);

        Visitor::create($validated);
        return redirect()->route('visitors.index')->with('success', 'Tamu berhasil dicatat masuk.');
    }

    public function update(Request $request, Visitor $visitor)
    {
        // Simple checkout action
        $visitor->update([
            'check_out_at' => now(),
            'status' => 'checked_out'
        ]);

        return redirect()->route('visitors.index')->with('success', 'Tamu berhasil keluar (checked out).');
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Catatan tamu dihapus.');
    }
}
