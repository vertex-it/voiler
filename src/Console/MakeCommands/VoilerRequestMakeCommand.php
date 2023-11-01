<?php

namespace VertexIT\Voiler\Console\MakeCommands;

use VertexIT\Voiler\Services\GuesserService;

class VoilerRequestMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-request';
    protected $description = 'Create a new Voiler request class';
    protected $type = 'Request';

    protected string $stub = '/stubs/voiler-request.stub';
    protected string $defaultNamespace = '\\App\\Http\\Requests\\Admin';

    public function buildReplace(): array
    {
        $resource = GuesserService::fromRequestName($this->argument('name'));

        return [
            '{{ database_table }}' => $resource['database_table'],
            '{{ name_singular }}' => $resource['name_singular'],
        ];
    }
}