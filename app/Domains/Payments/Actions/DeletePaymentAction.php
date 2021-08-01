<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\Models\Payment;

final class DeletePaymentAction extends \Parents\Actions\Action
{
    public function handle(int $id): bool
    {
        /** @var Payment $payment */
        $payment = GetPaymentByIdAction::run($id);
        $payment->delete();
        return true;
    }
}
