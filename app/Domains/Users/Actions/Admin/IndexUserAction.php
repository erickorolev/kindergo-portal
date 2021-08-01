<?php

declare(strict_types=1);

namespace Domains\Users\Actions\Admin;

use Domains\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

final class IndexUserAction extends \Parents\Actions\Action
{
    public function handle(string $search, int $pagination = 5): \Illuminate\Pagination\LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $users */
        $users = User::search($search)
            ->latest()
            ->paginate($pagination);
        return $users;
    }
}
