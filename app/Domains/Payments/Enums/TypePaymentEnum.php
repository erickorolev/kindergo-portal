<?php

declare(strict_types=1);

namespace Domains\Payments\Enums;

final class TypePaymentEnum extends \Parents\Enums\Enum implements \BenSampo\Enum\Contracts\LocalizedEnum
{
    public const ONLINE_PAYMENT = 'Online payment';

    public const BANK_PAYMENT = 'Bank payment';
}
