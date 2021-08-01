<?php

declare(strict_types=1);

namespace Domains\Users\ValueObjects;

use Parents\ValueObjects\ValueObject;

final class FullNameValueObject extends \Parents\ValueObjects\ValueObject
{
    protected string $first_name;

    protected string $last_name;

    protected ?string $middle_name;

    public function __construct(string $first_name, string $last_name, ?string $middle_name)
    {
        parent::__construct($first_name, $last_name, $middle_name);

        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->middle_name = $middle_name;
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
        $middleName = '';
        if ($this->middle_name) {
            $middleName = $this->middle_name;
        }
        return $this->first_name . ' ' . $middleName . ' ' . $this->last_name;
    }

    public static function fromNative(string $first_name, string $last_name, ?string $middle_name): self
    {
        return new self($first_name, $last_name, $middle_name);
    }

    public function isNull(): bool
    {
        return false;
    }
}
