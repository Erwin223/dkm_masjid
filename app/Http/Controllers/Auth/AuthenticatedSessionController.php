<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\SendLoginOtpMail;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    private const LOGIN_OTP_TTL_MINUTES = 10;
    private const LOGIN_OTP_COOLDOWN_SECONDS = 60;
    private const LOGIN_OTP_MAX_ATTEMPTS = 5;

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
        $email = $request->input('email');

        try {
            $admin = $request->authenticate();

            if (! $admin->requiresTwoFactorAuth()) {
                return $this->completeLogin($request, $admin);
            }

            $this->clearPendingLoginChallenge($request);
            $this->issueLoginOtp($request, $admin);

            Log::info('Primary credentials verified, awaiting OTP challenge', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->route('login.otp.form')
                ->with('status', 'Kode verifikasi login telah dikirim ke email admin Anda.');
        } catch (ValidationException $e) {
            Log::warning('Failed login attempt', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw $e;
        } catch (\Throwable $e) {
            Log::error('Unable to send login OTP', [
                'email' => $email,
                'ip' => $request->ip(),
                'message' => $e->getMessage(),
            ]);

            $this->clearPendingLoginChallenge($request);

            throw ValidationException::withMessages([
                'email' => 'Kode verifikasi login gagal dikirim. Silakan coba lagi dalam beberapa saat.',
            ]);
        }
    }

    public function showLoginOtpForm(Request $request): RedirectResponse|View
    {
        if (! $request->session()->has('login_otp_admin_id')) {
            return redirect()->route('login');
        }

        $cooldownRemaining = $this->cooldownRemaining($request);

        return view('auth.login-otp', compact('cooldownRemaining'));
    }

    public function verifyLoginOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        $admin = $this->getPendingLoginAdmin($request);
        if (! $admin) {
            return redirect()->route('login')->withErrors([
                'email' => 'Sesi verifikasi login telah berakhir. Silakan login kembali.',
            ]);
        }

        if ($this->loginOtpExpired($request)) {
            $this->clearPendingLoginChallenge($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Kode verifikasi login sudah kedaluwarsa. Silakan login kembali.',
            ]);
        }

        $attempts = (int) $request->session()->get('login_otp_attempts', 0);
        if ($attempts >= self::LOGIN_OTP_MAX_ATTEMPTS) {
            $this->clearPendingLoginChallenge($request);

            return redirect()->route('login')->withErrors([
                'email' => 'Terlalu banyak percobaan OTP. Silakan login kembali.',
            ]);
        }

        $otpHash = (string) $request->session()->get('login_otp_hash', '');
        if ($otpHash === '' || ! Hash::check((string) $request->input('otp'), $otpHash)) {
            $request->session()->put('login_otp_attempts', $attempts + 1);

            throw ValidationException::withMessages([
                'otp' => 'Kode verifikasi login tidak valid.',
            ]);
        }

        $this->clearPendingLoginChallenge($request);

        return $this->completeLogin($request, $admin);
    }

    public function resendLoginOtp(Request $request): RedirectResponse
    {
        $admin = $this->getPendingLoginAdmin($request);
        if (! $admin) {
            return redirect()->route('login');
        }

        $cooldownRemaining = $this->cooldownRemaining($request);
        if ($cooldownRemaining > 0) {
            return back()->withErrors([
                'otp' => 'Tunggu '.$cooldownRemaining.' detik sebelum meminta kode verifikasi baru.',
            ]);
        }

        try {
            $this->issueLoginOtp($request, $admin);
        } catch (\Throwable $e) {
            Log::error('Unable to resend login OTP', [
                'admin_id' => $admin->id,
                'ip' => $request->ip(),
                'message' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'otp' => 'Kode verifikasi login gagal dikirim ulang. Silakan coba lagi.',
            ]);
        }

        return back()->with('status', 'Kode verifikasi login yang baru telah dikirim.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $this->clearPendingLoginChallenge($request);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    protected function completeLogin(Request $request, Admin $admin): RedirectResponse
    {
        Auth::login($admin);
        $request->session()->regenerate();

        $admin->recordLogin($request->ip());

        Log::info('User logged in successfully', [
            'admin_id' => $admin->id,
            'email' => $admin->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->flash(
            'welcome_message',
            'Selamat datang '.$admin->name.' pada halaman admin DKM Masjid Al-Musabaqoh'
        );

        return redirect()->intended('/admin/dashboard');
    }

    protected function issueLoginOtp(Request $request, Admin $admin): void
    {
        $otp = (string) random_int(100000, 999999);
        $now = Carbon::now();

        Mail::to($admin->email)->send(new SendLoginOtpMail($otp, $admin->name));

        $request->session()->put([
            'login_otp_admin_id' => $admin->id,
            'login_otp_hash' => Hash::make($otp),
            'login_otp_expires_at' => $now->copy()->addMinutes(self::LOGIN_OTP_TTL_MINUTES)->toIso8601String(),
            'login_otp_last_sent_at' => $now->toIso8601String(),
            'login_otp_attempts' => 0,
        ]);
    }

    protected function getPendingLoginAdmin(Request $request): ?Admin
    {
        $adminId = $request->session()->get('login_otp_admin_id');

        return $adminId ? Admin::find($adminId) : null;
    }

    protected function loginOtpExpired(Request $request): bool
    {
        $expiresAt = $request->session()->get('login_otp_expires_at');
        if (! $expiresAt) {
            return true;
        }

        return Carbon::parse($expiresAt)->isPast();
    }

    protected function cooldownRemaining(Request $request): int
    {
        $lastSentAt = $request->session()->get('login_otp_last_sent_at');
        if (! $lastSentAt) {
            return 0;
        }

        $cooldownUntil = Carbon::parse($lastSentAt)->addSeconds(self::LOGIN_OTP_COOLDOWN_SECONDS);
        if ($cooldownUntil->isPast()) {
            return 0;
        }

        return max(0, Carbon::now()->diffInSeconds($cooldownUntil, false));
    }

    protected function clearPendingLoginChallenge(Request $request): void
    {
        $request->session()->forget([
            'login_otp_admin_id',
            'login_otp_hash',
            'login_otp_expires_at',
            'login_otp_last_sent_at',
            'login_otp_attempts',
        ]);
    }
}
