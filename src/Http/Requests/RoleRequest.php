<?php

namespace VertexIT\Voiler\Http\Requests;

class RoleRequest extends BaseFormRequest
{
    protected array $baseRules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'description' => 'nullable|string',
        'permissions.*' => 'integer|exists:permissions,id',
        'users.*' => 'integer|exists:users,id',
    ];

    public function getPUTRules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->role->id,
        ];
    }

    protected array $PUTRules = [
        'name' => 'required|string|max:255|unique:roles,name,NULL,id',
    ];
}