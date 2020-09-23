<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            <!-- Page Heading -->
            {{-- @livewire('navigation-dropdown') --}}

            <div id="TOPBAR" class="">
                @livewire('layouts.partials.topbar.index')
            </div>

            <!-- Page Content -->
            <main class="p-3">
                {{ $slot }}
            </main>

            <div id="SIDEBAR">

            </div>

            <div id="FOOTER">

            </div>



        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
