<?php

declare(strict_types=1);

namespace Domains\Payments\Actions;

use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Illuminate\Support\Facades\Auth;

final class UpdatePaymentAction extends \Parents\Actions\Action
{
    public function handle(PaymentData $data): Payment
    {
        /** @var Payment $payment */
        $payment = GetPaymentByIdAction::run($data->id);
        $updated = $data->toArray();
        /** @var User $user */
        $user = Auth::user();
        if (!$user->isSuperAdmin() && $payment->user_id !== Auth::id()) {
            abort(403, 'You can not edit payments of other users');
        }
        if (isset($updated['user_id']) && !$updated['user_id']) {
            unset($updated['user_id']);
        }
        if (isset($updated['crmid']) && (!$updated['crmid'] || $updated['crmid']->isNull())) {
            unset($updated['crmid']);
        }
        $payment->update($updated);
        return $payment;
    }
}
