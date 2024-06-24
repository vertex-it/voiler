<?php

namespace VertexIT\Voiler\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use VertexIT\Voiler\Services\GuesserService;

class FixImageURLsCommand extends Command
{
    protected $signature = 'voiler:fix-image-urls 
                            { oldURL : URL to be replaced } 
                            { newURL : URL to be replaced with } 
                            { --pretend : Whether the changes should be applied on database or just shown in console }';

    protected $description = 'Replace staging image url path with production path.';

    public function handle()
    {
        $count = 0;

        $modelsPath = app_path('Models');

        $modelFiles = File::allFiles($modelsPath);

        // 1. Get files and prepare model names
        $models = [];
        foreach ($modelFiles as $modelFile) {
            $models[] = $modelFile->getFilenameWithoutExtension();
        }

        // 2. Iterate through each model
        foreach ($models as $model) {
            $resource = GuesserService::fromModelName($model);

            $records = $resource['model_fqn']::all();

            // 3. Iterate through each record
            foreach ($records as $record) {
                $updateArray = [];

                foreach ($record->getAttributes() as $column => $value) {
                    if (str_contains($value, $this->argument('oldURL'))) {
                        $updateArray[$column] = str_replace(
                            $this->argument('oldURL'),
                            $this->argument('newURL'),
                            $value
                        );
                    }
                }

                if (count($updateArray) === 0) {
                    continue;
                }

                foreach ($updateArray as $k => $v) {
                    $this->newLine();
                    $this->info("<options=bold;bg=green;> Change </>\t #" . ++$count);
                    $this->info("<options=bold;bg=green;> Column </>\t $k");
                    $this->info("<options=bold;bg=green;> Previous </>\t {$record->$k}");
                    $this->info("<options=bold;bg=green;> New </>\t\t $v");
                    $this->line('------------------------------------------------------------');
                }

                if (! $this->option('pretend')) {
                    $record->update($updateArray);
                }
            }
        }
    }
}