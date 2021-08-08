<?php

declare(strict_types=1);

namespace Domains\Children\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Models\Model;

interface ChildRepositoryInterface
{
    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator;

    public function jsonPaginate(): LengthAwarePaginator;

    public function findJson(int $id): Model;

    public function all($columns = ['*']);
}
