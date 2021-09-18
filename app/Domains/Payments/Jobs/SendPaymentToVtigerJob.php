<?php

declare(strict_types=1);

namespace Domains\Payments\Jobs;

use Domains\Payments\Models\Payment;
use Domains\Payments\Services\PaymentConnector;
use Domains\Users\Models\User;
use Domains\Users\Services\UserConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Support\VtigerClient\WSException;

final class SendPaymentToVtigerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Payment $payment
    ) {
    }

    public function handle(): void
    {
        $connector = app(PaymentConnector::class);

        try {
            $connector->send($this->payment);
        } catch (\DomainException | \InvalidArgumentException $e) {
            Log::error('Validation Error in updating data in Vtiger: ' . $e->getMessage());
            app('sentry')->captureException($e);
        } catch (WSException $e) {
            Log::error('Vtiger did not accept update of payment with id '
                . $this->payment->id . ': ' . $e->getMessage());
            app('sentry')->captureException($e);
        }
    }
}
