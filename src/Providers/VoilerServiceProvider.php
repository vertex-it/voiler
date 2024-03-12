<?php

namespace VertexIT\Voiler\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use VertexIT\Voiler\Console\MakeCommands\Database\Migrations\VoilerFactoryMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\Database\Migrations\VoilerMigrationMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\Database\Migrations\VoilerSeederMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerAPIControllerMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerControllerMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerDatatableServiceMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerFormViewMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerFormViewModelMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerIndexViewMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerIndexViewModelMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerModelMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerPolicyMakeCommand;
use VertexIT\Voiler\Console\MakeCommands\VoilerRequestMakeCommand;
use VertexIT\Voiler\Console\PublishFromPackagesCommand;
use VertexIT\Voiler\Console\VoilerGenerateCommand;
use VertexIT\Voiler\View\Components\Breadcrumb;
use VertexIT\Voiler\View\Components\Form;
use VertexIT\Voiler\View\Components\Inputs\Checkbox;
use VertexIT\Voiler\View\Components\Inputs\Cropper;
use VertexIT\Voiler\View\Components\Inputs\Date;
use VertexIT\Voiler\View\Components\Inputs\Input;
use VertexIT\Voiler\View\Components\Inputs\Radio;
use VertexIT\Voiler\View\Components\Inputs\Select;
use VertexIT\Voiler\View\Components\Inputs\Textarea;
use VertexIT\Voiler\View\Components\Inputs\Time;
use VertexIT\Voiler\View\Components\Inputs\Toggle;
use VertexIT\Voiler\View\Components\Inputs\Uppy;
use VertexIT\Voiler\View\Components\Inputs\WorkTime;
use VertexIT\Voiler\View\Components\Inputs\WorkTimeDay;
use VertexIT\Voiler\View\Components\Modal;
use VertexIT\Voiler\View\Components\ModalButton;
use VertexIT\Voiler\View\Components\Multiple;
use VertexIT\Voiler\View\Components\MultipleRow;
use VertexIT\Voiler\View\Components\Translated;

class VoilerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'voiler');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'voiler');
        $this->registerRoutes();
        $this->registerPolicies();
        $this->registerVoilerComponents();

        if ($this->app->runningInConsole()) {
            $this->registerPublishableFiles();
            $this->registerCommands();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'voiler');
    }

    protected function registerRoutes(): void
    {
        Route::macro('voilerResource', function($uri, $controller) {
            Route::as('admin.')->middleware(config('voiler.middleware'))->group(function() use ($uri, $controller) {
                $model = Str::of($uri)->singular()->slug('_')->camel();

                Route::as("{$uri}.")->prefix($uri)->group(function() use ($controller, $model) {
                    Route::get("clone/{{$model}}", [$controller, 'edit'])->name('clone');
                    Route::put('restore', [$controller, 'restore'])->name('restore');
                    Route::put('update-priority', [$controller, 'updatePriority'])->name('updatePriority');
                    Route::delete('force-delete', [$controller, 'forceDelete'])->name('forceDelete');
                });

                Route::resource($uri, $controller)
                    ->parameters([
                        $uri => $model,
                    ]);
            });
        });

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }

    protected function registerPolicies(): void
    {
        $policies = [
            'VertexIT\Voiler\Models\VoilerUser' => 'VertexIT\Voiler\Policies\UserPolicy',
            'VertexIT\Voiler\Models\Permission' => 'VertexIT\Voiler\Policies\PermissionPolicy',
            'VertexIT\Voiler\Models\Role' => 'VertexIT\Voiler\Policies\RolePolicy',
            'VertexIT\Voiler\Models\Activity' => 'VertexIT\Voiler\Policies\ActivityPolicy',
            'VertexIT\Voiler\Models\Profile' => 'VertexIT\Voiler\Policies\ProfilePolicy',
        ];

        foreach ($policies as $key => $value) {
            Gate::policy($key, $value);
        }

        Gate::before(function($user) {
            return $user->hasRole('superadmin') ? true : null;
        });

        Gate::guessPolicyNamesUsing(function(string $modelClass) {
            $policy = str_replace('Models', 'Policies\\Admin', $modelClass . 'Policy');

            return ltrim($policy, '\\');
        });
    }

    protected function registerPublishableFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('voiler.php'),
            __DIR__ . '/../../config/navigation.php' => config_path('navigation.php'),
        ], 'voiler-config');

        $this->publishes([
            __DIR__ . '/../../resources/js' => resource_path('js/vendor'),
            __DIR__ . '/../../resources/css' => resource_path('css/vendor'),
            __DIR__ . '/../../.gitignore' => '.gitignore',
            __DIR__ . '/../../package.json' => 'package.json',
        ], 'voiler-assets');

        $this->publishes([
            __DIR__ . '/../../.gitignore' => '.gitignore',
        ], 'voiler-gitignore');

        $this->publishes([
            __DIR__ . '/../../webpack.mix.js' => 'webpack.mix.js',
            __DIR__ . '/../../tailwind.config.js' => 'tailwind.config.js',
        ], 'voiler-build-config');

        $this->publishes([
            __DIR__ . '/../../database/seeders' => database_path('seeders'),
        ], 'voiler-seeders');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views'),
        ], 'voiler-views');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            PublishFromPackagesCommand::class,
            VoilerGenerateCommand::class,
            VoilerControllerMakeCommand::class,
            VoilerAPIControllerMakeCommand::class,
            VoilerRequestMakeCommand::class,
            VoilerPolicyMakeCommand::class,
            VoilerMigrationMakeCommand::class,
            VoilerFactoryMakeCommand::class,
            VoilerSeederMakeCommand::class,
            VoilerDatatableServiceMakeCommand::class,
            VoilerIndexViewModelMakeCommand::class,
            VoilerFormViewModelMakeCommand::class,
            VoilerFormViewMakeCommand::class,
            VoilerIndexViewMakeCommand::class,
            VoilerModelMakeCommand::class,
        ]);
    }

    private function registerVoilerComponents()
    {
        Blade::componentNamespace('VertexIT\\Voiler\\View\\Components', 'voiler');

        Blade::component('breadcrumb', Breadcrumb::class);
        Blade::component('form', Form::class);
        Blade::component('modal-button', ModalButton::class);
        Blade::component('modal', Modal::class);
        Blade::component('multiple', Multiple::class);
        Blade::component('multiple-row', MultipleRow::class);
        Blade::component('translated', Translated::class);
        Blade::component('inputs.checkbox', Checkbox::class);
        Blade::component('inputs.cropper', Cropper::class);
        Blade::component('inputs.date', Date::class);
        Blade::component('inputs.file', File::class);
        Blade::component('inputs.input', Input::class);
        // Blade::component('inputs.multi-input', MultiInput::class);
        Blade::component('inputs.radio', Radio::class);
        Blade::component('inputs.select', Select::class);
        Blade::component('inputs.textarea', Textarea::class);
        Blade::component('inputs.time', Time::class);
        Blade::component('inputs.toggle', Toggle::class);
        Blade::component('inputs.uppy', Uppy::class);
        Blade::component('inputs.work-time', WorkTime::class);
        Blade::component('inputs.work-time-day', WorkTimeDay::class);
    }
}
