<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Unit;

class ParcelController extends Controller
{
    public function index()
    {
        $parcels = Parcel::with('unit')->latest()->get();
        return view('parcels.index', compact('parcels'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('parcels.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'courier_name' => 'required|string|max:255',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        Parcel::create($validated);
        return redirect()->route('parcels.index')->with('success', 'Paket berhasil diterima dan dicatat.');
    }

    public function update(Request $request, Parcel $parcel)
    {
        // Simple pickup action
        $parcel->update([
            'taken_at' => now(),
            'status' => 'taken'
        ]);

        return redirect()->route('parcels.index')->with('success', 'Paket berhasil diserahkan ke penerima.');
    }

    public function destroy(Parcel $parcel)
    {
        $parcel->delete();
        return redirect()->route('parcels.index')->with('success', 'Catatan paket dihapus.');
    }
}
