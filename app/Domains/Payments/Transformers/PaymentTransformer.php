<?php

declare(strict_types=1);

namespace Domains\Payments\Transformers;

use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Parents\Transformers\Transformer;

final class PaymentTransformer extends Transformer
{
    protected $availableIncludes = [
        'user'
    ];

    public function transform(Payment $model): array
    {
        return [
            'id' => $model->id,
            'pay_date' => $model->pay_date,
            'amount' => $model->amount?->toNative(),
            'pay_type' => $model->pay_type->toArray(),
            'attendanta_signature' => $model->attendanta_signature?->toArray(),
            'dispute_reason' => $model->dispute_reason,
            'spstatus' => $model->spstatus->toArray(),
            'crmid' => $model->crmid?->toNative(),
            'meta' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at
            ]
        ];
    }

    public function includeUser(Payment $model): \League\Fractal\Resource\Item
    {
        return $this->item($model->user, new UserTransformer(), User::RESOURCE_NAME);
    }
}
