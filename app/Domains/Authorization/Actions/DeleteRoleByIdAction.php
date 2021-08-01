<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Role;

final class DeleteRoleByIdAction extends \Parents\Actions\Action
{
    public function handle(int $id): bool
    {
        /** @var Role $role */
        $role = GetRoleByIdAction::run($id);
        $role->delete();
        return true;
    }
}
