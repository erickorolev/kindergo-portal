<?php

declare(strict_types=1);

namespace Domains\Trips\Services;

use Domains\Attendants\Models\Attendant;
use Domains\Children\Models\Child;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Support\VtigerClient\WSException;

final class TripConnector extends \Parents\Services\ConnectorService
{
    public function receive(): Collection
    {
        $result = collect([]);

        try {
            $trips = $this->client->entities?->findMany('Trips', [
                'modifiedtime' => Carbon::now()->subDay()->format('Y-m-d')
            ]);
        } catch (WSException $e) {
            Log::error('Error in getting trip data from Vtiger: ' . $e->getMessage());
            app('sentry')->captureException($e);
            $trips = null;
        }

        if (!$trips) {
            return $result;
        }

        foreach ($trips as $trip) {
            $result->push($this->getChildrenToCollection($trip));
        }

        return $result;
    }

    protected function getChildrenToCollection(array $timetable): Collection
    {
        $timetable['children'] = [
            $timetable['cf_nrl_contacts351_id'],
            $timetable['cf_nrl_contacts774_id'],
            $timetable['cf_nrl_contacts94_id'],
            $timetable['cf_nrl_contacts616_id'],
        ];
        return collect($timetable);
    }
}
