<?php

namespace VertexIT\Voiler\Services\Datatables;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Role;
use VertexIT\Voiler\Services\BaseDatatableService;

class RoleDatatableService extends BaseDatatableService
{
    public function addColumns($datatables)
    {
        return $datatables
            ->addColumn('permissions', function ($role) {
                $permissions = $role->permissions->pluck('name')->toArray();

                if (count($permissions) === 0) {
                    return 'n/a';
                }

                return view('blade-components::components.modal-button', [
                    'id' => 'permissions-modal',
                    'title' => __('voiler::interface.permissions'),
                    'content' => implode('<br>', $permissions),
                    'buttonClass' => 'btn btn-transparent text-gray-500 rounded-full hover:bg-gray-200 px-2',
                ]);
            })
            ->addColumn('users', function ($role) {
                $roles = $role->users->pluck('name')->toArray();

                if (count($roles) === 0) {
                    return 'n/a';
                }

                return view('blade-components::components.modal-button', [
                    'id' => 'users-modal',
                    'title' => __('voiler::interface.roles'),
                    'content' => implode('<br>', $roles),
                    'buttonClass' => 'btn btn-transparent text-gray-500 rounded-full hover:bg-gray-200 px-2',
                ]);
            });
    }

    public function prepareQuery(Request $request)
    {
        return Role::with('permissions', 'users')->withTrashed();
    }
}
