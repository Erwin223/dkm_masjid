<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'DKM Masjid'))</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="frontend-shell">
        <div class="frontend-page min-h-screen flex flex-col">
            @include('frontend.partials.navbar')

            <main class="flex-1">
                @yield('content')
            </main>

            @include('frontend.partials.footer')
        </div>
    </body>
</html>
