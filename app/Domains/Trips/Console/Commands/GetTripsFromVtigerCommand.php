<?php

declare(strict_types=1);

namespace Domains\Trips\Console\Commands;

use Domains\Trips\Actions\GetTripByCrmIdAction;
use Domains\Trips\Actions\StoreTripAction;
use Domains\Trips\Actions\UpdateTripAction;
use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Models\Trip;
use Domains\Trips\Services\TripConnector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Parents\Commands\Command;

final class GetTripsFromVtigerCommand extends Command
{
    protected $signature = 'trips:receive';

    protected $description = 'Import all trips from Vtiger';

    public function handle(): int
    {
        $connector = app(TripConnector::class);
        $trips = $connector->receive();
        /** @var Collection $trip */
        foreach ($trips as $trip) {
            try {
                $tripData = TripData::fromConnector($trip);
                /** @var ?Trip $existingTrip */
                $existingTrip = GetTripByCrmIdAction::run($tripData->crmid->toNative());
                if ($existingTrip) {
                    $tripData->id = $existingTrip->id;
                    UpdateTripAction::run($tripData);
                } else {
                    StoreTripAction::run($tripData);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save Timetable data from Vtiger in DB for '
                    . $trip['id'] . ': '
                    . $e->getMessage());
                app('sentry')->captureException($e);
                continue;
            }
        }
        return 0;
    }
}
