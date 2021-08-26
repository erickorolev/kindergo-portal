<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Jobs\SendUserToVtigerJob;
use Domains\Users\Models\User;
use Domains\Users\Notifications\PasswordSendNotification;
use Support\Media\Tasks\AttachImagesTask;
use Domains\Authorization\Models\Role;

/**
 * Class StoreUserAction
 * @package Domains\Users\Actions
 * @method static User run(UserData $userData, bool $dispatchUpdate = true)
 */
final class StoreUserAction extends \Parents\Actions\Action
{
    public function handle(UserData $userData, bool $dispatchUpdate = true): User
    {
        $user = User::create($userData->toArray());
        /** @var \Spatie\Permission\Contracts\Role $defaultRole */
        $defaultRole = Role::whereName('client')->first();
        if (empty($userData->roles)) {
            $user->syncRoles($defaultRole);
        } else {
            $user->syncRoles($userData->roles);
        }

        AttachImagesTask::run($user, $userData);
        $userData->id = $user->id;

        if ($dispatchUpdate) {
            SendUserToVtigerJob::dispatch($user);
        }

        $user->notify(new PasswordSendNotification($userData));

        return $user;
    }
}
