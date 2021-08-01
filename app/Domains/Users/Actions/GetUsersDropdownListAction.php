<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;
use Illuminate\Support\Collection;

final class GetUsersDropdownListAction extends \Parents\Actions\Action
{
    public function handle(): Collection
    {
        return User::all()->pluck('name', 'id');
    }
}
