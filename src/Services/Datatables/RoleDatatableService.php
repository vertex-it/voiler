<?php

namespace VertexIT\Voiler\Services\Datatables;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Role;
use VertexIT\Voiler\Services\BaseDatatableService;

class RoleDatatableService extends BaseDatatableService
{
    public function addColumns($datatables)
    {
        return $datatables->addColumn('permissions', function ($role) {
            return view('blade-components::components.modal-button', [
                'id' => 'permissions-modal',
                'content' => implode('<br>', $role->permissions->pluck('name')->toArray()),
                'buttonClass' => 'btn-light btn-sm',
            ]);
        })
            ->addColumn('users', function ($role) {
                return view('blade-components::components.modal-button', [
                    'id' => 'users-modal',
                    'content' => implode('<br>', $role->users->pluck('name')->toArray()),
                    'buttonClass' => 'btn-light btn-sm',
                ]);
            });
    }

    public function prepareQuery(Request $request)
    {
        // TODO: Authorization
        return Role::with('permissions', 'users')->withTrashed();
    }
}