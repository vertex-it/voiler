<?php

namespace VertexIT\Voiler\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use VertexIT\Voiler\Services\GuesserService;

class GenerateTranslationsCommand extends Command
{
    protected Filesystem $files;

    protected $signature = 'voiler:generate-translations';

    protected $description = 'Generate models translation strings.';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $modelsPath = app_path('Models');

        $modelFiles = File::allFiles($modelsPath);

        $models = [];
        foreach ($modelFiles as $modelFile) {
            $models[] = $modelFile->getFilenameWithoutExtension();
        }

        $strings = [];
        foreach ($models as $model) {
            $resource = GuesserService::fromModelName($model);

            $strings['All ' . $resource['title_plural']] = 'All ' . $resource['title_plural'];
            $strings['Add ' . $resource['title_singular']] = 'Add ' . $resource['title_singular'];

            $columns = Schema::getColumnListing($resource['database_table']);

            foreach ($columns as $column) {
                $strings[$column] = $column;
            }
        }

        $path = base_path("lang/en.json");

        $this->makeDirectory(dirname($path));

        if (! $this->files->exists($path)) {
            $this->files->put($path, json_encode($strings, JSON_PRETTY_PRINT));

            $this->components->info(
                sprintf('Translation strings [%s] generated successfully.', $path)
            );
        } else {
            $this->components->error($path . ' already exists.');
        }
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}