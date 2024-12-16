<?php

namespace VertexIT\Voiler\View\Components\Inputs;

use VertexIT\Voiler\View\Components\BaseInputComponent;

class Uppy extends BaseInputComponent
{
    public string $key;
    public ?string $route;
    public int $maxFileSize;
    public bool $single;

    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $route = null,
        $maxFileSize = 2,
        $single = false,
        $imagesUpload = true,
    ) {
        parent::__construct($name, $label, $placeholder, $value, $required, $comment, $inline);

        $this->key = uniqid();
        $this->route = $route;
        $this->maxFileSize = $maxFileSize;
        $this->single = $single;
    }

    public function render()
    {
        return view('voiler::components.inputs.uppy');
    }

    public function getId()
    {
        return "uppy-modal-{$this->key}";
    }
}
