<?php

namespace VertexIT\Voiler\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class BaseInputComponent extends Component
{
    public string $name;
    public ?string $label;
    public ?string $placeholder;
    public mixed $value;
    public bool $required;
    public ?string $comment;
    public ?bool $inline;
    public string $id;
    public $width;

    // FIX: Implement columns in all components
    // IDEA: Maybe we don't need all properties mapped, for example 'columns'
    public function __construct(
        $name,
        $label = null,
        $placeholder = null,
        $value = null,
        $required = false,
        $comment = null,
        $inline = null,
        $width = null
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->comment = $comment;
        $this->inline = $inline;
        $this->id = Str::random(6);
        $this->width = $width;
    }

    abstract public function render();

    public function getId()
    {
        $name = str_replace(['[', ']'], ['_', ''], $this->name);

        return 'bc_' . $name . '_' . $this->id;
    }

    public function getLabel()
    {
        return __($this->label ?? $this->getNameAsTitle());
    }

    public function getEscapedName()
    {
        return str_replace(['[', ']'], ['_', ''], $this->name);
    }

    public function getNameAsTitle()
    {
        return ucfirst(str_replace('_', ' ', $this->getEscapedName()));
    }

    public function getPlaceholder()
    {
        if (config('voiler.show_placeholder')) {
            return __(
                $this->placeholder ?? implode(' ', [
                    __('voiler::components.placeholder_prefix'),
                    strtolower($this->getLabel())
                ])
            );
        }

        return '';
    }

    public function outputRequired()
    {
        return $this->required ? ' required ' : '';
    }
}
