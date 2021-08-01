<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Repositories\UserRepositoryInterface;

final class GetAllUsersAction extends \Parents\Actions\Action
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    public function handle(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->jsonPaginate();
    }
}
