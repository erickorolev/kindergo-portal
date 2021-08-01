<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Timetables\Repositories\TimetableRepositoryInterface;
use Domains\Trips\Repositories\TripRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllTripsAdminAction extends \Parents\Actions\Action
{
    public function __construct(
        protected TripRepositoryInterface $repository
    ) {
    }

    public function handle(string $search = '', int $paginate = 5): LengthAwarePaginator
    {
        return $this->repository->basicPaginate($search, $paginate);
    }
}
