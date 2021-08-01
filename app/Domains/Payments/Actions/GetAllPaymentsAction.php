<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\Repositories\PaymentRepositoryInterface;

final class GetAllPaymentsAction extends \Parents\Actions\Action
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {
    }

    public function handle(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->repository->jsonPaginate();
    }
}
