<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get all users except the currently authenticated super admin
        $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function approve(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Akun Pemilik Properti berhasil disetujui.');
    }

    public function reject(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $user->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Akun Pemilik Properti telah ditolak.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
