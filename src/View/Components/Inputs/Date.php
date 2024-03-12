<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Date extends BaseInputComponent
{
    public $time;

    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $width = null,
        $time = null
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline, $width);

        $this->time = $time;
    }

    public function render()
    {
        return view('voiler::components.inputs.date');
    }
}
