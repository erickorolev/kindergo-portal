<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\DataTransferObjects\PermissionData;
use Domains\Authorization\Models\Permission;
use Domains\Authorization\Models\Role;

final class StorePermissionAction extends \Parents\Actions\Action
{
    public function handle(PermissionData $data): \Illuminate\Database\Eloquent\Model
    {
        $permission = Permission::create($data->toArray());

        $roles = Role::find($data->roles);
        $permission->syncRoles($roles);

        return $permission;
    }
}
