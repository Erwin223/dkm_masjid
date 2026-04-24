<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccountLock
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->input('email');

        if ($email) {
            $admin = \App\Models\Admin::where('email', $email)->first();

            if ($admin && $admin->isLocked()) {
                $minutesLeft = now()->diffInMinutes($admin->locked_until, false);

                return back()->withErrors([
                    'email' => "Akun terkunci. Coba lagi dalam {$minutesLeft} menit."
                ])->withInput($request->only('email'));
            }
        }

        return $next($request);
    }
}
