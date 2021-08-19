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
     * @method static User run(UserData $userData, bool $dispatchUpdate = true, bool $updatePass = true)
     */
    public function handle(UserData $userData, bool $dispatchUpdate = true, bool $updatePass = true): User
    {
        $id = $userData->id;
        if (is_null($id)) {
            throw new NotFoundException('Not ID in User object!');
        }
        $user = GetUserByIdAction::run($id);
        $userArr = $userData->toArray();
        if (!$updatePass) {
            unset($userArr['password']);
        }
        $user->update($userArr);
        if (!empty($userData->roles)) {
            $user->syncRoles($userData->roles);
        }
        UpdateImagesTask::run($user, $userData);
        if ($dispatchUpdate) {
            SendUserToVtigerJob::dispatch($user);
        }
        return $user;
    }
}
