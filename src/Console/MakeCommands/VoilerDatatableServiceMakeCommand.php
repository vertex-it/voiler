<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerDatatableServiceMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-datatable-service';
    protected $description = 'Create a new Voiler datatable service class';
    protected $type = 'DatatableService';

    protected string $stub = '/stubs/voiler-datatable-service.stub';
    protected string $defaultNamespace = '\\App\\Services\\Admin\\Datatable';
}