<?php

declare(strict_types=1);

namespace Domains\Payments\DataTransferObjects;

use Domains\Payments\Enums\AttendantSignatureEnum;
use Domains\Payments\Enums\PayTypeEnum;
use Domains\Payments\Enums\SpStatusEnum;
use Domains\Users\Actions\GetClearUserIdAction;
use Illuminate\Support\Collection;
use Parents\DataTransferObjects\ObjectData;
use Illuminate\Support\Carbon;
use Parents\Requests\Request;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\MoneyValueObject;

final class PaymentData extends ObjectData
{
    public ?int $id;

    public Carbon $pay_date;

    public PayTypeEnum $pay_type;

    public AttendantSignatureEnum $attendanta_signature;

    public ?string $dispute_reason;

    public MoneyValueObject $amount;

    public SpStatusEnum $spstatus;

    public ?int $user_id;

    public CrmIdValueObject $crmid;

    public CrmIdValueObject $assigned_user_id;

    public Carbon $created_at;

    public Carbon $updated_at;

    public static function fromRequest(Request $request, string $prefix = ''): self
    {
        $user_id = GetClearUserIdAction::run($request->input($prefix . 'user_id'));
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'pay_date' => Carbon::createFromFormat('Y-m-d', $request->input($prefix . 'pay_date')),
            'pay_type' => PayTypeEnum::fromValue($request->input($prefix . 'pay_type')),
            'attendanta_signature' => AttendantSignatureEnum::fromValue(
                $request->input($prefix . 'attendanta_signature')
            ),
            'dispute_reason' => $request->input($prefix . 'dispute_reason'),
            'amount' => MoneyValueObject::fromNative($request->input($prefix . 'amount')),
            'spstatus' => SpStatusEnum::fromValue($request->input($prefix . 'spstatus')),
            'user_id' => $user_id,
            'crmid' => CrmIdValueObject::fromNative($request->input($prefix . 'crmid')),
            'assigned_user_id' => CrmIdValueObject::fromNative(
                $request->input($prefix . 'assigned_user_id')
            ),
        ]);
    }

    public static function fromConnector(Collection $data): self
    {
        $user_id = GetClearUserIdAction::run($data->get('payer'));
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'pay_date' => Carbon::createFromFormat('Y-m-d', $data->get('pay_date')),
            'pay_type' => PayTypeEnum::fromValue($data->get('pay_type')),
            'attendanta_signature' => AttendantSignatureEnum::fromValue(
                $data->get('attendanta_signature')
            ),
            'dispute_reason' => $data->get('dispute_reason'),
            'amount' => MoneyValueObject::fromNative($data->get('amount')),
            'spstatus' => SpStatusEnum::fromValue($data->get('spstatus')),
            'user_id' => $user_id,
            'crmid' => CrmIdValueObject::fromNative($data->get('id')),
            'assigned_user_id' => CrmIdValueObject::fromNative($data->get('assigned_user_id')),
        ]);
    }
}
