<?php

declare(strict_types=1);

namespace Domains\Children\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Parents\Models\Model;

interface ChildRepositoryInterface
{
    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator;

    public function jsonPaginate(): LengthAwarePaginator;

    public function findJson(int $id): Model;

    /**
     * @param  string[]  $columns
     * @return Collection
     */
    public function all($columns = ['*']);
}
