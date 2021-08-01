<?php

declare(strict_types=1);

namespace Domains\Children\Policies;

use Domains\Children\Models\Child;
use Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ChildPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list children');
    }

    public function view(User $user, Child $model): bool
    {
        return $user->hasPermissionTo('view children');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create children');
    }

    public function update(User $user, Child $model): bool
    {
        return $user->hasPermissionTo('update children');
    }

    public function delete(User $user, Child $model): bool
    {
        return $user->hasPermissionTo('delete children');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete children');
    }

    public function restore(User $user, Child $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Child $model): bool
    {
        return false;
    }
}
