<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerIndexViewMakeCommand extends BaseVoilerViewMakeCommand
{
    protected $signature = 'voiler:make-index-view {name}';
    protected $description = 'Make an index Blade view';
    protected string $viewName = 'index.blade.php';
    protected string $stub = '/stubs/voiler-index-view.stub';
}