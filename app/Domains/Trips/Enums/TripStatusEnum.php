<?php

declare(strict_types=1);

namespace Domains\Trips\Enums;

final class TripStatusEnum extends \Parents\Enums\Enum implements \BenSampo\Enum\Contracts\LocalizedEnum
{
    public const APPOINTED = 'Appointed';

    public const PERFORMED = 'Performed';

    public const COMPLETED = 'Completed';

    public const CANCELED = 'Canceled';

    public const PENDING = 'Pending';
}
