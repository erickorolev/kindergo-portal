<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\DataTransferObjects\RoleData;
use Domains\Authorization\Models\Permission;
use Domains\Authorization\Models\Role;

final class StoreRoleAction extends \Parents\Actions\Action
{
    public function handle(RoleData $roleData): \Spatie\Permission\Models\Role
    {
        $role = Role::create($roleData->toArray());

        $permissions = Permission::find($roleData->permissions);
        $role->syncPermissions($permissions);

        return $role;
    }
}
