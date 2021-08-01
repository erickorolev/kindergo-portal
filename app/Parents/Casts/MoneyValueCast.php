<?php

declare(strict_types=1);

namespace Parents\Casts;

use Parents\Models\Model;
use Parents\ValueObjects\MoneyValueObject;

final class MoneyValueCast extends CastAbstract
{

    /**
     * @inheritDoc
     * @param int|MoneyValueObject $value
     * @param Model $model
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function get($model, string $key, $value, array $attributes): ?MoneyValueObject
    {
        if (!$value) {
            return null;
        }
        if (is_object($value)) {
            return $value;
        }
        return MoneyValueObject::fromFullNative($value);
    }

    /**
     * @inheritDoc
     * @param MoneyValueObject|int|null $value
     * @param Model $model
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function set($model, string $key, $value, array $attributes): ?int
    {
        if (!$value) {
            return null;
        }
        if (is_int($value)) {
            return $value;
        }
        return $value->toInt();
    }
}
