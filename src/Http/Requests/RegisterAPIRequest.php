<?php

namespace VertexIT\Voiler\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use VertexIT\Voiler\Actions\Fortify\PasswordValidationRules;

class RegisterAPIRequest extends FormRequest
{
    use PasswordValidationRules;

    public function rules()
    {
        return [
            'name' => ['required_without:username', 'string', 'max:255'],
            'username' => ['required_without:name', 'string', 'max:255', Rule::unique(User::class)],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
        ];
    }
}
