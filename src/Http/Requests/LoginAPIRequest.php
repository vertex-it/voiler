<?php

namespace VertexIT\Voiler\Http\Requests;

use Arr;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use VertexIT\Voiler\Actions\Fortify\PasswordValidationRules;

class LoginAPIRequest extends FormRequest
{
    use PasswordValidationRules;

    public function rules()
    {
        return [
            'username' => ['required_without:email', 'string', 'max:255'],
            'email' => [
                'required_without:username',
                'string',
                'email',
                'max:255',
            ],
            'password' => $this->passwordRules(confirmed: false),
            'refresh_token' => ['nullable'],
        ];
    }
}
