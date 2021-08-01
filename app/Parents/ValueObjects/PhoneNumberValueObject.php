<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

use Parents\Exceptions\ValidationFailedException;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Class PhoneNumberValueObject
 * @package Parents\ValueObjects
 */
final class PhoneNumberValueObject extends ValueObject
{
    /**
     * The provided phone number.
     *
     * @var PhoneNumber
     */
    protected PhoneNumber $number;

    public function __construct(PhoneNumber $value)
    {
        parent::__construct($value);
        $this->number = $value;
    }

    public function isNull(): bool
    {
        $value = $this->number->getRawNumber();
        return strlen($value) < 1;
    }

    /**
     * @psalm-param ?string  $native
     * @return PhoneNumberValueObject
     * @psalm-suppress MoreSpecificImplementedParamType
     * @psalm-suppress PossiblyInvalidCast
     */
    public static function fromNative($native, ?string $country = null): PhoneNumberValueObject
    {
        if (!$native) {
            throw new ValidationFailedException('Phone number is empty!');
        }
        if (!$country) {
            $country = (string) config('app.locale');
        }
        return new self(PhoneNumber::make($native, strtoupper($country)));
    }

    public function toNative(): string
    {
        return $this->number->getRawNumber();
    }

    /**
     * @param  string|null  $country
     * @return string
     * @throws \Propaganistas\LaravelPhone\Exceptions\CountryCodeException
     * @psalm-suppress PossiblyInvalidCast
     */
    public function toDisplayValue(?string $country = null): string
    {
        if (!$country) {
            $country = (string) config('app.locale');
        }
        return $this->number->formatForCountry(strtoupper($country));
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }

    public function __toString(): string
    {
        return $this->number->getRawNumber();
    }
}
