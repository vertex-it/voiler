<?php

namespace VertexIT\Voiler\Http\Requests;

class PermissionRequest extends BaseFormRequest
{
    protected array $baseRules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'description' => 'nullable|string',
        'roles.*' => 'required|integer|exists:roles,id',
    ];

    public function getPUTRules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->permission->id,
        ];
    }
}