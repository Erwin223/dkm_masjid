<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\SendOtpMail;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;

class OtpPasswordController extends Controller
{
    private const OTP_TTL_MINUTES = 15;
    private const OTP_COOLDOWN_SECONDS = 60;
    private const OTP_MAX_ATTEMPTS = 5;
    private const OTP_LOCK_MINUTES = 10;

    // 1. Tampilkan form input email
    public function showEmailForm()
    {
        return view('auth.otp-forgot-password');
    }

    // 2. Proses kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        // Kirim email
        try {
            $sendMail = User::where('email', $email)->where('is_admin', true)->exists();
            $result = $this->issueOtp($email, $sendMail);
            if (! $result['ok']) {
                return back()->withErrors([
                    'email' => 'Tunggu ' . $result['cooldown'] . ' detik sebelum meminta OTP lagi.'
                ]);
            }

            session(['reset_email' => $email]);

            return redirect()->route('password.otp.verify')->with('status', 'Jika email terdaftar, kode OTP telah dikirim. Silakan cek email Anda.');
        } catch (\Exception $e) {
            return redirect()->route('password.otp.verify')
                ->with('status', 'Jika email terdaftar, kode OTP telah dikirim. Silakan cek email Anda.');
        }
    }

    // 3. Tampilkan form input OTP
    public function showVerifyForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        $email = session('reset_email');
        $otpRecord = DB::table('password_reset_otps')->where('email', $email)->first();
        $cooldownRemaining = 0;
        $lockRemainingSeconds = 0;

        if ($otpRecord && $otpRecord->last_sent_at) {
            $cooldownUntil = Carbon::parse($otpRecord->last_sent_at)->addSeconds(self::OTP_COOLDOWN_SECONDS);
            if ($cooldownUntil->isFuture()) {
                $cooldownRemaining = (int) Carbon::now()->diffInSeconds($cooldownUntil, false);
                $cooldownRemaining = max(0, $cooldownRemaining);
            }
        }

        if ($otpRecord && $otpRecord->locked_until) {
            $lockedUntil = Carbon::parse($otpRecord->locked_until);
            if ($lockedUntil->isFuture()) {
                $lockRemainingSeconds = (int) Carbon::now()->diffInSeconds($lockedUntil, false);
                $lockRemainingSeconds = max(0, $lockRemainingSeconds);
            }
        }

        return view('auth.otp-verify', compact('cooldownRemaining', 'lockRemainingSeconds'));
    }

    // 4. Proses validasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi kedaluwarsa, silakan ulangi.']);
        }

        $otpRecord = DB::table('password_reset_otps')->where('email', $email)->first();

        $genericError = 'Kode OTP tidak valid atau sudah kedaluwarsa.';

        if ($otpRecord && $otpRecord->locked_until && Carbon::parse($otpRecord->locked_until)->isFuture()) {
            $seconds = Carbon::now()->diffInSeconds(Carbon::parse($otpRecord->locked_until));
            $minutes = max(1, (int) ceil($seconds / 60));
            return back()->withErrors(['otp' => 'Terlalu banyak percobaan. Coba lagi dalam ' . $minutes . ' menit.']);
        }

        $isAdmin = User::where('email', $email)->where('is_admin', true)->exists();

        if (!$otpRecord || ! $isAdmin) {
            return back()->withErrors(['otp' => $genericError]);
        }

        // Cek kedaluwarsa (15 menit)
        if (Carbon::parse($otpRecord->created_at)->addMinutes(self::OTP_TTL_MINUTES)->isPast()) {
            DB::table('password_reset_otps')->where('email', $email)->delete();
            return back()->withErrors(['otp' => $genericError]);
        }

        // Cek kecocokan OTP
        if (!Hash::check($request->otp, $otpRecord->otp)) {
            $attempts = (int) ($otpRecord->attempts ?? 0);
            $attempts++;

            $update = ['attempts' => $attempts];
            if ($attempts >= self::OTP_MAX_ATTEMPTS) {
                $update['locked_until'] = Carbon::now()->addMinutes(self::OTP_LOCK_MINUTES);
            }

            DB::table('password_reset_otps')->where('email', $email)->update($update);

            if ($attempts >= self::OTP_MAX_ATTEMPTS) {
                return back()->withErrors(['otp' => 'Terlalu banyak percobaan. Silakan tunggu ' . self::OTP_LOCK_MINUTES . ' menit lalu coba lagi.']);
            }

            return back()->withErrors(['otp' => $genericError]);
        }

        // Jika valid, beri izin untuk reset (simpan status di session)
        DB::table('password_reset_otps')->where('email', $email)->update([
            'attempts' => 0,
            'locked_until' => null,
        ]);
        session(['otp_verified' => true]);
        
        return redirect()->route('password.otp.reset');
    }

    public function resendOtp(Request $request)
    {
        $email = session('reset_email');
        if (! $email) {
            return redirect()->route('password.request');
        }

        try {
            $sendMail = User::where('email', $email)->where('is_admin', true)->exists();
            $result = $this->issueOtp($email, $sendMail);
            if (! $result['ok']) {
                return back()->withErrors([
                    'otp' => 'Tunggu ' . $result['cooldown'] . ' detik sebelum mengirim ulang OTP.'
                ]);
            }

            return back()->with('status', 'Jika email terdaftar, kode OTP telah dikirim. Silakan cek email Anda.');
        } catch (\Exception $e) {
            return back()->with('status', 'Jika email terdaftar, kode OTP telah dikirim. Silakan cek email Anda.');
        }
    }

    // 5. Tampilkan form password baru
    public function showResetForm()
    {
        if (!session('reset_email') || !session('otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.otp-reset-password');
    }

    // 6. Proses simpan password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $email = session('reset_email');
        if (!$email || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses tidak sah.']);
        }

        $user = User::where('email', $email)->where('is_admin', true)->first();
        if (! $user) {
            return redirect()->route('password.request')->withErrors(['email' => 'Akses tidak sah.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus record OTP dan bersihkan session
        DB::table('password_reset_otps')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    private function issueOtp(string $email, bool $sendMail): array
    {
        $otpRecord = DB::table('password_reset_otps')->where('email', $email)->first();
        if ($otpRecord && $otpRecord->last_sent_at) {
            $cooldownUntil = Carbon::parse($otpRecord->last_sent_at)->addSeconds(self::OTP_COOLDOWN_SECONDS);
            if ($cooldownUntil->isFuture()) {
                $cooldown = (int) Carbon::now()->diffInSeconds($cooldownUntil, false);
                $cooldown = max(1, $cooldown);
                return ['ok' => false, 'cooldown' => $cooldown];
            }
        }

        $otp = random_int(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $email],
            [
                'otp' => Hash::make($otp),
                'created_at' => Carbon::now(),
                'last_sent_at' => Carbon::now(),
                'attempts' => 0,
                'locked_until' => null,
            ]
        );

        if ($sendMail) {
            Mail::to($email)->send(new SendOtpMail($otp));
        }

        return ['ok' => true, 'cooldown' => 0];
    }
}
