<?php

namespace VertexIT\Voiler\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Multiple extends Component
{
    public $label;
    public $sortable;
    public $id;

    public function __construct($label = null, $sortable = true)
    {
        $this->label = $label;
        $this->sortable = $sortable;
        $this->id = Str::random(20);
    }

    public function render()
    {
        return view('voiler::components.multiple');
    }
}
