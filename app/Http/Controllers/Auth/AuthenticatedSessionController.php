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
        $login = $request->input('login');
        $admin = Admin::where('email', $login)
            ->orWhere('name', $login)
            ->first();
        if ($admin && $admin->isLocked()) {
            Log::warning('Login attempt on locked account', [
                'login' => $login,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->withErrors([
                'login' => 'Akun Anda terkunci sementara. Silakan coba lagi nanti.'
            ])->withInput(['login' => $login]);
        }

        try {
            $request->authenticate();

            $request->session()->regenerate();

            /** @var Admin|null $admin */
            $admin = Auth::user();
            assert($admin instanceof Admin);

0            $admin->recordLogin($request->ip());

            Log::info('User logged in successfully', [
                'admin_id' => $admin->id,
                'email' => $admin->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

          
            $request->session()->flash('welcome_message', "Selamat datang " . $admin->name . " pada halaman admin DKM Masjid Al-Musabaqoh");

            return redirect()->intended('/admin/dashboard');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($admin) {
                $admin->incrementFailedAttempts();

                Log::warning('Failed login attempt', [
                    'login' => $login,
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
