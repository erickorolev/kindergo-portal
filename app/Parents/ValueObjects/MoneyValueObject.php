<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

use Akaunting\Money\Money;

final class MoneyValueObject extends ValueObject
{
    public const CURRENCY = 'RUB';

    /**
     * @var Money
     */
    protected Money $money;

    public function __construct(Money $money)
    {
        parent::__construct($money);
        $this->money = $money;
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @psalm-param int|float|null $native
     * @return ?MoneyValueObject
     * @psalm-suppress UnsafeInstantiation
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromNative($native): ?MoneyValueObject
    {
        if (!$native) {
            return null;
        }
        return new static(\money($native * 100, self::CURRENCY));
    }

    public static function fromFullNative(int $native): MoneyValueObject
    {
        /** @var MoneyValueObject $result */
        $result = self::fromNative($native / 100);
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toNative(): array
    {
        return [
            'amount' => (int) $this->getMoney()->getAmount(),
            'value' => $this->getMoney()->getValue(),
            'currency' => $this->getMoney()->getCurrency()->getSymbol()
        ];
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @param  string|null  $preferred
     * @return string
     * @psalm-suppress PossiblyInvalidCast
     */
    public function getFormattedValue(?string $preferred = null): string
    {
        if (!$preferred) {
            $preferred = (string) config('app.locale', $preferred);
        }
        return $this->money->formatLocale($preferred);
    }

    public function toInt(): int
    {
        $float = strval($this->money->getValue() * 100);
        return (int) $float;
    }

    public function toFloat(): float
    {
        return $this->money->getValue();
    }

    public function __toString(): string
    {
        return (string) $this->toInt();
    }
    /**
     * @inheritDoc
     * @psalm-param MoneyValueObject $object
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function sameValueAs(ValueObject $object): bool
    {
        $money2 = $object->getMoney();
        return $this->money->compare($money2) === 0;
    }
}
