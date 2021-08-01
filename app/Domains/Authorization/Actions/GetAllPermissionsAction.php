<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Permission;

final class GetAllPermissionsAction extends \Parents\Actions\Action
{
    public function handle(): iterable
    {
        return Permission::all();
    }
}
