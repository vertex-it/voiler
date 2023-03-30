<?php

namespace VertexIT\Voiler\Console\MakeCommands;

use VertexIT\Voiler\Services\GuesserService;

class VoilerFormViewModelMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-form-view-model';
    protected $description = 'Create a new Voiler form view model class';
    protected $type = 'FormViewModel';

    protected string $stub = '/stubs/voiler-form-view-model.stub';
    protected string $defaultNamespace = '\\App\\ViewModels\\Admin\\Form';

    public function buildReplace(): array
    {
        $resource = GuesserService::fromFormViewModelName($this->argument('name'));

        return [
            '{{ model }}' => $resource['model'],
            '{{ nameSingular }}' => $resource['name_singular'],
        ];
    }
}