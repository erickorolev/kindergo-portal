<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Models\Trip;
use Domains\Trips\Services\TripConnector;

final class ReceiveTripFromCrmAction extends \Parents\Actions\Action
{
    public function handle(int $id): Trip
    {
        $service = app(TripConnector::class);
        $crmTrip = $service->receiveById('Trips', $id);
        $tripData = TripData::fromConnector($crmTrip);
        $existingTrip = GetTripByCrmIdAction::run($tripData->crmid);
        if ($existingTrip) {
            $tripData->id = $existingTrip->id;
            /** @var Trip $trip */
            $trip = UpdateTripAction::run($tripData);
        } else {
            /** @var Trip $trip */
            $trip = StoreTripAction::run($tripData);
        }
        return $trip;
    }
}
