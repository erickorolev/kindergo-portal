<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Models\User;
use Domains\Users\Services\UserConnector;
use Illuminate\Support\Facades\Log;

final class ReceiveUserFromCrmAction extends \Parents\Actions\Action
{
    public function handle(int $id): User
    {
        $service = app(UserConnector::class);
        $crmUser = $service->receiveById('Contacts', $id);
        $userData = UserData::fromConnector($crmUser);
        $existingUser = GetUserByCrmidAction::run($userData->crmid->toNative());
        if ($existingUser) {
            $userData->id = $existingUser->id;
            /** @var User $user */
            $user = UpdateUserAction::run($userData, false, false);
        } else {
            /** @var User $user */
            $user = StoreUserAction::run($userData, false);
        }
        return $user;
    }
}
