<?php

namespace VertexIT\Voiler\Console\MakeCommands\Database\Migrations;

use Illuminate\Database\Console\Factories\FactoryMakeCommand;
use VertexIT\Voiler\Services\GuesserService;

class VoilerFactoryMakeCommand extends FactoryMakeCommand
{
    protected $name = 'voiler:make-factory';

    protected function guessModelName($name): string
    {
        $resource = GuesserService::fromFactoryName($name);

        return $resource['model'];
    }

    protected function getStub()
    {
        return __DIR__ . '/stubs/factory.stub';
    }
}