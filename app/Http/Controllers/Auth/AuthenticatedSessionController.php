<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Check if account is locked before attempting authentication
        $email = $request->input('email');
        $admin = Admin::where('email', $email)->first();
        if ($admin && $admin->isLocked()) {
            Log::warning('Login attempt on locked account', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->withErrors([
                'email' => 'Akun Anda terkunci sementara. Silakan coba lagi nanti.'
            ])->withInput(['email' => $email]);
        }

        try {
            $request->authenticate();

            $request->session()->regenerate();

            /** @var Admin|null $admin */
            $admin = Auth::user();
            assert($admin instanceof Admin);

            // Record successful login
            $admin->recordLogin($request->ip());

            // Log successful login
            Log::info('User logged in successfully', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Tambahkan pesan selamat datang
            $request->session()->flash('welcome_message', "Selamat datang " . $admin->name . " pada halaman admin DKM Masjid Al-Musabaqoh");

            return redirect()->intended('/admin/dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($admin) {
                $admin->incrementFailedAttempts();

                Log::warning('Failed login attempt', [
                    'email' => $email,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'attempts' => $admin->failed_login_attempts,
                ]);
            }

            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
