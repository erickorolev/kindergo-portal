<?php

declare(strict_types=1);

namespace Domains\Payments\Enums;

final class PayTypeEnum extends \Parents\Enums\Enum implements \BenSampo\Enum\Contracts\LocalizedEnum
{
    public const RECEIPT = 'Receipt';

    public const EXPENSE = 'Expense';
}
