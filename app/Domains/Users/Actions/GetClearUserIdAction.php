<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;

/**
 * Class GetClearUserIdAction
 * @package Domains\Users\Actions
 * @method static int|null run(string|int|null $id)
 */
final class GetClearUserIdAction extends \Parents\Actions\Action
{
    public function handle(string|int|null $id): ?int
    {
        if ($id === null) {
            return null;
        }
        $user = GetUserByCrmidAction::run((string) $id);
        if ($user) {
            return $user->id;
        }
        $user = User::whereId($id)->firstOrFail();
        return $user->id;
    }
}
