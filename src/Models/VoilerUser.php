<?php

namespace VertexIT\Voiler\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Spatie\Permission\Traits\HasRoles;

abstract class VoilerUser extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasRoles;

    protected $guarded = ['roles'];

    protected string | array $slugMap = 'name';

    protected string $titleColumn = 'name';

    protected $hidden = ['password', 'remember_token'];

    /**
     * Check if user is owner for specific resource.
     */
    public function isOwner($id): bool
    {
        return $this->id === $id;
    }
}
