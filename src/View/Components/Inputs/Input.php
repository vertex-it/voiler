<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Input extends BaseInputComponent
{
    public string $type;

    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $type = 'text',
        $width = null
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline, $width);

        $this->type = $type;
    }

    public function render()
    {
        return view('voiler::components.inputs.input');
    }
}
