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

                <div class="flex" x-data="{open: false}">

                    <div id="SIDEBAR" class="w-0 h-screen bg-purple-300" :class="{'w-3/12': !open}">
                        @livewire('layouts.partials.sidebar.index')
                    </div>
                
                    <div class="w-full h-screen flex flex-col bg-green-200 overflow-y-hidden">

                        <div id="TOPBAR">
                            @livewire('layouts.partials.topbar.index')
                        </div>

                        <!-- Page Content -->
                        <div class="overflow-y-hidden flex flex-1">
                            <main class="p-4 overflow-x-hidden">{{ $slot }}</main>
                        </div>
                        
                        <div id="FOOTER" class="bg-red-300 max-h-10">
                            footer
                        </div>

                    </div>
                </div>
                

        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
