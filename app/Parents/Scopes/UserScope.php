<?php

declare(strict_types=1);

namespace Parents\Scopes;

use Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Parents\Models\Model;

final class UserScope implements Scope
{
    private ?User $user;

    public function __construct(User $user = null)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        if (!$user) {
            $this->user = $authUser;
        } else {
            $this->user = $user;
        }
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model|\Illuminate\Database\Eloquent\Model $model): void
    {
        if ($this->user && $this->user->hasExactRoles(['client'])) {
            $builder->where('user_id', '=', $this->user->id);
        }
    }
}
