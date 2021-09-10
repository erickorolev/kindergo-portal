<?php

declare(strict_types=1);

namespace Domains\Payments\Console\Commands;

use Domains\Payments\Actions\GetPaymentByCrmIdAction;
use Domains\Payments\Actions\StorePaymentAction;
use Domains\Payments\Actions\UpdatePaymentAction;
use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Models\Payment;
use Domains\Payments\Services\PaymentConnector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Parents\Commands\Command;

final class GetPaymentsFromVtigerCommand extends Command
{
    protected $signature = 'payments:receive';

    protected $description = 'Import all payments from Vtiger';

    public function handle(): int
    {
        $connector = app(PaymentConnector::class);
        $payments = $connector->receive();
        /** @var Collection $payment */
        foreach ($payments as $payment) {
            try {
                $paymentData = PaymentData::fromConnector($payment);
                $existingTimetable = GetPaymentByCrmIdAction::run($paymentData->crmid);
                if ($existingTimetable) {
                    $paymentData->id = $existingTimetable->id;
                    UpdatePaymentAction::run($paymentData, true);
                } else {
                    StorePaymentAction::run($paymentData);
                }
            } catch (\Exception $e) {
                Log::error('Failed to save Payment data from Vtiger in DB for '
                    . $payment['id'] . ': '
                    . $e->getMessage());
                app('sentry')->captureException($e);
                continue;
            }
        }
        return 0;
    }
}
