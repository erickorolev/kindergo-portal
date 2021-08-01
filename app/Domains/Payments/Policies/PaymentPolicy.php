<?php

declare(strict_types=1);

namespace Domains\Payments\Policies;

use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list payments');
    }

    public function view(User $user, Payment $model): bool
    {
        return $user->hasPermissionTo('view payments');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create payments');
    }

    public function update(User $user, Payment $model): bool
    {
        return $user->hasPermissionTo('update payments');
    }

    public function delete(User $user, Payment $model): bool
    {
        return $user->hasPermissionTo('delete payments');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete payments');
    }

    public function restore(User $user, Payment $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Payment $model): bool
    {
        return false;
    }
}
