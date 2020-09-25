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
        <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('js/semantic.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-indigo-50 overflow-y-hidden">
            <!-- Page Heading -->
            {{-- @livewire('navigation-dropdown') --}}

                <div class="flex" x-data="{open: false}">

                    <div id="SIDEBAR" class="w-0 h-screen bg-white" :class="{'w-3/12':!open}">
                        @livewire('layouts.partials.sidebar.index')
                    </div>
                
                    <div class="w-full h-screen flex flex-col">

                        <div id="TOPBAR">
                            @livewire('layouts.partials.topbar.index')
                        </div>

                        <div class="px-6 py-3 border-b border-gray-300 shadow bg-gray-50">
                            <x-breadcrumb/>
                        </div>
                        
                        <!-- Page Content -->
                        <div class="p-5 overflow-x-hidden w-full flex-1">
                            <div>{{ $slot }}</div>
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
