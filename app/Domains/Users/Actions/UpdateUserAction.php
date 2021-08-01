<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\DataTransferObjects\UserData;
use Domains\Users\Jobs\SendUserToVtigerJob;
use Domains\Users\Models\User;
use Parents\Exceptions\NotFoundException;
use Support\Media\Tasks\UpdateImagesTask;

final class UpdateUserAction extends \Parents\Actions\Action
{
    /**
     * @param  UserData  $userData
     * @param  bool  $dispatchUpdate
     * @return User
     * @method static User run(UserData $userData, bool $dispatchUpdate = true)
     */
    public function handle(UserData $userData, bool $dispatchUpdate = true): User
    {
        $id = $userData->id;
        if (is_null($id)) {
            throw new NotFoundException('Not ID in User object!');
        }
        $user = GetUserByIdAction::run($id);
        $user->update($userData->toArray());
        $user->syncRoles($userData->roles);
        UpdateImagesTask::run($user, $userData);
        if ($dispatchUpdate) {
            SendUserToVtigerJob::dispatch($user);
        }
        return $user;
    }
}
