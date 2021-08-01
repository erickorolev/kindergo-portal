<?php

declare(strict_types=1);

namespace Support\Helpers;

class SystemHelper
{

    public static function convertToInt(string|float|int|null $value): int
    {
        if (is_int($value)) {
            return $value;
        }
        if (!$value) {
            return 0;
        }
        $float = strval(floatval($value) * 100);
        return (int) $float;
    }
}
