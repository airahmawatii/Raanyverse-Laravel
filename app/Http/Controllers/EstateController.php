<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\Region;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    public function index()
    {
        $estates = Estate::with('region')->get();
        return view('estates.index', compact('estates'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('estates.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
        ]);

        Estate::create($request->all());

        return redirect()->route('estates.index')
            ->with('success', 'Estate created successfully.');
    }

    public function edit(Estate $estate)
    {
        $regions = Region::all();
        return view('estates.edit', compact('estate', 'regions'));
    }

    public function update(Request $request, Estate $estate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
        ]);

        $estate->update($request->all());

        return redirect()->route('estates.index')
            ->with('success', 'Estate updated successfully');
    }

    public function destroy(Estate $estate)
    {
        $estate->delete();

        return redirect()->route('estates.index')
            ->with('success', 'Estate deleted successfully');
    }
}
