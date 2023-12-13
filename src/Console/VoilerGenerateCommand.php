<?php

namespace VertexIT\Voiler\Console;

use Illuminate\Console\Command;
use VertexIT\Voiler\Services\GuesserService;

class VoilerGenerateCommand extends Command
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

        $this->call('voiler:make-api-controller', [
            'name' => $resource['api_controller'],
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

        $this->call('voiler:make-factory', [
            'name' => $resource['factory'],
        ]);

        $this->call('voiler:make-migration', [
            'name' => 'create_' . $resource['database_table'] . '_table',
        ]);

        $this->call('voiler:make-seeder', [
            'name' => $resource['seeder'],
        ]);

        $this->generateNavigation($resource);

        $this->generateSeederCall($resource);

        $this->call('voiler:make-form-view', [
            'name' => $resource['name'],
        ]);

        $this->call('voiler:make-index-view', [
            'name' => $resource['name'],
        ]);

        $this->call('make:resource --collection', [
            'name' => $resource['api_resource'],
        ]);

        $this->generateWebRoutes($resource);
        $this->generateAPIRoutes($resource);
    }

    private function generateWebRoutes(array $resource): void
    {
        $route = "Route::voilerResource('{$resource['route_suffix']}', {$resource['controller']}::class);";
        $import = "use " . ltrim($resource['controller_fqn'], '\\') . ";";

        $routes = file('routes/web.php', FILE_IGNORE_NEW_LINES);

        if (! in_array($import, $routes, true)) {
            array_splice($routes, 2, 0, $import);
        }

        if (! in_array($route, $routes, true)) {
            $routes[] = $route;

            $this->components->info('Web routes are created successfully.');
        }

        file_put_contents('routes/web.php', implode("\n", $routes));

        $this->info('Web routes at [routes/api.php] generated successfully.');
    }

    private function generateAPIRoutes(array $resource): void
    {
        $route = "Route::apiResource('{$resource['route_suffix']}', {$resource['api_controller']}::class);";
        $import = "use " . ltrim($resource['api_controller_fqn'], '\\') . ";";

        $routes = file('routes/api.php', FILE_IGNORE_NEW_LINES);

        if (! in_array($import, $routes, true)) {
            array_splice($routes, 2, 0, $import);
        }

        if (! in_array($route, $routes, true)) {
            $routes[] = $route;
        }

        file_put_contents('routes/api.php', implode("\n", $routes));

        $this->components->info('API routes at [routes/api.php] generated successfully.');
    }

    private function generateNavigation(array $resource): void
    {
        $navigation = file('config/navigation.php', FILE_IGNORE_NEW_LINES);

        $entry = [
            "        '" . ucfirst($resource['title_plural']) . "' => [",
            "            [",
            "                'name' => 'Show all',",
            "                'route' => '" . $resource['route_name'] . ".index',",
            "                'can' => 'view " . $resource['model'] . "',",
            "            ],",
            "            [",
            "                'name' => 'Create new',",
            "                'route' => '" . $resource['route_name'] . ".create',",
            "                'can' => 'create " . $resource['model'] . "',",
            "            ],",
            "            'can' => 'view " . $resource['model'] . "',",
            "        ],",
        ];

        $index = array_search('        // VOILER GENERATED PAGES', $navigation, true);

        if (! $index) {
            $index = array_search("    '_pages' => [", $navigation, true) + 1;
        }

        array_splice($navigation, $index, 0, $entry);

        file_put_contents('config/navigation.php', implode("\n", $navigation));

        $this->info('Navigation entry at [config/navigation.php] generated successfully.');
    }

    private function generateSeederCall(array $resource): void
    {
        $databaseSeeder = file('database/seeders/DatabaseSeeder.php', FILE_IGNORE_NEW_LINES);

        $entry = "        (new {$resource['seeder']}())->run();";

        $index = array_search("    }", $databaseSeeder, true);

        array_splice($databaseSeeder, $index, 0, $entry);

        file_put_contents('database/seeders/DatabaseSeeder.php', implode("\n", $databaseSeeder));

        $this->info('Seeder call at [database/seeders/DatabaseSeeder.php] generated successfully.');
    }
}