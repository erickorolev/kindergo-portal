<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Models\Trip;
use Support\Media\Tasks\AttachImagesTask;

final class StoreTripAction extends \Parents\Actions\Action
{
    public function handle(TripData $data): Trip
    {
        $trip = Trip::create($data->toArray());
        $trip->children()->attach($data->children);
        AttachImagesTask::run($trip, $data, 'documents');
        return $trip;
    }
}
