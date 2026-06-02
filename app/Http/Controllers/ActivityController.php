<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        // Tenant hanya bisa lihat aktivitas miliknya sendiri
        if ($role === 'tenant') {
            $activities = Activity::with('user')->where('user_id', auth()->id())->latest()->paginate(15);
            return view('activities.index', compact('activities'));
        }

        // Admin dan Owner bisa lihat semua log aktivitas (Anti-Fraud Audit)
        if (!in_array($role, ['admin', 'owner'])) {
            abort(403, 'Unauthorized action.');
        }

        $activities = Activity::with('user')->latest()->paginate(15);
        return view('activities.index', compact('activities'));
    }
}
