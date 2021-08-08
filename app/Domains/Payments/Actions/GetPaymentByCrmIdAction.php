<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\Models\Payment;
use Parents\ValueObjects\CrmIdValueObject;

/**
 * @method static Payment|null run(CrmIdValueObject $crmid)
 */
final class GetPaymentByCrmIdAction extends \Parents\Actions\Action
{
    public function handle(CrmIdValueObject $crmid): ?Payment
    {
        return Payment::where('crmid', $crmid->toNative())->first();
    }
}
