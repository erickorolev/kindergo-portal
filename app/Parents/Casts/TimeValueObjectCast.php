<?php

declare(strict_types=1);

namespace Parents\Casts;

use Parents\Models\Model;
use Parents\ValueObjects\CrmIdValueObject;
use Parents\ValueObjects\EmailValueObject;
use Parents\ValueObjects\TimeValueObject;

final class TimeValueObjectCast extends \Parents\Casts\CastAbstract
{

    /**
     * @psalm-param ?string $value
     * @param Model $model
     * @inheritDoc
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function get($model, string $key, $value, array $attributes): ?TimeValueObject
    {
        if (!$value) {
            return null;
        }
        return TimeValueObject::fromNative($value);
    }

    /**
     * @param Model $model
     * @param TimeValueObject|string|null $value
     * @psalm-suppress MoreSpecificImplementedParamType
     * @inheritDoc
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        if (!$value) {
            return null;
        }
        if (is_string($value)) {
            return $value;
        }
        return $value->toNative();
    }
}
