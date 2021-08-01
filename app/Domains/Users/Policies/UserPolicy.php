<?php

declare(strict_types=1);

namespace Domains\Users\Policies;

use Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Domains\Users\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Domains\Users\Models\User  $user
     * @param  \Domains\Users\Models\User  $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('view users');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Domains\Users\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Domains\Users\Models\User  $user
     * @param  \Domains\Users\Models\User  $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('update users');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Domains\Users\Models\User  $user
     * @param  \Domains\Users\Models\User  $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete users');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete users');
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
