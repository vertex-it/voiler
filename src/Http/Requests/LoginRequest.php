<?php

namespace VertexIT\Voiler\Http\Requests;

use Illuminate\Support\Facades\Config;
use VertexIT\Voiler\Actions\Fortify\PasswordValidationRules;

class LoginRequest extends \Laravel\Fortify\Http\Requests\LoginRequest
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
            'remember' => ['sometimes', 'boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->username_or_email) {
            if (str_contains($this->username_or_email, '@')) {
                Config::set('fortify.username', 'email');
                $this->merge([
                    'email' => $this->username_or_email,
                ]);
            } else {
                Config::set('fortify.username', 'username');
                $this->merge([
                    'username' => $this->username_or_email,
                ]);
            }

            $this->request->remove('username_or_email');
        }
    }
}
