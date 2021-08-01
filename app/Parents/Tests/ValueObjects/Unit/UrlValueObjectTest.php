<?php

declare(strict_types=1);

namespace Parents\Tests\ValueObjects\Unit;

use Parents\ValueObjects\UrlValueObject;

final class UrlValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testIsNullReturnsCorrectValue(): void
    {
        $obj = UrlValueObject::fromNative(null);
        $this->assertTrue($obj->isNull());
        $obj = UrlValueObject::fromNative('https://ya.ru');
        $this->assertFalse($obj->isNull());
    }

    public function testComparingValueObjects(): void
    {
        $obj1 = UrlValueObject::fromNative('https://google.com');
        $obj2 = UrlValueObject::fromNative('https://google.com');
        $this->assertTrue($obj1->sameValueAs($obj2));
        $obj3 = UrlValueObject::fromNative('https://ya.ru');
        $this->assertFalse($obj1->sameValueAs($obj3));
    }

    public function testConvertingToString(): void
    {
        $obj = new UrlValueObject('https://sergeyem.ru/blog');
        $this->assertEquals('https://sergeyem.ru/blog', $obj->toNative());
        $this->assertEquals('https://sergeyem.ru/blog', (string) $obj);
    }

    public function testJsonConvertion(): void
    {
        $obj = new UrlValueObject("http://foo:bar@www.example.com:81/how/are/you?foo=baz#title");
        $this->assertEquals('http://foo:bar@www.example.com:81/how/are/you?foo=baz#title', $obj->convertToJson());
    }

    public function testGettingDomainFromValueObject(): void
    {
        $obj = new UrlValueObject('https://sergeyem.ru/blog');
        $this->assertEquals('sergeyem.ru', $obj->getHost());
        $obj = new UrlValueObject(null);
        $this->assertNull($obj->getHost());
    }

    public function testGettingSchemeFromValueObject(): void
    {
        $obj = new UrlValueObject('https://sergeyem.ru/blog');
        $this->assertEquals('https', $obj->getScheme());
        $obj = new UrlValueObject(null);
        $this->assertNull($obj->getScheme());
    }
}
