<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;

final class DeleteUserAction extends \Parents\Actions\Action
{
    public function handle(int $id): bool
    {
        $user = GetUserByIdAction::run($id);
        $user->delete();
        return true;
    }
}
