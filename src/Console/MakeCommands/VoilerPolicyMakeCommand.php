<?php

namespace VertexIT\Voiler\Console\MakeCommands;

class VoilerPolicyMakeCommand extends BaseVoilerMakeCommand
{
    protected $name = 'voiler:make-policy';
    protected $description = 'Create a new Voiler policy class';
    protected $type = 'Policy';

    protected string $stub = '/stubs/voiler-policy.stub';
    protected string $defaultNamespace = '\\App\\Policies\\Admin';
}