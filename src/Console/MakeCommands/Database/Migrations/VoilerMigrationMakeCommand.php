<?php

namespace VertexIT\Voiler\Console\MakeCommands\Database\Migrations;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Support\Composer;

class VoilerMigrationMakeCommand extends MigrateMakeCommand
{
    protected $signature = 'voiler:make-migration {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration (Deprecated)}';

    public function __construct(VoilerMigrationCreator $creator, Composer $composer)
    {
        parent::__construct($creator, $composer);
    }
}