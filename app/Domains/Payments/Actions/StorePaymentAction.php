<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Models\Payment;

final class StorePaymentAction extends \Parents\Actions\Action
{
    public function handle(PaymentData $data): Payment
    {
        return Payment::create($data->toArray());
    }
}
