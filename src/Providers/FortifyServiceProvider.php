<?php

namespace VertexIT\Voiler\Providers;

use App\Models\User;
use Auth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use VertexIT\Voiler\Actions\Fortify\CreateNewUser;
use VertexIT\Voiler\Actions\Fortify\ResetUserPassword;
use VertexIT\Voiler\Actions\Fortify\UpdateUserPassword;
use VertexIT\Voiler\Actions\Fortify\UpdateUserProfileInformation;
use VertexIT\Voiler\Http\Requests\LoginRequest;
use VertexIT\Voiler\Http\Responses\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bind custom login request to support login with multiple keys (username, email)
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            LoginRequest::class,
        );

        $this->app->bind(
            \Laravel\Fortify\Http\Responses\LoginResponse::class,
            LoginResponse::class,
        );

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function() {
            return view('voiler::fortify.login');
        });

        Fortify::registerView(function() {
            return view('voiler::fortify.register');
        });

        RateLimiter::for('login', function(Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function(Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
