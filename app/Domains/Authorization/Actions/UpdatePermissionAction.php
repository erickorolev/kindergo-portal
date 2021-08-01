<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\DataTransferObjects\PermissionData;
use Domains\Authorization\Models\Permission;
use Domains\Authorization\Models\Role;

final class UpdatePermissionAction extends \Parents\Actions\Action
{
    public function handle(PermissionData $permissionData): Permission
    {
        /** @var Permission $permission */
        $permission = GetPermissionByIdAction::run($permissionData->id);
        $permission->update($permissionData->toArray());
        /** @var \Spatie\Permission\Models\Role[] $roles */
        $roles = Role::find($permissionData->roles);
        $permission->syncRoles($roles);

        return $permission;
    }
}
