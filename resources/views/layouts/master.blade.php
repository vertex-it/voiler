<!DOCTYPE html>
<html lang="en" class="h-full">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name') }}</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        @yield('styles')
    </head>
    <body class="bg-primary h-full">
        <x-modal />

        @include('voiler::layouts.sidebar.mobile')

        @include('voiler::layouts.sidebar.desktop')

        <div class="md:pl-64 flex flex-col flex-1">
            @include('voiler::layouts.sidebar.top')

            <main class="flex-1">
                <div class="px-10 py-8">
                    <header class="w-full mx-auto grid grid-cols-2 md:grid-cols-none">
                        <div class="col-span-2">
                            @yield('breadcrumbs')
                        </div>

                        <h1 class="text-3xl mt-2">
                            @yield('title')
                        </h1>

                        <div class="justify-self-end self-end">
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

        @yield('scripts')
        @stack('scripts')
    </body>
</html>
