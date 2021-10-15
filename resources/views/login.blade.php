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

        body {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='24' viewBox='0 0 12 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23eaeaea' fill-opacity='0.4'%3E%3Cpath d='M2 0h2v12H2V0zm1 20c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM9 8c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm-1 4h2v12H8V12z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto h-screen flex items-center" style="max-width: 560px;">
        <div class="section m-0 w-full">
            <div class="section-content">
                <div class="card">
                    <div class="py-8">
                        <p class="text-center text-2xl tracking-wide text-blue-500 font-semibold mb-3">{{ config('app.name') }}</p>
                        <h1 class="font-bold text-gray-800 text-3xl text-center">{{ __('Sign into your account') }}</h1>
                    </div>
                    <hr class="my-10 border-gray-100">
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
