<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>@yield('title') | {{ config('app.name') }}</title>
        
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @yield('master-styles')
    </head>
    <body class="bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50 h-full">
        <form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
        <x-modal/>
        
        <div id="mobile-menu" class="closed">
            <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
            <div class="fixed inset-0 flex z-40" role="dialog" aria-modal="true">
                <div class="relative flex-1 flex flex-col px-8 py-6 bg-white">
                    <div class="flex-shrink-0 flex justify-between">
                        <img class="h-10 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Workflow">
                        
                        <button
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white mobile-menu-close"
                        >
                            <span class="sr-only">Close sidebar</span>
                            <!-- Heroicon name: outline/x -->
                            <svg
                                class="h-6 w-6 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="my-5 flex-1 h-0 overflow-y-auto pr-6 -mr-6">
                        <nav class="flex-1 pb-4">
                            @include('voiler::layouts.navigation.nav')
                        </nav>
                    </div>
                    <div class="py-4 -mx-6 px-6 border-t border-gray-200">
                        @include('voiler::layouts.navigation.mobile-profile')
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <div class="flex flex-col flex-grow px-4 py-6 bg-white overflow-y-auto shadow">
                <div class="flex justify-center">
                    <a href="{{ config('navigation._logo.route') ? route(config('navigation._logo.route')) : '#' }}">
                        <img class="h-14 w-auto" src="{{ asset(config('navigation._logo.url')) }}" alt="Workflow">
                    </a>
                </div>
                <div class="mt-10 flex-grow flex flex-col">
                    <nav class="flex-1 pb-4">
                        @include('voiler::layouts.navigation.nav')
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="flex-shrink-0 flex h-16 border-b border-gray-200">
                <button type="button" class="mobile-menu-open">
                    <span class="sr-only">Open sidebar</span>
                    
                    <svg
                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </button>
                
                <div class="px-4 md:px-6 lg:px-10 flex-1 flex justify-between">
                    <div class="flex-1 flex">
                        {{--            TODO insert search --}}
                    </div>
                    
                    <div class="ml-4 flex items-center md:ml-6">
                        <button
                            type="button"
                            class="btn btn-transparent p-2 rounded-full dropdown-toggle"
                        >
                            <span class="sr-only">View notifications</span>
                            <!-- Heroicon name: outline/bell -->
                            <svg
                                class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                />
                            </svg>
                        </button>
                        
                        @include('voiler::layouts.navigation.profile')
                    </div>
                </div>
            </div>
            
            <main class="flex-1">
                <div class="px-4 md:px-6 lg:px-10 py-4 md:py-6 lg:py-8">
                    <header class="w-full mx-auto flex flex-col md:flex-row justify-between md:items-end">
                        <div class="flex flex-col">
                            @yield('breadcrumbs')
                            <h1 class="text-xl md:text-2xl lg:text-3xl mt-2">
                                @yield('title')
                            </h1>
                        </div>
                        
                        <div class="mt-3 md:mt-0 flex">
                            @yield('action-button')
                        </div>
                    </header>
                    
                    <div class="w-full mx-auto">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
        
        <script src="{{ mix('js/app.js') }}"></script>
        @include('voiler::layouts.alerts')
        
        @yield('master-scripts')
        @stack('master-scripts')
        
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        </script>
    </body>
</html>
