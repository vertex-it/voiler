<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerRequestMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-request';
    protected $description = 'Create a new Voiler request class';
    protected $type = 'Request';

    protected string $stub = '/stubs/voiler-request.stub';
    protected string $defaultNamespace = '\\App\\Http\\Requests\\Admin';
}