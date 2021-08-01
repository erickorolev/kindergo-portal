<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;

/**
 * Class GetUserByCrmidAction
 * @package Domains\Users\Actions
 * @method static User|null run(string|null $crmid)
 */
final class GetUserByCrmidAction extends \Parents\Actions\Action
{
    public function handle(?string $crmid): ?User
    {
        if (!$crmid) {
            return null;
        }
        return User::where('crmid', $crmid)->first();
    }
}
