<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerControllerMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-controller';
    protected $description = 'Create a new Voiler controller class';
    protected $type = 'Controller';

    protected string $stub = '/stubs/voiler-controller.stub';
    protected string $defaultNamespace = '\\App\\Http\\Controllers\\Admin';
}