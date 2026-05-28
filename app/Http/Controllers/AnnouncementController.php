<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\Estate;

class AnnouncementController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            $announcements = Announcement::with('estate')->latest()->get();
        } else {
            $announcements = Announcement::with('estate')
                ->where('is_active', true)
                ->latest()
                ->get();
        }

        return view('announcements.index', compact('announcements', 'role'));
    }

    public function create()
    {
        $estates = Estate::all();
        return view('announcements.create', compact('estates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'estate_id' => 'nullable|exists:estates,id',
            'is_active' => 'boolean'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
