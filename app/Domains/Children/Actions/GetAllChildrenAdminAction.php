<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Repositories\ChildRepositoryInterface;

final class GetAllChildrenAdminAction extends \Parents\Actions\Action
{
    public function __construct(
        protected ChildRepositoryInterface $repository
    ) {
    }

    public function handle(string $search, int $pagination = 5): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->basicPaginate($search, $pagination);
    }
}
