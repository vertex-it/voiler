<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerAPIControllerMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-api-controller';
    protected $description = 'Create a new Voiler API controller class';
    protected $type = 'Controller';

    protected string $stub = '/stubs/voiler-api-controller.stub';
    protected string $defaultNamespace = '\\App\\Http\\Controllers\\API';
}