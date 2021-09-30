<?php

namespace VertexIT\Voiler\Http\Requests;

use Illuminate\Support\Facades\Hash;

class ProfileRequest extends BaseFormRequest
{
    protected array $baseRules = [
        'name' => 'required|string|max:192',
        'email' => 'required|unique:users,email',
        'password' => 'required',
    ];

    public function getPUTRules(): array
    {
        return [
            'email' => 'required|unique:users,email,' . $this->profile->id,
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'password' => $this->password ? Hash::make($this->password) : $this->profile->password,
        ]);
    }
}