<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_otp_can_be_requested_for_existing_admin_email(): void
    {
        Mail::fake();

        $user = Admin::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertRedirect(route('password.otp.verify'));
        $response->assertSessionHas('status');
        $this->assertSame($user->email, session('reset_email'));

        $this->assertDatabaseHas('password_reset_otps', [
            'email' => $user->email,
        ]);
    }

    public function test_verify_otp_screen_requires_reset_email_session(): void
    {
        $response = $this->get('/verify-otp');

        $response->assertRedirect(route('password.request'));
    }

    public function test_reset_password_screen_requires_verified_otp_session(): void
    {
        $response = $this->get('/reset-password');

        $response->assertRedirect(route('password.request'));
    }

    public function test_password_can_be_reset_after_otp_verification_session_is_present(): void
    {
        $user = Admin::factory()->create([
            'password' => bcrypt('old-password'),
        ]);

        DB::table('password_reset_otps')->insert([
            'email' => $user->email,
            'otp' => Hash::make('123456'),
            'created_at' => now(),
            'last_sent_at' => now(),
            'attempts' => 0,
            'locked_until' => null,
        ]);

        $response = $this
            ->withSession([
                'reset_email' => $user->email,
                'otp_verified' => true,
            ])
            ->post('/reset-password', [
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $this->assertDatabaseMissing('password_reset_otps', [
            'email' => $user->email,
        ]);
        $this->assertNull(session('reset_email'));
        $this->assertNull(session('otp_verified'));
    }
}
