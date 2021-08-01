<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;

/**
 * Class GetUserByEmailAction
 * @package Domains\Users\Actions
 * @method static User|null run(string $email)
 */
final class GetUserByEmailAction extends \Parents\Actions\Action
{
    public function handle(string $email): ?User
    {
        /** @var ?User $user */
        $user = User::whereEmail($email)->first();
        return $user;
    }
}
