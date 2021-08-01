<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Models\Payment;

final class UpdatePaymentAction extends \Parents\Actions\Action
{
    public function handle(PaymentData $data): Payment
    {
        /** @var Payment $payment */
        $payment = GetPaymentByIdAction::run($data->id);
        $payment->update($data->toArray());
        return $payment;
    }
}
