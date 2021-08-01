<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\DataTransferObjects\RoleData;
use Domains\Authorization\Models\Permission;
use Spatie\Permission\Models\Role;

final class UpdateRoleAction extends \Parents\Actions\Action
{
    public function handle(RoleData $roleData): Role
    {
        /** @var Role $role */
        $role = GetRoleByIdAction::run($roleData->id);
        $role->update($roleData->toArray());
        $permissions = Permission::find($roleData->permissions);
        $role->syncPermissions($permissions);
        return $role;
    }
}
