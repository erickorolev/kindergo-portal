<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\Models\Trip;

final class DeleteTripAction extends \Parents\Actions\Action
{
    public function handle(int $id): bool
    {
        /** @var Trip $trip */
        $trip = GetTripByIdAction::run($id);
        $trip->delete();
        return true;
    }
}
