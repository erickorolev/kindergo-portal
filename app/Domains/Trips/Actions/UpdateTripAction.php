<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\DataTransferObjects\TripData;
use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Support\Media\Tasks\UpdateImagesTask;

final class UpdateTripAction extends \Parents\Actions\Action
{
    public function handle(TripData $data): Trip
    {
        /** @var Trip $trip */
        $trip = GetTripByIdAction::run($data->id);
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $trip->user_id !== Auth::id()) {
            abort(403, 'You can not edit payments of other users');
        }
        $trip->update($this->filterData($data));
        if ($data->children) {
            $trip->children()->sync($data->children);
        }
        UpdateImagesTask::run($trip, $data, 'documents');
        return $trip;
    }

    protected function filterData(TripData $data): array
    {
        $updated = $data->toArray();
        if (isset($updated['user_id']) && !$updated['user_id']) {
            unset($updated['user_id']);
        }
        if (isset($updated['attendant_id']) && !$updated['attendant_id']) {
            unset($updated['attendant_id']);
        }
        if (isset($updated['crmid']) && (!$updated['crmid'] || $updated['crmid']->isNull())) {
            unset($updated['crmid']);
        }
        if (
            isset($updated['cf_timetable_id']) && (
            !$updated['cf_timetable_id'] || $updated['cf_timetable_id']->isNull())
        ) {
            unset($updated['cf_timetable_id']);
        }
        if (
            isset($updated['assigned_user_id']) && (
            !$updated['assigned_user_id'] || $updated['assigned_user_id']->isNull())
        ) {
            unset($updated['assigned_user_id']);
        }
        return $updated;
    }
}
