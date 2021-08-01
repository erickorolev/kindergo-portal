<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;
use Illuminate\Support\Collection;

final class GetUserIdsFromArrayAction extends \Parents\Actions\Action
{
    public function handle(array $ids): Collection
    {
        $result = collect([]);
        foreach ($ids as $id) {
            $user = GetUserByCrmidAction::run($id);
            if (!$user) {
                $user = GetUserByIdAction::run($id);
            }
            $result->push($user->id);
        }
        return $result;
    }
}
