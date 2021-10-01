<!DOCTYPE html>
<html>
<head>
    <title>Login | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <link href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin2/css/main.css') }}" rel="stylesheet">
</head>
<body class="auth-wrapper">
<div class="all-wrapper menu-side with-pattern" style="padding: 10px!important;">
    <div class="auth-box-w">
        <div class="logo-w" style="padding: 60px;">
            <img alt="logo" src="{{ asset('logo.png') }}" width="180">
        </div>
        <h4 class="auth-header" style="padding: 0 20px 20px 20px!important;" >
            Ulogujte se
        </h4>
        <form
                action="{{ route('login') }}"
                method="POST"
                style="padding: 20px 20px!important;"
        >
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email</label>
                <input
                        class="form-control"
                        placeholder="Unesite email"
                        type="text"
                        style="font-size: 16px!important;"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                >
                @if ($errors->has('email'))
                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <label for="password">Lozinka</label>
                <input
                        class="form-control"
                        placeholder="Unesite lozinku"
                        style="font-size: 16px!important;"
                        type="password"
                        id="password"
                        name="password"
                        required
                >
                @if ($errors->has('password'))
                    <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group">
                <label
                        class="form-check-label"
                        style="margin: 0 20px!important;"
                >
                    <input
                            class="form-check-input"
                            type="checkbox"
                            name="remember"
                            {{ old('remember') ? 'checked' : '' }}
                    >Zapamti me
                </label>
            </div>
            <div class="buttons-w">
                <button class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
