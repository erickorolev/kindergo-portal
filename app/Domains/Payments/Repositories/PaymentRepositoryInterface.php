<?php

declare(strict_types=1);

namespace Domains\Payments\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Parents\Models\Model;

/**
 * Interface PaymentRepositoryInterface
 * @package Domains\Payments\Repositories
 * @psalm-suppress all
 */
interface PaymentRepositoryInterface
{
    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator;

    public function jsonPaginate(): LengthAwarePaginator;

    public function findJson(int $id): Model;

    public function scopeQuery(\Closure $scope);

    public function pushCriteria($criteria);
}
