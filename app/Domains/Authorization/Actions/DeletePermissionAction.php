<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Permission;
use Lorisleiva\Actions\Concerns\AsAction;

final class DeletePermissionAction extends \Parents\Actions\Action
{

    public function handle(int $id): bool
    {
        /** @var Permission $permission */
        $permission = GetPermissionByIdAction::run($id);
        $permission->delete();
        return true;
    }
}
