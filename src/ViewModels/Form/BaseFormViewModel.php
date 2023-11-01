<?php

namespace VertexIT\Voiler\ViewModels\Form;

use Spatie\ViewModels\ViewModel;
use VertexIT\Voiler\Services\GuesserService;
use Illuminate\Support\Facades\Route;

class BaseFormViewModel extends ViewModel
{
    public $action = '';
    public $model = null;
    public $formTitle = '';

    public array $resource = [];

    public function __construct($model)
    {
        $this->action = last(explode('.', Route::currentRouteName()));
        $this->model = $model;
        $this->formTitle = $model?->getTitle();
        $this->resource = GuesserService::fromFormViewModelName($this::class);
    }

    public function getFormAction()
    {
        if ($this->action === 'edit') {
            return route($this->resource['route_name'] . '.update', $this->model);
        }

        return route($this->resource['route_name'] . '.store');
    }

    public function getFormMethod()
    {
        if ($this->action === 'edit') {
            return 'PUT';
        }

        return 'POST';
    }

    public function getFormTitle()
    {
        if ($this->action === 'edit') {
            return 'Izmjenite ' . $this->formTitle;
        }

        if ($this->action === 'clone') {
            return 'Kloniranje - ' . $this->formTitle;
        }

        return __('Add ' . $this->resource['title_singular']);
    }
}
