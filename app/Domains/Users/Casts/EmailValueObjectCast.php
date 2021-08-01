<?php

declare(strict_types=1);

namespace Domains\Users\Casts;

use Parents\Models\Model;
use Parents\ValueObjects\EmailValueObject;

final class EmailValueObjectCast extends \Parents\Casts\CastAbstract
{

    /**
     * @psalm-param ?string $value
     * @param Model $model
     * @inheritDoc
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
     * @param Model $model
     * @param EmailValueObject|string|null $value
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
