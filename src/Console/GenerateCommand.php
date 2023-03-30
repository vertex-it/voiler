<?php

namespace VertexIT\Voiler\Console;

use App\Http\Controllers\Admin\InvoiceController;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use VertexIT\Voiler\Services\GuesserService;

class GenerateCommand extends Command
{
    protected $signature = 'voiler:generate {resourceName}';

    protected $description = 'Make model, controller, etc. for Voiler resource';

    protected array $resource;

    public function handle()
    {
        $resource = GuesserService::fromModelName($this->argument('resourceName'));

        $this->call('voiler:make-controller', [
            'name' => $resource['controller'],
        ]);

        $this->call('voiler:make-model', [
            'name' => $resource['name'],
        ]);

        $this->call('voiler:make-request', [
            'name' => $resource['request'],
        ]);

        $this->call('voiler:make-policy', [
            'name' => $resource['policy'],
        ]);

        $this->call('voiler:make-datatable-service', [
            'name' => $resource['datatable_service'],
        ]);

        $this->call('voiler:make-form-view-model', [
            'name' => $resource['form_view_model'],
        ]);

        $this->call('voiler:make-index-view-model', [
            'name' => $resource['index_view_model'],
        ]);

        $this->call('make:factory', [
            'name' => $resource['factory'],
            '--model' => $resource['model'],
        ]);

        $this->call('make:migration', [
            'name' => 'create_' . $resource['database_table'] . '_table',
        ]);

        $this->call('make:seeder', [
            'name' => $resource['seeder'],
        ]);

        $this->call('voiler:make-form-view', [
            'name' => $resource['name'],
        ]);

        $this->call('voiler:make-index-view', [
            'name' => $resource['name'],
        ]);

        $this->generateRoute($resource);

        // TODO Install permissions
    }

    private function generateRoute(array $resource)
    {
        $route = "Route::voilerResource('{$resource['name_plural']}', {$resource['controller']}::class);";
        $import = "use " . ltrim($resource['controller_fqn'], '\\') . ";";

        $routes = file('routes/web.php', FILE_IGNORE_NEW_LINES);

        if (! in_array($import, $routes, true)) {
            array_splice($routes, 2, 0, $import);
        }

        if (! in_array($route, $routes, true)) {
            $routes[] = $route;

            $this->components->info('Route is created successfully.');
        }

        file_put_contents('routes/web.php', implode("\n", $routes));
    }
}