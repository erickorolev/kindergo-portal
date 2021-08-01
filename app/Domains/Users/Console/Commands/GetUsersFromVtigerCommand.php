<?php

declare(strict_types=1);

namespace Domains\Users\Console\Commands;

use Domains\Users\Actions\GetUserByCrmidAction;
use Domains\Users\Actions\StoreUserAction;
use Domains\Users\Actions\UpdateUserAction;
use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Models\User;
use Domains\Users\Services\UserConnector;
use Illuminate\Support\Facades\Log;
use Parents\Commands\Command;

final class GetUsersFromVtigerCommand extends Command
{
    protected $signature = 'users:receive';

    protected $description = 'Import users from Vtiger';

    public function handle(): int
    {
        $connector = app(UserConnector::class);
        $contacts = $connector->receive();
        foreach ($contacts as $contact) {
            try {
                $userData = UserData::fromConnector($contact);
                $existingUser = GetUserByCrmidAction::run($userData->crmid->toNative());
                if ($existingUser) {
                    $userData->id = $existingUser->id;
                    UpdateUserAction::run($userData, false);
                } else {
                    StoreUserAction::run($userData, false);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save User data from Vtiger in DB for ' . $contact['id'] . ': '
                    . $e->getMessage());
                app('sentry')->captureException($e);
                continue;
            }
        }
        return 0;
    }
}
