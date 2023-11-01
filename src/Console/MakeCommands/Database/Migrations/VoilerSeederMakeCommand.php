<?php

namespace VertexIT\Voiler\Console\MakeCommands\Database\Migrations;

use Illuminate\Support\Str;
use VertexIT\Voiler\Console\MakeCommands\BaseVoilerMakeCommand;
use VertexIT\Voiler\Services\GuesserService;

class VoilerSeederMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-seeder';
    protected $description = 'Create a new Voiler seeder class';
    protected $type = 'Seeder';

    protected string $stub = '/Database/Migrations/stubs/voiler-seeder.stub';
    protected string $defaultNamespace = '\\Database\\Seeders';

    protected function rootNamespace(): string
    {
        return 'Database\Seeders\\';
    }

    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        if (is_dir($this->laravel->databasePath().'/seeds')) {
            return $this->laravel->databasePath().'/seeds/'.$name.'.php';
        }

        return $this->laravel->databasePath().'/seeders/'.$name.'.php';
    }

    public function buildReplace(): array
    {
        $resource = GuesserService::fromSeederName($this->argument('name'));

        return [
            '{{ model }}' => $resource['model'],
        ];
    }
}