<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

final class TimeValueObject extends ValueObject
{
    private int $hour;

    private int $minute;

    private int $second;

    private function __construct(int $hour, int $minute, int $second)
    {
        if ($hour < 0 || $hour > 24) {
            throw new InvalidArgumentException(sprintf('%s should be in range %d-%d', '$hour', 0, 24));
        }
        if ($minute < 0 || $minute > 60) {
            throw new InvalidArgumentException(sprintf('%s should be in range %d-%d', '$minute', 0, 60));
        }
        if ($second < 0 || $second > 60) {
            throw new InvalidArgumentException(sprintf('%s should be in range %d-%d', '$second', 0, 60));
        }
        parent::__construct($hour, $minute, $second);
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * @inheritDoc
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     * @psalm-param string|null $native
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromNative($native): ?self
    {
        if (!$native) {
            return null;
        }
        return static::createFromDateTime(new DateTimeImmutable($native));
    }

    /**
     * @inheritDoc
     */
    public function toNative(): string
    {
        return sprintf('%02d:%02d:%02d', $this->hour(), $this->minute(), $this->second());
    }

    /**
     * @param DateTimeInterface $dateTime
     *
     * @return self
     */
    public static function createFromDateTime(DateTimeInterface $dateTime): self
    {
        return self::create((int)$dateTime->format('H'), (int)$dateTime->format('i'), (int)$dateTime->format('s'));
    }

    public static function create(int $hour, int $minute, int $second): self
    {
        return new static($hour, $minute, $second);
    }

    /**
     * @return self
     */
    public static function now(): self
    {
        return static::createFromDateTime(new DateTimeImmutable());
    }

    /**
     * @return int
     */
    public function hour(): int
    {
        return $this->hour;
    }

    /**
     * @return int
     */
    public function minute(): int
    {
        return $this->minute;
    }

    /**
     * @return int
     */
    public function second(): int
    {
        return $this->second;
    }

    public function __toString(): string
    {
        return $this->toNative();
    }

    public function laterThan(TimeValueObject $object): bool
    {
        return ($this->hour() > $object->hour()) ||
            ($this->hour() >= $object->hour() && $this->minute() > $object->minute()) ||
            ($this->hour() >= $object->hour() && $this->minute() >= $object->minute()
                && $this->second() > $object->second());
    }

    public function earlierThan(TimeValueObject $object): bool
    {
        return $this->sameValueAs($object) === false && $this->laterThan($object) === false;
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }
}
