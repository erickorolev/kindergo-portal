<?php

declare(strict_types=1);

namespace Domains\Children\Console\Commands;

use Domains\Attendants\Actions\GetAttendantByCrmIdAction;
use Domains\Attendants\Actions\StoreAttendantAction;
use Domains\Attendants\Actions\UpdateAttendantAction;
use Domains\Attendants\DataTransferObjects\AttendantData;
use Domains\Attendants\Models\Attendant;
use Domains\Attendants\Services\AttendantConnector;
use Domains\Children\Actions\GetChildByCrmIdAction;
use Domains\Children\Actions\StoreChildAction;
use Domains\Children\Actions\UpdateChildAction;
use Domains\Children\DataTransferObjects\ChildData;
use Domains\Children\Models\Child;
use Domains\Children\Services\ChildConnector;
use Domains\Users\Actions\GetUserByCrmidAction;
use Domains\Users\Actions\StoreUserAction;
use Domains\Users\Actions\UpdateUserAction;
use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Models\User;
use Illuminate\Support\Facades\Log;
use Parents\Commands\Command;

final class GetChildrenFromVtigerCommand extends Command
{
    protected $signature = 'children:receive';

    protected $description = 'Import children from Vtiger';

    public function handle(): int
    {
        $connector = app(ChildConnector::class);
        $children = $connector->receive();
        foreach ($children as $child) {
            try {
                $childData = ChildData::fromConnector($child);
                $existingUser = GetChildByCrmIdAction::run($childData->crmid);
                if ($existingUser) {
                    $childData->id = $existingUser->id;
                    UpdateChildAction::run($childData, false);
                } else {
                    StoreChildAction::run($childData, false);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save Child data from Vtiger in DB for '
                    . $child['id'] . ': '
                    . $e->getMessage());
                app('sentry')->captureException($e);
                continue;
            }
        }
        return 0;
    }
}
