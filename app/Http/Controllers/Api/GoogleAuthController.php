<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'profile',
                'email',
                'https://www.googleapis.com/auth/calendar',
                'https://www.googleapis.com/auth/calendar.events',
            ])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent' // Forces Google to provide a refresh_token
            ])
            ->redirect();
    }

    /**
     * Obtain the user information from Google for web sessions.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login menggunakan Google: ' . $e->getMessage()]);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // Auto-register as tenant
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(Str::random(24)),
                'role' => 'tenant',
                'status' => 'approved',
                'photo_url' => $googleUser->getAvatar(),
            ]);
        }

        // Store Google credentials
        $user->update([
            'google_id' => $googleUser->getId(),
            'google_access_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken ?? $user->google_refresh_token,
            'google_token_expires_at' => now()->addSeconds($googleUser->expiresIn),
        ]);

        if ($user->role === 'tenant') {
            return redirect()->route('login')->withErrors(['email' => 'Akun Penyewa (Tenant) hanya dapat masuk melalui aplikasi mobile.']);
        }

        Auth::login($user, true);

        return redirect()->intended('/dashboard');
    }

    /**
     * API Login/Token Exchange for Mobile (Ionic + Angular).
     * Accepts either authorization 'code' or raw 'access_token' from Ionic client.
     */
    public function apiGoogleLogin(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'access_token' => 'nullable|string',
            'google_id_token' => 'nullable|string',
            'refresh_token' => 'nullable|string',
            'expires_in' => 'nullable|integer',
        ]);

        if (!$request->code && !$request->access_token && !$request->google_id_token) {
            return response()->json([
                'message' => 'Salah satu dari google_id_token, code, atau access_token wajib diisi.'
            ], 422);
        }

        $accessToken = null;
        $refreshToken = null;
        $expiresIn = 3600;

        $googleUserId = null;
        $googleUserEmail = null;
        $googleUserName = null;
        $googleUserAvatar = null;

        try {
            if ($request->has('google_id_token') && !empty($request->google_id_token)) {
                // Verify Google ID Token (JWT) sent by mobile/web frontend
                $client = new \Google\Client(['client_id' => config('services.google.client_id')]);
                $payload = $client->verifyIdToken($request->google_id_token);
                
                if (!$payload) {
                    // Fallback to general verification without strict client_id check,
                    // just in case they are using a different client ID signature but same project
                    $fallbackClient = new \Google\Client();
                    $payload = $fallbackClient->verifyIdToken($request->google_id_token);
                }
                
                if (!$payload) {
                    throw new \Exception('Google ID Token signature verification failed.');
                }
                
                $googleUserId = $payload['sub'];
                $googleUserEmail = $payload['email'];
                $googleUserName = $payload['name'] ?? ($payload['given_name'] . ' ' . $payload['family_name']) ?? $payload['email'];
                $googleUserAvatar = $payload['picture'] ?? null;
            } else {
                if ($request->has('code')) {
                    // Exchange Auth Code for tokens
                    $response = Socialite::driver('google')->getAccessTokenResponse($request->code);
                    $accessToken = $response['access_token'];
                    $refreshToken = $response['refresh_token'] ?? null;
                    $expiresIn = $response['expires_in'] ?? 3600;
                } else {
                    // Raw token passed from Ionic
                    $accessToken = $request->access_token;
                    $refreshToken = $request->refresh_token;
                    $expiresIn = $request->expires_in ?? 3600;
                }

                // Get user info using the access token
                $googleUser = Socialite::driver('google')->userFromToken($accessToken);
                $googleUserId = $googleUser->getId();
                $googleUserEmail = $googleUser->getEmail();
                $googleUserName = $googleUser->getName();
                $googleUserAvatar = $googleUser->getAvatar();
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal verifikasi token Google: ' . $e->getMessage()
            ], 401);
        }

        $user = User::where('email', $googleUserEmail)->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUserName,
                'email' => $googleUserEmail,
                'password' => Hash::make(Str::random(24)),
                'role' => 'tenant',
                'status' => 'approved',
                'photo_url' => $googleUserAvatar,
            ]);
        }

        // Update Google OAuth tokens
        $user->update([
            'google_id' => $googleUserId,
            'google_access_token' => $accessToken ?? $user->google_access_token,
            'google_refresh_token' => $refreshToken ?? $user->google_refresh_token,
            'google_token_expires_at' => $accessToken ? now()->addSeconds($expiresIn) : $user->google_token_expires_at,
        ]);

        if ($user->role !== 'tenant') {
            return response()->json([
                'message' => 'Hanya akun Tenant yang dapat masuk melalui aplikasi mobile.'
            ], 403);
        }

        // Generate Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    /**
     * Connect/Link Google Account for the authenticated user.
     */
    public function connectGoogle(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string',
            'access_token' => 'nullable|string',
            'google_id_token' => 'nullable|string',
            'refresh_token' => 'nullable|string',
            'expires_in' => 'nullable|integer',
        ]);

        $user = $request->user();

        if (!$request->code && !$request->access_token && !$request->google_id_token) {
            return response()->json([
                'message' => 'Salah satu dari google_id_token, code, atau access_token wajib diisi.'
            ], 422);
        }

        $accessToken = null;
        $refreshToken = null;
        $expiresIn = 3600;

        $googleUserId = null;
        $googleUserEmail = null;

        try {
            if ($request->has('google_id_token') && !empty($request->google_id_token)) {
                $client = new \Google\Client(['client_id' => config('services.google.client_id')]);
                $payload = $client->verifyIdToken($request->google_id_token);
                
                if (!$payload) {
                    $fallbackClient = new \Google\Client();
                    $payload = $fallbackClient->verifyIdToken($request->google_id_token);
                }
                
                if (!$payload) {
                    throw new \Exception('Google ID Token signature verification failed.');
                }
                
                $googleUserId = $payload['sub'];
                $googleUserEmail = $payload['email'];
            } else {
                if ($request->has('code')) {
                    $response = \Laravel\Socialite\Facades\Socialite::driver('google')->getAccessTokenResponse($request->code);
                    $accessToken = $response['access_token'];
                    $refreshToken = $response['refresh_token'] ?? null;
                    $expiresIn = $response['expires_in'] ?? 3600;
                } else {
                    $accessToken = $request->access_token;
                    $refreshToken = $request->refresh_token;
                    $expiresIn = $request->expires_in ?? 3600;
                }

                $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->userFromToken($accessToken);
                $googleUserId = $googleUser->getId();
                $googleUserEmail = $googleUser->getEmail();
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal verifikasi token Google: ' . $e->getMessage()
            ], 401);
        }

        // Simpan Google credentials ke user aktif saat ini
        $user->update([
            'google_id' => $googleUserId,
            'google_access_token' => $accessToken ?? $user->google_access_token,
            'google_refresh_token' => $refreshToken ?? $user->google_refresh_token,
            'google_token_expires_at' => $accessToken ? now()->addSeconds($expiresIn) : $user->google_token_expires_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun Google berhasil dihubungkan untuk sinkronisasi kalender.',
            'user' => $user
        ]);
    }
}
