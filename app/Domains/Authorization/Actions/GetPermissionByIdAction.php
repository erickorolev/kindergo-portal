<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Permission;

final class GetPermissionByIdAction extends \Parents\Actions\Action
{
    /**
     * @param  int  $id
     * @return \Spatie\Permission\Models\Permission
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    public function handle(int $id): \Spatie\Permission\Models\Permission
    {
        return Permission::whereId($id)->firstOrFail();
    }
}
