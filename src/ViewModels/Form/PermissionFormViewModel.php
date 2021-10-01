<?php

namespace VertexIT\Voiler\ViewModels\Form;

use VertexIT\Voiler\Models\Permission;
use VertexIT\Voiler\Models\Role;

class PermissionFormViewModel extends BaseFormViewModel
{
    public $permission;

    public function __construct(Permission $permission)
    {
        parent::__construct($permission);

        $this->permission = $permission;
    }

    public function roles()
    {
        return Role::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function activeRoles()
    {
        return $this->permission ? $this->permission->roles->pluck('id')->toArray() : [];
    }
}