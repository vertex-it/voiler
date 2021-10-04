<?php

namespace VertexIT\Voiler\Services\Datatables;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Permission;
use VertexIT\Voiler\Services\BaseDatatableService;

class PermissionDatatableService extends BaseDatatableService
{
    public function addColumns($datatables)
    {
        return $datatables->addColumn('roles', function ($permission) {
            return view('blade-components::components.modal-button', [
                'id' => 'roles-modal',
                'content' => implode('<br>', $permission->roles->pluck('name')->toArray()),
                'buttonClass' => 'btn-light btn-sm',
            ]);
        })
            ->addColumn('users', function ($permission) {
                return view('blade-components::components.modal-button', [
                    'id' => 'users-modal',
                    'content' => implode('<br>',
                        array_merge(...$permission->roles->map(function ($role) {
                            return $role->users->pluck('name')->toArray();
                        })->toArray())
                    ),
                    'buttonClass' => 'btn-light btn-sm',
                ]);
            });
    }

    public function prepareQuery(Request $request)
    {
        // TODO: Authorization
        return Permission::with('roles.users')->withTrashed();
    }
}
