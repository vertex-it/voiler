<?php

namespace VertexIT\Voiler\Console\MakeCommands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use VertexIT\Voiler\Services\GuesserService;

abstract class BaseVoilerViewMakeCommand extends Command
{
    protected Filesystem $files;
    protected string $stub = '';
    protected string $viewName = '';

    protected string $type = 'View';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $resource = GuesserService::fromModelName($this->argument('name'));

        $path = base_path("resources/views/admin/{$resource['view_path']}/{$this->viewName}");

        $this->makeDirectory(dirname($path));

        $contents = $this->getStubContents(
            __DIR__ . $this->stub,
            $this->getStubVariables($resource),
        );

        if (! $this->files->exists($path)) {
            $this->files->put($path, $contents);

            $this->components->info(
                sprintf('%s [%s] created successfully.', $this->type, $path)
            );
        } else {
            $this->components->error($path.' already exists.');
        }
    }

    public function getStubVariables($resource): array
    {
        return [];
    }

    public function getStubContents($stub , $replace): string
    {
        return str_replace(
            array_keys($replace),
            array_values($replace),
            file_get_contents($stub)
        );
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}