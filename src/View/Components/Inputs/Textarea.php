<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Textarea extends BaseInputComponent
{
    public bool $richText;

    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $richText = false,
        $width = null,
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline, $width);

        $this->richText = $richText;
    }

    public function render()
    {
        return view('voiler::components.inputs.textarea');
    }
}
