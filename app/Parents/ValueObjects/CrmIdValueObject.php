<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

final class CrmIdValueObject extends ValueObject
{
    protected ?string $value;

    public function __construct(?string $value)
    {
        parent::__construct($value);
        if ($value && !str_contains($value, 'x')) {
            throw new \InvalidArgumentException('CRMID have an invalid value');
        }
        $this->value = $value;
    }

    /**
     * @param  string|null  $value
     * @return static
     * @throw \InvalidArgumentException
     */
    public static function fromNative(?string $value): self
    {
        return new self($value);
    }

    public function toInt(): int
    {
        $data = explode('x', (string) $this->value);
        return (int) $data[1];
    }

    /**
     * @inheritDoc
     */
    public function sameValueAs(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }

    public function isNull(): bool
    {
        return $this->value === null || $this->value === '';
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toNative() ?? '';
    }

    public function toNative(): ?string
    {
        return $this->value;
    }
}
