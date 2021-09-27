<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
<div class="modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-bg" aria-hidden="true"></div>
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="modal-center" aria-hidden="true">&#8203;</span>

        <div class="modal-content">
            <div class="modal-body">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Heroicon name: outline/exclamation -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Deactivate account
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">
                    Deactivate
                </button>
                <button type="button" class="modal-close btn btn-white mr-3">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

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

@yield('external-js')
@stack('scripts')
</body>
</html>
