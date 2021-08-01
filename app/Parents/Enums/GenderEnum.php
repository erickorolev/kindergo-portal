<?php

declare(strict_types=1);

namespace Parents\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;

final class GenderEnum extends Enum implements LocalizedEnum
{
    public const MALE = 'Male';

    public const FEMALE = 'Female';

    public const OTHER = 'Other';
}
