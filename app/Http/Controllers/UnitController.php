<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('estate.region')->get();

        if (auth()->check() && auth()->user()->role === 'tenant') {
            return view('units.browse', compact('units'));
        }

        return view('units.index', compact('units'));
    }

    public function create()
    {
        $estates = \App\Models\Estate::all();
        return view('units.create', compact('estates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blok' => 'required|string',
            'nomor_unit' => 'required|string',
            'name' => 'nullable|string',
            'type' => 'required|string',
            'property_type' => 'required|in:rumah,ruko',
            'estate_id' => 'required|exists:estates,id',
            'price' => 'required|numeric',
            'status' => 'required|in:available,occupied',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,jfif|max:2048'
        ]);

        $data = $request->all();
        if (empty($data['name'])) {
            $data['name'] = 'Blok ' . $data['blok'] . ' No. ' . $data['nomor_unit'];
        }

        if ($request->hasFile('image')) {
            $response = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'units']);
            $data['image'] = $response['secure_url'];
        }

        Unit::create($data);
        return redirect()->route('units.index')->with('success', 'Unit created successfully');
    }

    public function edit(Unit $unit)
    {
        $estates = \App\Models\Estate::all();
        return view('units.edit', compact('unit', 'estates'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'blok' => 'required|string',
            'nomor_unit' => 'required|string',
            'name' => 'nullable|string',
            'type' => 'required|string',
            'property_type' => 'required|in:rumah,ruko',
            'estate_id' => 'required|exists:estates,id',
            'price' => 'required|numeric',
            'status' => 'required|in:available,occupied',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,jfif|max:2048'
        ]);

        $data = $request->all();
        if (empty($data['name'])) {
            $data['name'] = 'Blok ' . $data['blok'] . ' No. ' . $data['nomor_unit'];
        }

        if ($request->hasFile('image')) {
            // Delete old image from Cloudinary if it exists and is a Cloudinary URL
            if ($unit->image && str_contains($unit->image, 'res.cloudinary.com')) {
                $publicId = pathinfo(parse_url($unit->image, PHP_URL_PATH), PATHINFO_FILENAME);
                // We need to pass the folder name as well if it's stored in a folder. 
                // The public ID for 'units/filename.jpg' is 'units/filename'.
                $path = parse_url($unit->image, PHP_URL_PATH);
                // Extract public ID including folders, e.g. /v12345/units/xyz.jpg -> units/xyz
                $parts = explode('/', $path);
                // The public ID is everything after the version (v12345), without extension
                $publicIdWithFolder = 'units/' . pathinfo(end($parts), PATHINFO_FILENAME);
                cloudinary()->uploadApi()->destroy($publicIdWithFolder);
            }
            
            $response = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'units']);
            $data['image'] = $response['secure_url'];
        }

        $unit->update($data);
        return redirect()->route('units.index')->with('success', 'Unit updated successfully');
    }

    public function destroy(Unit $unit)
    {
        // Check if there are active bookings or rentals, then decide to delete or not
        if ($unit->image && str_contains($unit->image, 'res.cloudinary.com')) {
            $path = parse_url($unit->image, PHP_URL_PATH);
            $parts = explode('/', $path);
            $publicIdWithFolder = 'units/' . pathinfo(end($parts), PATHINFO_FILENAME);
            cloudinary()->uploadApi()->destroy($publicIdWithFolder);
        } elseif ($unit->image) {
            Storage::disk('public')->delete($unit->image);
        }
        
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully');
    }
}
