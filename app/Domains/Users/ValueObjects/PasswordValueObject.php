<?php

declare(strict_types=1);

namespace Domains\Users\ValueObjects;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Parents\ValueObjects\ValueObject;

final class PasswordValueObject extends \Parents\ValueObjects\ValueObject
{
    protected string $original;

    public function __construct(?string $original)
    {
        if (!$original) {
            $original = Str::random(8);
        }
        parent::__construct($original);
        $this->original = $original;
    }

    public function getOriginal(): string
    {
        return $this->original;
    }

    /**
     * @inheritDoc
     */
    public function sameValueAs(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toNative();
    }

    public function toNative(): string
    {
        return Hash::make($this->original);
    }

    public static function fromNative(?string $value): self
    {
        return new self($value);
    }

    public static function generateRandom(): self
    {
        return new self(Str::random(10));
    }

    public function isNull(): bool
    {
        return false;
    }
}
