<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @yield('master-styles')
    </head>
    <body class="bg-primary h-full">
        <form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
        <x-modal />

        <div id="mobile-menu" hidden>
            @include('voiler::layouts.sidebar.mobile')
        </div>

        @include('voiler::layouts.sidebar.desktop')

        <div class="md:pl-64 flex flex-col flex-1">
            @include('voiler::layouts.sidebar.top')

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
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        </script>
        @include('voiler::layouts.alerts')

        @yield('master-scripts')
        @stack('master-scripts')
    </body>
</html>
