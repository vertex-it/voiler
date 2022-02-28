<?php

namespace VertexIT\Voiler\ViewModels\Index;

class ActivityIndexViewModel extends BaseIndexViewModel
{
    public array $actions = [
        'show',
        'edit',
        'clone',
        'destroy',
        'forceDelete',
        'restore',
        'updatePriority',
    ];
}
