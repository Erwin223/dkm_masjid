<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // Trust Cloudflare Tunnel proxy so Laravel recognizes HTTPS correctly
        $middleware->trustProxies(
            at: '*',
            headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
                     \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
                     \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
                     \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
                     \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB
        );

        $middleware->alias([
            'nocache' => \App\Http\Middleware\NoCache::class,
            'admin' => \App\Http\Middleware\AdminOnly::class,
        ]);

    })

    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('otp:cleanup')->everyFiveMinutes();
    })

    

    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e) {
            return redirect()->route('login')
                ->with('error', 'Session telah berakhir, silakan login kembali.');
        });

    })

    ->create();
