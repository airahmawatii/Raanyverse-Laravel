<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        // Jika yang akses adalah tenant, berikan hanya aktivitas miliknya sendiri
        if (auth()->user()->role === 'tenant') {
            $activities = Activity::with('user')->where('user_id', auth()->id())->latest()->paginate(15);
            return view('activities.index', compact('activities'));
        }

        // Selain tenant dan admin tidak boleh (owner)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $activities = Activity::with('user')->latest()->paginate(15);
        return view('activities.index', compact('activities'));
    }
}
