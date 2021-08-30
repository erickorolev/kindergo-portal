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
        if (isset($userArr['crmid']) && (!$userArr['crmid'] || $userArr['crmid']->isNull())) {
            unset($userArr['crmid']);
        }
        if (
            isset($userArr['assigned_user_id']) &&
            (!$userArr['assigned_user_id'] || $userArr['assigned_user_id']->isNull())
        ) {
            unset($userArr['assigned_user_id']);
        }
        $user->update($userArr);
        $roles = $user->roles;
        if (!empty($userData->roles)) {
            $roles = $userData->roles;
        }
        $user->syncRoles($roles);
        UpdateImagesTask::run($user, $userData);
        if ($dispatchUpdate) {
            SendUserToVtigerJob::dispatch($user);
        }
        return $user;
    }
}
