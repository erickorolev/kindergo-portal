<?php

declare(strict_types=1);

namespace Domains\Payments\Enums;

final class SpStatusEnum extends \Parents\Enums\Enum implements \BenSampo\Enum\Contracts\LocalizedEnum
{
    public const SCHEDULED = 'Scheduled';

    public const CANCELED = 'Canceled';

    public const DELAYED = 'Delayed';

    public const EXECUTED = 'Executed';
}
