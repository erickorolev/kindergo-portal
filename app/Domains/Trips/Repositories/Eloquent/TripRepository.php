<?php

declare(strict_types=1);

namespace Domains\Trips\Repositories\Eloquent;

use Domains\Trips\Models\Trip;
use Domains\Trips\Repositories\TripRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class TripRepository extends \Parents\Repositories\Repository implements TripRepositoryInterface
{

    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $trips */
        $trips = Trip::search($search)
            ->orderBy('date')
            ->paginate(5);
        return $trips;
    }
}
