<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\Models\Trip;
use Domains\Trips\Repositories\TripRepositoryInterface;

final class GetTripByIdAction extends \Parents\Actions\Action
{
    public function __construct(
        protected TripRepositoryInterface $repository
    ) {
    }

    public function handle(int $id): Trip
    {
        /** @var Trip $trip */
        $trip = $this->repository->findJson($id);
        return $trip;
    }
}
