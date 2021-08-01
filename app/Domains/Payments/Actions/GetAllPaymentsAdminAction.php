<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\Repositories\PaymentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllPaymentsAdminAction extends \Parents\Actions\Action
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {
    }

    public function handle(string $search = '', int $pagination = 5): LengthAwarePaginator
    {
        return $this->repository->basicPaginate($search, $pagination);
    }
}
