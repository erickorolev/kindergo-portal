<?php

declare(strict_types=1);

namespace Parents\ValueObjects;

use League\Uri\Uri;

final class UrlValueObject extends ValueObject
{
    public ?Uri $uri;

    public function __construct(?string $url)
    {
        if (!$url) {
            $this->uri = null;
        } else {
            $this->uri = Uri::createFromString($url);
        }
        parent::__construct($this->uri);
    }

    public function isNull(): bool
    {
        return is_null($this->uri);
    }

    /**
     * @param ?string $native
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromNative($native): UrlValueObject
    {
        return new self($native);
    }

    /**
     * @inheritDoc
     */
    public function toNative(): string
    {
        if (!$this->uri) {
            return '';
        }
        return (string) $this->uri;
    }

    public function __toString(): string
    {
        return $this->toNative();
    }

    public function getHost(): ?string
    {
        if (!$this->uri) {
            return null;
        }
        return $this->uri->getHost();
    }

    public function convertToJson(): ?string
    {
        if (!$this->uri) {
            return null;
        }
        return $this->uri->jsonSerialize();
    }

    public function getScheme(): ?string
    {
        if (!$this->uri) {
            return null;
        }
        return $this->uri->getScheme();
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return $this->toNative() === $object->toNative();
    }
}
