<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Toggle extends BaseInputComponent
{
    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline);
    }

    public function render()
    {
        return view('voiler::components.inputs.toggle');
    }
}
