<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        if (auth()->user()->role === 'tenant') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Akun Penyewa (Tenant) hanya dapat masuk melalui aplikasi mobile.']);
        }

        if (auth()->user()->status !== 'approved') {
            $status = auth()->user()->status;
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = match($status) {
                'pending' => 'Akun Anda sedang dalam proses peninjauan oleh Admin.',
                'rejected' => 'Mohon maaf, pendaftaran akun Anda ditolak.',
                'inactive' => 'Akun Anda sedang dinonaktifkan.',
                default => 'Akun Anda tidak aktif.',
            };

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
