<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerFormViewMakeCommand extends BaseVoilerViewMakeCommand
{
    protected $signature = 'voiler:make-form-view {name}';
    protected $description = 'Make an form Blade view';
    protected string $viewName = 'form.blade.php';
    protected string $stub = '/stubs/voiler-form-view.stub';

    public function getStubVariables($resource): array
    {
        return [
            '{{ nameSingular }}' => $resource['name_singular'],
        ];
    }
}