<!DOCTYPE html>
<html>
<head>
    <title>Login | {{ config('app.name') }}</title>
    <link href="{{ asset('favicon.ico') }}">

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
    </style>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="bg-gradient-to-tr from-blue-100 via-red-100 to-blue-100">
    <div class="container mx-auto h-screen flex items-center" style="max-width: 560px;">
        <div class="section m-0 w-full">
            <div class="section-content">
                <div class="card">
                    <div class="py-8">
                        <div class="flex justify-center pb-10">
                            <img
                                    src="{{ asset('img/logo.png') }}"
                                    alt="Logo"
                                    height="30%"
                                    width="30%"
                            >
                        </div>
                    </div>
                    <h1 class="text-gray-800 text-2xl">{{ __('Sign into your account') }}</h1>
                    <hr class="my-5">
                    <x-form
                        action="{{ route('login') }}"
                        method="POST"
                        buttonText="{{ __('Log in') }}"
                        buttonClasses="w-full mt-10"
                    >
                        <x-inputs.input name="email" type="email" fullWidth />
                        <x-inputs.input name="password" type="password" fullWidth />
                        <x-inputs.toggle name="remember" label="{{ __('Remember me') }}" value="true" />
                    </x-form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
