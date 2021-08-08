<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Models\Payment;
use Domains\Payments\Services\PaymentConnector;

final class ReceivePaymentFromCrmAction extends \Parents\Actions\Action
{
    public function handle(int $id): Payment
    {
        $service = app(PaymentConnector::class);
        $crmUser = $service->receiveById('SPPayments', $id);
        $paymentData = PaymentData::fromConnector($crmUser);
        $existingTimetable = GetPaymentByCrmIdAction::run($paymentData->crmid);
        if ($existingTimetable) {
            $paymentData->id = $existingTimetable->id;
            /** @var Payment $payment */
            $payment = UpdatePaymentAction::run($paymentData);
        } else {
            /** @var Payment $payment */
            $payment = StorePaymentAction::run($paymentData);
        }
        return $payment;
    }
}
