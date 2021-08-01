<?php

declare(strict_types=1);

namespace Parents\Casts;

use Parents\Models\Model;
use Parents\ValueObjects\EmailValueObject;
use Parents\ValueObjects\MoneyValueObject;
use Parents\ValueObjects\PhoneNumberValueObject;

final class EmailCast extends CastAbstract
{

    /**
     * @inheritDoc
     * @param ?string $value
     * @param Model $model
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function get($model, string $key, $value, array $attributes): ?EmailValueObject
    {
        if (!$value) {
            return null;
        }
        return EmailValueObject::fromNative($value);
    }

    /**
     * @inheritDoc
     * @param EmailValueObject|string|null $value
     * @param Model $model
     * @psalm-suppress MoreSpecificImplementedParamType
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
