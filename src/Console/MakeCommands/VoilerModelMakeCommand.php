<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerModelMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-model';
    protected $description = 'Create a new Voiler model class';
    protected $type = 'Model';

    protected string $stub = '/stubs/voiler-model.stub';
    protected string $defaultNamespace = '\\App\\Models';
}