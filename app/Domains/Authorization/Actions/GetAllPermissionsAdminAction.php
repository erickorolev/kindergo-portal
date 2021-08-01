<?php

declare(strict_types=1);

namespace Domains\Authorization\Actions;

use Domains\Authorization\Models\Permission;

final class GetAllPermissionsAdminAction extends \Parents\Actions\Action
{
    /**
     * @param  string  $search
     * @param  int  $pagination
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress MoreSpecificReturnType
     */
    public function handle(
        string $search = '',
        int $pagination = 10
    ): \Illuminate\Pagination\LengthAwarePaginator {
        return Permission::where('name', 'like', "%{$search}%")->paginate($pagination);
    }
}
