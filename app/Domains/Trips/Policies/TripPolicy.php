<?php

declare(strict_types=1);

namespace Domains\Trips\Policies;

use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list trips');
    }

    public function view(User $user, Trip $model): bool
    {
        return $user->hasPermissionTo('view trips');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create trips');
    }

    public function update(User $user, Trip $model): bool
    {
        return $user->hasPermissionTo('update trips');
    }

    public function delete(User $user, Trip $model): bool
    {
        return $user->hasPermissionTo('delete trips');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete trips');
    }

    public function restore(User $user, Trip $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Trip $model): bool
    {
        return false;
    }
}
