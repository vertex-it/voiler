<?php

namespace VertexIT\Voiler\Policies;

use VertexIT\Voiler\Services\GuesserService;
use Illuminate\Auth\Access\HandlesAuthorization;
use VertexIT\Voiler\Models\VoilerUser;

class BasePolicy
{
    use HandlesAuthorization;

    protected array $resource;

    public function __construct()
    {
        $this->resource = GuesserService::fromPolicyName($this::class);
    }

    public function viewAny(VoilerUser $user): bool
    {
        return $this->hasPermissionTo($user, 'viewAny');
    }

    public function view(VoilerUser $user, $model): bool
    {
        return $this->hasPermissionTo($user, 'view') && $model->isOwnedByUser($user);
    }

    public function create(VoilerUser $user): bool
    {
        return $this->hasPermissionTo($user, 'create');
    }

    public function update(VoilerUser $user, $model): bool
    {
        return $this->hasPermissionTo($user, 'update') && $model->isOwnedByUser($user);
    }

    public function delete(VoilerUser $user, $model): bool
    {
        return $this->hasPermissionTo($user, 'delete') && $model->isOwnedByUser($user);
    }

    public function restore(VoilerUser $user, $model): bool
    {
        return $this->hasPermissionTo($user, 'restore') && $model->isOwnedByUser($user);
    }

    public function forceDelete(VoilerUser $user, $model): bool
    {
        return $this->hasPermissionTo($user, 'forceDelete') && $model->isOwnedByUser($user);
    }

    private function hasPermissionTo(VoilerUser $user, $action): bool
    {
        $permissionName = $this->getPermissionName($action);

        return $user->hasPermissionTo($permissionName);
    }

    private function getPermissionName($permission): string
    {
        return $this->resource['name'] . ' ' . $permission;
    }
}
