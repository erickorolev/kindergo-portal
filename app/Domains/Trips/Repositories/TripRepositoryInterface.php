<?php

declare(strict_types=1);

namespace Domains\Trips\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Models\Model;

/**
 * Interface TripRepositoryInterface
 * @package Domains\Trips\Repositories
 * @psalm-suppress all
 */
interface TripRepositoryInterface
{
    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator;

    public function jsonPaginate(): LengthAwarePaginator;

    public function findJson(int $id): Model;

    public function scopeQuery(\Closure $scope);

    public function pushCriteria($criteria);
}
