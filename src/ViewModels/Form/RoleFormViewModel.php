<?php

namespace VertexIT\Voiler\ViewModels\Form;

use App\Models\Admin\User;
use VertexIT\Voiler\Models\Permission;
use VertexIT\Voiler\Models\Role;

class RoleFormViewModel extends BaseFormViewModel
{
    public $role;

    public function __construct(Role $role)
    {
        parent::__construct($role);

        $this->role = $role;
    }

    public function permissions()
    {
        return Permission::where('name', 'not like', 'site%')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function activePermissions()
    {
        return $this->role ? $this->role->permissions->pluck('id')->toArray() : [];
    }

    public function users()
    {
        return User::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function activeUsers()
    {
        return $this->role ? $this->role->users->pluck('id')->toArray() : [];
    }
}