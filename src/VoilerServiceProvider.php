<?php

namespace VertexIT\Voiler;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class VoilerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'voiler');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'voiler');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('voiler.php'),
                __DIR__.'/../config/navigation.php' => config_path('navigation.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/voiler'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/voiler'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/voiler'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        Route::macro('voilerResource', function ($uri, $controller) {
            $modelName = Str::of($uri)->singular()->slug('_')->camel();

            Route::as("{$uri}.")->prefix("{$uri}")->group(function () use ($uri, $controller, $modelName) {
                Route::get("clone/{{$modelName}}", [$controller, 'edit'])->name('clone');
                Route::put('restore', [$controller, 'restore'])->name('restore');
                Route::put('update-priority', [$controller, 'updatePriority'])->name('updatePriority');
                Route::delete('force-delete', [$controller, 'forceDelete'])->name('forceDelete');
            });

            Route::resource($uri, $controller)
                ->except(['show'])
                ->parameters([
                    $uri => $modelName,
                ]);
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'voiler');

        // Register the main class to use with the facade
        $this->app->singleton('voiler', function () {
            return new Voiler;
        });
    }
}
