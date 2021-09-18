<?php

declare(strict_types=1);

namespace Domains\Payments\Services;

use Domains\Attendants\Models\Attendant;
use Domains\Children\Models\Child;
use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Parents\ValueObjects\CrmIdValueObject;
use Support\VtigerClient\WSException;

final class PaymentConnector extends \Parents\Services\ConnectorService
{
    public function receive(): Collection
    {
        $result = collect([]);

        try {
            $payments = $this->client->entities?->findMany('SPPayments', [
                'modifiedtime' => Carbon::now()->subDay()->format('Y-m-d')
            ]);
        } catch (WSException $e) {
            Log::error('Error in getting payment data from Vtiger: ' . $e->getMessage());
            app('sentry')->captureException($e);
            $payments = null;
        }

        if (!$payments) {
            return $result;
        }

        foreach ($payments as $payment) {
            $result->push($this->getCollection($payment));
        }

        return $result;
    }

    protected function getCollection(array $payment): Collection
    {
        return collect($payment);
    }

    public function send(Payment $payment): Collection
    {
        if (is_null($payment->crmid) || $payment->crmid->isNull()) {
            /** @var array<string, string> $result */
            $result = $this->client->entities?->createOne('SPPayments', $payment->toCrmArray());
            $payment->crmid = CrmIdValueObject::fromNative($result['id']);
            $payment->save();
            return collect($result);
        }

        $result = $this->client->entities?->updateOne(
            'SPPayments',
            (string) $payment->crmid->toInt(),
            $payment->toCrmArray()
        );

        return collect($result);
    }

    protected function getUpdatedArray(array $sppayment, Payment $payment): array
    {
        return $sppayment;
    }
}
