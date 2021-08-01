<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

final class EmailValueObject extends ValueObject
{
    /**
     * @var string
     */
    protected string $string;


    /**
     * EmailTrait constructor.
     * @param ?string $string
     */
    public function __construct(?string $string)
    {
        parent::__construct($string);
        if ($string === null) {
            $string = '';
        }
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address.');
        }

        $this->string = $string;
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @param ?string $native
     * @return EmailValueObject
     * @psalm-suppress UnsafeInstantiation
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromNative($native): EmailValueObject
    {
        return new static($native);
    }

    /**
     * @return string
     */
    public function toNative(): string
    {
        return $this->string;
    }

    public function __toString(): string
    {
        return $this->toNative();
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return ($this->toNative() === $object->toNative());
    }
}
