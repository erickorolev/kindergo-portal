<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Repositories\ChildRepositoryInterface;

final class GetAllChildrenAction extends \Parents\Actions\Action
{
    public function __construct(
        protected ChildRepositoryInterface $repository
    ) {
    }

    public function handle(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->jsonPaginate();
    }
}
