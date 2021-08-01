<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\Repositories\TripRepositoryInterface;

final class GetAllTripsAction extends \Parents\Actions\Action
{
    public function __construct(
        protected TripRepositoryInterface $repository
    ) {
    }

    public function handle(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->jsonPaginate();
    }
}
