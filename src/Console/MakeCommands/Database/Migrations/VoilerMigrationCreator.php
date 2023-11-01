<?php

namespace VertexIT\Voiler\Console\MakeCommands\Database\Migrations;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Filesystem\Filesystem;

class VoilerMigrationCreator extends MigrationCreator
{
    public function __construct(Filesystem $files, $customStubPath = null)
    {
        parent::__construct($files, $customStubPath);
    }

    public function stubPath()
    {
        return __DIR__ . '/stubs';
    }
}