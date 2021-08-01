<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Collection;

final class GetAllRolesAction extends \Parents\Actions\Action
{
    public function handle(): Collection
    {
        return Role::all();
    }
}
