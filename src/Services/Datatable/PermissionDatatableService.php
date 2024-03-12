<?php

namespace VertexIT\Voiler\Services\Datatable;

use Illuminate\Http\Request;
use VertexIT\Voiler\Models\Permission;
use VertexIT\Voiler\Services\BaseDatatableService;

class PermissionDatatableService extends BaseDatatableService
{
    public function addColumns($datatables)
    {
        return $datatables->addColumn('roles', function ($permission) {
            $roles = $permission->roles->pluck('name')->toArray();

            if (count($roles) === 0) {
                return 'n/a';
            }

            return view('voiler::components.modal-button', [
                'id' => 'roles-modal',
                'title' => __('voiler::interface.roles'),
                'content' => implode('<br>', $roles),
                'buttonClass' => 'btn btn-transparent text-gray-500 rounded-full hover:bg-gray-200 px-2',
            ]);
        })
            ->addColumn('users', function ($permission) {
                $users = array_merge(...$permission->roles->map(function ($role) {
                    return $role->users->pluck('name')->toArray();
                })->toArray());

                if (count($users) === 0) {
                    return 'n/a';
                }

                return view('voiler::components.modal-button', [
                    'id' => 'users-modal',
                    'title' => __('voiler::interface.users'),
                    'content' => implode('<br>', $users),
                    'buttonClass' => 'btn btn-transparent text-gray-500 rounded-full hover:bg-gray-200 px-2',
                ]);
            });
    }

    public function prepareQuery(Request $request)
    {
        return Permission::with('roles.users')->withTrashed();
    }
}
