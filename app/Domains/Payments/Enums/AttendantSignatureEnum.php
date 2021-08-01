<?php

declare(strict_types=1);

namespace Domains\Payments\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AttendantSignatureEnum extends \Parents\Enums\Enum implements LocalizedEnum
{
    public const SIGNED_BY = 'Signed by';

    public const DISPUTED = 'Disputed';

    public const WAITING = 'Waiting';
}
