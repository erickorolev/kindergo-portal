<?php

declare(strict_types=1);

namespace Parents\Enums;

abstract class Enum extends \BenSampo\Enum\Enum
{
    // Return all properties
    public function toArray(): self
    {
        return $this;
    }
}
