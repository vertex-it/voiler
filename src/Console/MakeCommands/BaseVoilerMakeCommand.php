<?php

namespace VertexIT\Voiler\Console\MakeCommands;

use Illuminate\Console\GeneratorCommand;

abstract class BaseVoilerMakeCommand extends GeneratorCommand
{
    protected string $stub = '';
    protected string $defaultNamespace = '';

    protected function getStub(): string
    {
        return $this->resolveStubPath($this->stub);
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->defaultNamespace;
    }

    public function buildReplace(): array
    {
        return [];
    }

    protected function buildClass($name): string
    {
        $replace = $this->buildReplace();

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
}