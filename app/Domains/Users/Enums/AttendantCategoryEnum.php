<?php

declare(strict_types=1);

namespace Domains\Users\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AttendantCategoryEnum extends \Parents\Enums\Enum implements LocalizedEnum
{
    public const DRIVER = 'Driver';

    public const PEDESTRIAN = 'Pedestrian';

    public const OTHER = 'Other';
}
