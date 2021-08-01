<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Requests\Api;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Payments\Enums\AttendantSignatureEnum;
use Domains\Payments\Enums\PayTypeEnum;
use Domains\Payments\Enums\SpStatusEnum;
use Domains\Payments\Enums\TypePaymentEnum;
use Parents\Requests\Request;

final class PaymentUpdateApiRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'data.attributes.pay_date' => ['required', 'date'],
            'data.attributes.pay_type' => ['required', new EnumValue(PayTypeEnum::class)],
            'data.attributes.attendanta_signature' => ['required', new EnumValue(AttendantSignatureEnum::class)],
            'data.attributes.amount' => ['required', 'numeric'],
            'data.attributes.spstatus' => [
                'required',
                new EnumValue(SpStatusEnum::class),
            ],
            'data.attributes.user_id' => ['required'],
            'data.attributes.crmid' => ['nullable', 'max:50'],
            'data.attributes.dispute_reason' => ['nullable', 'max:1000'],
            'data.attributes.assigned_user_id' => ['nullable', 'max:50', 'min:3'],
        ];
        return $this->mergeWithDefaultRules($rules);
    }

    public function authorize(): bool
    {
        return $this->check('update payments');
    }
}
