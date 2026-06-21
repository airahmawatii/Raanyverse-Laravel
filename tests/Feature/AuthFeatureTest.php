<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_resets_password_via_api()
    {
        // Create a user
        $user = \App\Models\User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('oldpassword'),
        ]);

        // Simulate forgot password request (OTP generation is external, assume token exists)
        $response = $this->postJson('/api/forgot-password/reset', [
            'email' => $user->email,
            'otp' => '123456', // in real case would be verified by EmailJS, here assume success
            'password' => 'newsecurepass',
            'password_confirmation' => 'newsecurepass',
        ]);

        $response->assertStatus(200);
        $this->assertTrue(\Hash::check('newsecurepass', $user->fresh()->password));
    }

    /** @test */
    public function it_uploads_profile_photo()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'sanctum');



        // Use a tiny 1x1 PNG base64 string to avoid GD dependency
        $base64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/5+hHgAFgwJ/lT8W5QAAAABJRU5ErkJggg==';
        $response = $this->postJson('/api/profile/photo', [
            'photo' => $base64,
        ]);

        $response->assertStatus(200);
        $this->assertNotNull($user->fresh()->photo_url);
    }

    /** @test */
    public function it_logs_in_via_google()
    {
        // Simulate a Google token payload that the backend expects
        $payload = [
            'email' => 'googleuser@example.com',
            'name' => 'Google User',
            'avatar' => 'https://example.com/avatar.png',
        ];
        $response = $this->postJson('/api/google-login', $payload);
        $response->assertStatus(200);
        // Verify token is returned
        $response->assertJsonStructure(['access_token']);
    }
}
