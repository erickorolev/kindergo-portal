<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Spatie\Permission\Models\Role;

final class GetRoleByIdAction extends \Parents\Actions\Action
{
    /**
     * @param  int  $id
     * @return Role
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    public function handle(int $id): Role
    {
        return \Domains\Authorization\Models\Role::whereId($id)->firstOrFail();
    }
}
