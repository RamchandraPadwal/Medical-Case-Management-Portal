<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Jajal Medical') }} - Case Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-8 px-4 sm:px-6">
            <div>
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-7 bg-white border border-slate-200 shadow-sm overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

            <div class="mt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} Jajal Medical Inc. All rights reserved.
            </div>
        </div>
    </body>
</html>
