<?php

namespace VertexIT\Voiler\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules($confirmed = true): array
    {
        $rules = [
            'required',
            'string',
            new \Illuminate\Validation\Rules\Password(8),
        ];

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }
}
