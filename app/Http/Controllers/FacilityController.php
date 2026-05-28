<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Estate;
use Illuminate\Support\Facades\Auth;

class FacilityController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $facilities = Facility::with('estate')->get();
        return view('facilities.index', compact('facilities', 'role'));
    }

    public function create()
    {
        $estates = Estate::all();
        return view('facilities.create', compact('estates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estate_id' => 'required|exists:estates,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'open_time' => 'required',
            'close_time' => 'required',
            'max_capacity' => 'required|integer|min:1',
            'booking_fee' => 'required|numeric|min:0',
            'is_bookable' => 'boolean'
        ]);

        $validated['is_bookable'] = $request->has('is_bookable');

        Facility::create($validated);
        return redirect()->route('facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('facilities.index')->with('success', 'Fasilitas dihapus.');
    }
}
