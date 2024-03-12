<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class WorkTimeDay extends BaseInputComponent
{
    public $workDay;

    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $workDay = null
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline);

        $this->workDay = $workDay;
    }

    public function render()
    {
        return view('voiler::components.inputs.work-time-day');
    }
}
