<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('css/tailwind.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @yield('styles')
</head>
<body class="bg-base h-full">
    <x-modal />
    <div class="min-h-screen">

        @include('voiler::layouts.header')

        <div class="py-10">
            <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('breadcrumbs')

                <h1 class="flex justify-start text-3xl mt-2">
                    @yield('title')
                </h1>

                <div class="flex justify-end">
                    @yield('action-button')
                </div>
            </header>
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
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
