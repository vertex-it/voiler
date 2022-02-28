<?php

namespace VertexIT\Voiler\ViewModels\Index;

use Spatie\ViewModels\ViewModel;
use VertexIT\Voiler\Services\GuesserService;

class BaseIndexViewModel extends ViewModel
{
    public $model;
    public array $resource = [];
    public array $actions = [
        'create',
        'show',
        'edit',
        'clone',
        'destroy',
        'forceDelete',
        'restore',
        'updatePriority',
    ];

    public function __construct($model = null)
    {
        $this->model = $model;
        $this->resource = GuesserService::fromIndexViewModelName($this::class);
    }

    public function getModelRoute($action, $model = null): ?string
    {
        if (! in_array($action, $this->actions, true)) {
            return null;
        }

        return route(
            implode('.', [
                $this->resource['route_name'],
                $action
            ]),
            $model
        );
    }
}
