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
        @stack('styles')




        @livewireStyles

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('js/semantic.min.js') }}"></script>
        
        {{-- Datatable .. --}}
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
        

        

 
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-indigo-100 overflow-y-hidden">
            <!-- Page Heading -->
            {{-- @livewire('navigation-dropdown') --}}

                <div class="flex" x-data="{sidebar: false}">

                    <template id="SIDEBAR"  x-if="!sidebar">
                        <div class="w-96 h-screen bg-white relative">
                            <x-layouts.partials.sidebar/>
                        </div>
                    </template>
                

                    <div class="flex-1 h-screen flex flex-col">
                        <div id="TOPBAR">
                            <x-layouts.partials.topbar/>
                        </div>

                        <div class="px-6 leading-loose border-b shadow bg-gray-50">
                            <x-breadcrumb/>
                        </div>
                        
                        <!-- Page Content -->
                        <div class="overflow-x-hidden flex flex-col flex-1">
                            <div class="md:p-5 p-0 flex-1 shadow relative">
                                <div class="shadow-lg p-3 bg-gray-100 border md:border-teal-200 md:rounded">
                                    {{ $slot }}
                                </div>
                            </div>
                            <div id="FOOTER" class="bg-white">
                                <x-layouts.partials.footer/>
                            </div>
                        </div>
                    </div>

                </div>
                


        </div>

        @stack('modals')
        @stack('scripts')

        @livewireScripts

        <livewire:tools.toaster />
        {{-- <livewire:tools.modal /> --}}

        
        
    </body>
</html>


