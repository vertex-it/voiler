<!DOCTYPE html>
<html class="h-full bg-white">
<head>
    <title>{{ __('voiler::interface.login') }} | {{ config('app.name') }}</title>
    <link href="{{ asset('favicon.ico') }}">

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="h-screen bg-gradient-to-tr from-login-secondary-100 via-primary-100 to-login-secondary-100">
    <div class="container mx-auto h-full flex items-start md:items-center">
        <div class="w-full sm:max-w-lg p-5 md:p-8 mx-2 sm:mx-auto mt-16 md:mt-0 bg-white rounded-lg shadow-lg">
            <img
                @if (file_exists(public_path(config('navigation._logo.url'))))
                    src="{{ asset(config('navigation._logo.url')) }}"
                @else
                    src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                @endif
                alt="Logo"
                class="h-8 w-auto mx-auto mt-4"
            >
            <h2 class="mt-10 md:mt-12 lg:mt-14 text-xl md:text-2xl text-gray-700">
                {{ __('voiler::interface.sign_in_to_your_account') }}
            </h2>

            <div class="mt-8">
                <x-form
                    action="{{ route('login') }}"
                    method="POST"
                    buttonText="{{ __('voiler::interface.login') }}"
                >
                    <x-inputs.input name="email" type="email" autofocus />
                    <x-inputs.input name="password" type="password" />
                    <x-inputs.toggle name="remember" label="{{ __('voiler::interface.remember_me') }}" value="true" />
                    @if (Route::has('register'))
                        <div class="mt-14 mb-6">
                            <p class="mt-3 text-xs md:text-sm text-center text-gray-500">
                                Don't have account?
                                <a href="{{ route('register') }}" class="font-medium text-primary-500 hover:text-primary-600">
                                    Register here
                                </a>
                            </p>
                        </div>
                    @endif
                </x-form>
            </div>
        </div>
    </div>
</body>
</html>
