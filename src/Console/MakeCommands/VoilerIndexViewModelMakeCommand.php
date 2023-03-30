<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerIndexViewModelMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-index-view-model';
    protected $description = 'Create a new Voiler index view model class';
    protected $type = 'IndexViewModel';

    protected string $stub = '/stubs/voiler-index-view-model.stub';
    protected string $defaultNamespace = '\\App\\ViewModels\\Admin\\Index';
}