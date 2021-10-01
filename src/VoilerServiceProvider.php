<?php

namespace VertexIT\Voiler;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use VertexIT\Voiler\Console\PublishFromPackagesCommand;

class VoilerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'voiler');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('voiler.php'),
                __DIR__.'/../config/navigation.php' => config_path('navigation.php'),
            ], 'voiler-config');

            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js'),
                __DIR__.'/../resources/css' => resource_path('css'),
                __DIR__.'/../webpack.mix.js' => 'webpack.mix.js',
                __DIR__.'/../tailwind.config.js' => 'tailwind.config.js',
            ], 'voiler-assets');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views'),
            ], 'voiler-views');

            $this->commands([
                PublishFromPackagesCommand::class,
            ]);
        }
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

    protected function registerRoutes()
    {
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

        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'as' => 'admin.',
            'middleware' => config('voiler.middleware'),
        ];
    }
}
