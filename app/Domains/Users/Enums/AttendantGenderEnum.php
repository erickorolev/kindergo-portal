<?php

declare(strict_types=1);

namespace Domains\Users\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class AttendantGenderEnum extends \Parents\Enums\Enum implements LocalizedEnum
{
    public const MALE = 'Male';

    public const FEMALE = 'Female';

    public const OTHER = 'Other';
}
