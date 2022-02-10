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
<body class="h-full bg-gradient-to-tr from-blue-100 via-primary-100 to-blue-100">

    <div class="container mx-auto h-screen flex items-center">
        <div class="mx-auto md:w-full lg:w-1/3 px-10 py-16 bg-white rounded-lg">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <img
                    @if(file_exists(public_path('img/logo.svg')))
                        src="{{ asset('img/logo.svg') }}"
                    @else
                        src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                    @endif
                    alt="Logo"
                    class="h-8 w-auto mx-auto"
                >
                <h2 class="mt-14 text-2xl text-gray-900">
                    {{ __('voiler::interface.sign_in_to_your_account') }}
                </h2>
                @if (Route::has('admin.register'))
                    <p class="mt-2 text-sm text-center text-gray-600">
                        Or
                        <a href="{{ route('admin.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Register
                        </a>
                    </p>
                @endif
            </div>

            <div class="mt-8">
                <div class="mt-6">
                    <x-form
                        action="{{ route('login') }}"
                        method="POST"
                        buttonText="{{ __('voiler::interface.login') }}"
                        buttonClasses="btn-block mt-6"
                    >
                        <x-inputs.input name="email" type="email" fullWidth />
                        <x-inputs.input name="password" type="password" fullWidth />
                        <x-inputs.toggle name="remember" label="{{ __('voiler::interface.remember_me') }}" value="true" />
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
