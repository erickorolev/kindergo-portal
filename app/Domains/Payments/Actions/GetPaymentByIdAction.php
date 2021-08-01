<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\Models\Payment;
use Domains\Payments\Repositories\PaymentRepositoryInterface;

final class GetPaymentByIdAction extends \Parents\Actions\Action
{
    public function __construct(
        protected PaymentRepositoryInterface $repository
    ) {
    }

    public function handle(int $id): Payment
    {
        /** @var Payment $payment */
        $payment = $this->repository->findJson($id);
        return $payment;
    }
}
