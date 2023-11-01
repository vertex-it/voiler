<?php

namespace VertexIT\Voiler\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => ['required', 'exists:users,username'],
            'password' => ['required'],
        ];
    }
}
