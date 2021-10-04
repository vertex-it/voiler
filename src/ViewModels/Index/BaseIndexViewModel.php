<?php

namespace VertexIT\Voiler\ViewModels\Index;

use Spatie\ViewModels\ViewModel;
use VertexIT\Voiler\Services\GuesserService;

class BaseIndexViewModel extends ViewModel
{
    public $model;
    public array $resource = [];

    public function __construct($model = null)
    {
        $this->model = $model;
        $this->resource = GuesserService::fromIndexViewModelName($this::class);
    }

    public function getModelRoute($action, $model = null)
    {
        return route(
            implode('.', [
                $this->resource['route_name'],
                $action
            ]),
            $model
        );
    }
}
