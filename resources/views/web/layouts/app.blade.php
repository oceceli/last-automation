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
        <div class="min-h-screen h-screen bg-gray-100 overflow-hidden">
            <!-- Page Heading -->
            {{-- @livewire('navigation-dropdown') --}}

            {{-- <div class="h-full flex flex-col justify-between bg-indigo-800 "> --}}

                <div class="flex" x-data="{open: false}">
                    {{-- Left Drawer --}}
                    <div id="SIDEBAR" class="w-0 bg-purple-300" :class="{'w-3/12': !open}">
                        @livewire('layouts.partials.sidebar.index')
                    </div>
                
                    <div class="w-full flex flex-col bg-green-200">
                        <div id="TOPBAR">
                            @livewire('layouts.partials.topbar.index')
                        </div>
                        <!-- Page Content -->
                        <main class="p-3 overflow-y-scroll overflow-visible">
                            <div class="scrolling-auto">
                                {{ $slot }} 
                            </div>
                        </main>
                    </div>
                </div>
                
                {{-- <div id="FOOTER" class="bg-red-300 max-h-10">
                    footer
                </div> --}}

            {{-- </div> --}}

        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
