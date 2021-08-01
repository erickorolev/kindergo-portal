<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Payments\Enums\AttendantSignatureEnum;
use Domains\Payments\Enums\PayTypeEnum;
use Domains\Payments\Enums\SpStatusEnum;
use Domains\Payments\Enums\TypePaymentEnum;
use Parents\Requests\Request;

final class PaymentUpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'pay_date' => ['required', 'date'],
            'pay_type' => ['required', new EnumValue(PayTypeEnum::class)],
            'attendanta_signature' => ['required', new EnumValue(AttendantSignatureEnum::class)],
            'amount' => ['required', 'numeric'],
            'spstatus' => [
                'required',
                new EnumValue(SpStatusEnum::class),
            ],
            'user_id' => ['required'],
            'crmid' => ['nullable', 'max:50'],
            'dispute_reason' => ['nullable', 'max:1000'],
            'assigned_user_id' => ['nullable', 'max:50', 'min:3'],
        ];
    }

    public function authorize(): bool
    {
        return $this->check('update payments');
    }
}
