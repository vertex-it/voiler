<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Textarea extends BaseInputComponent
{
    public bool $richText;
    public int $rows;

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
        $rows = 7,
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline, $width);

        $this->richText = $richText;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('voiler::components.inputs.textarea');
    }
}
