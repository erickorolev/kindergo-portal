<?php

declare(strict_types=1);

namespace Domains\Children\Repositories\Eloquent;

use Domains\Children\Models\Child;
use Parents\Repositories\Repository;
use Domains\Children\Repositories\ChildRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class ChildRepository extends Repository implements ChildRepositoryInterface
{
    public function basicPaginate(string $search, int $pagination = 5): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $children */
        $children = Child::search($search)
            ->latest()
            ->paginate($pagination);
        return $children;
    }
}
