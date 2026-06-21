<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Login Request Data: ' . json_encode($request->all()));
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        if ($user->role !== 'tenant') {
            return response()->json([
                'message' => 'Only tenants can login to this app'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'tenant',
            'status' => 'approved',
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil, silakan login.',
            'user' => $user
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8', // optional update
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone ?? $user->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $user
        ]);
    }

    public function updateProfilePhoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'photo' => 'required|string', // base64 image data URI
        ]);

        $photoUrl = null;

        try {
            if (config('filesystems.disks.cloudinary.url') || config('filesystems.disks.cloudinary.cloud')) {
                // Upload base64 data URI directly to Cloudinary
                $response = cloudinary()->uploadApi()->upload($request->photo, [
                    'folder' => 'profile_photos'
                ]);
                $photoUrl = $response['secure_url'];
            } else {
                // Local fallback
                $photoData = $request->photo;
                if (str_contains($photoData, ';base64,')) {
                    $photoData = substr($photoData, strpos($photoData, ',') + 1);
                }
                $decoded = base64_decode($photoData);
                if ($decoded) {
                    $filename = 'photos/user_' . $user->id . '_' . time() . '.jpg';
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $decoded);
                    $photoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($filename);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cloudinary upload error: ' . $e->getMessage());
            // Local fallback on exception
            $photoData = $request->photo;
            if (str_contains($photoData, ';base64,')) {
                $photoData = substr($photoData, strpos($photoData, ',') + 1);
            }
            $decoded = base64_decode($photoData);
            if ($decoded) {
                $filename = 'photos/user_' . $user->id . '_' . time() . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $decoded);
                $photoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($filename);
            }
        }

        if (!$photoUrl) {
            return response()->json(['message' => 'Gagal memproses unggahan foto'], 500);
        }

        $user->photo_url = $photoUrl;
        $user->save();

        return response()->json([
            'message' => 'Photo updated successfully',
            'photo_url' => $user->photo_url,
            'user' => $user
        ]);
    }


    public function forgotPasswordReset(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar'], 404);
        }

        if ($user->role !== 'tenant') {
            return response()->json(['message' => 'Akun ini tidak dapat mereset password melalui aplikasi'], 403);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Kata sandi berhasil diperbarui']);
    }

    public function googleLogin(Request $request)

    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            // Auto register the google user as a tenant
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(24)),
                'role' => 'tenant',
                'status' => 'approved', // Auto approved
            ]);
        }

        if ($user->role !== 'tenant') {
            return response()->json([
                'message' => 'Only tenants can login to this app'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}
