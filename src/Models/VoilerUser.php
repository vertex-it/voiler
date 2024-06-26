<?php

namespace VertexIT\Voiler\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

abstract class VoilerUser extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        MustVerifyEmail,
        HasRoles,
        HasApiTokens;

    protected $guarded = ['roles'];

    protected string | array $slugMap = 'name';

    protected string $titleColumn = 'name';

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    public function isOwner($id): bool
    {
        return $this->id === $id;
    }

    protected static function booted()
    {
        static::creating(static function($user) {
            if (! $user->name) {
                $user->name = $user->username;
            }
        });
    }
}
