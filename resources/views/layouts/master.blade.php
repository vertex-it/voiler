<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <x-modal />
    <div class="min-h-screen">

        @include('voiler::layouts.header')

        <div class="bg-gray-50">
            <div class="container mx-auto">
                <div class="flex-1 min-h-screen pb-10">
                    <div class="pt-8 flex justify-between">
                        <div>
                            @yield('breadcrumbs')
                            <h1 class="text-xl md:text-2xl lg:text-3xl font-medium mt-2">@yield('title')</h1>
                        </div>
                        <div class="flex items-end">
                            @yield('action-button')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function convertToSlug(text) {
            return text.toLowerCase()
                .replace(/ /g,'-')
                .replace(/[^\w-]+/g,'');
        }
    </script>
    @include('voiler::layouts.alerts')

    @yield('scripts')
    @stack('scripts')
</body>
</html>
