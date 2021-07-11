<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

use JessArcher\CastableDataTransferObject\CastableDataTransferObject;

abstract class ValueObject extends CastableDataTransferObject
{
    /**
     * Compare two ValueObjectInterface and tells whether they can be considered equal
     *
     * @param  ValueObject $object
     * @return bool
     */
    abstract public function sameValueAs(ValueObject $object): bool;

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    abstract public function __toString(): string;

    abstract public function toNative(): mixed;
}
