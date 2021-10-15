<?php

namespace VertexIT\Voiler\ViewModels\Index;

class RoleIndexViewModel extends BaseIndexViewModel
{
    public $datatableColumns = [
        'name',
        'description',
        'permissions',
        'users',
        '',
    ];
}
