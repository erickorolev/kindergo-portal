<?php

declare(strict_types=1);

namespace Domains\Users\Enums;

final class AttendantStatusEnum extends \Parents\Enums\Enum implements \BenSampo\Enum\Contracts\LocalizedEnum
{
    public const ACTIVE = 'Active';

    public const INACTIVE = 'Inactive';

    public const STANDBY = 'Standby';
}
