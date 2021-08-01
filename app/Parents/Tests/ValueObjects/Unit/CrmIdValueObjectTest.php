<?php

declare(strict_types=1);

namespace Parents\Tests\ValueObjects\Unit;

use Parents\ValueObjects\CrmIdValueObject;

class CrmIdValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testConvertingToString(): void
    {
        $object = CrmIdValueObject::fromNative('24x533');
        $this->assertEquals('24x533', $object->toNative());
        $this->assertEquals('24x533', (string) $object);
    }

    public function testConvertingToInt(): void
    {
        $object = CrmIdValueObject::fromNative('24x533');
        $this->assertEquals(533, $object->toInt());
    }

    public function testNotEquals(): void
    {
        $object1 = CrmIdValueObject::fromNative('24x533');
        $object2 = CrmIdValueObject::fromNative('24x511');
        $this->assertFalse($object1->sameValueAs($object2));
    }

    public function testEquals(): void
    {
        $object1 = CrmIdValueObject::fromNative('24x533');
        $object2 = CrmIdValueObject::fromNative('24x533');
        $this->assertTrue($object1->sameValueAs($object2));
    }

    public function testNullValue(): void
    {
        $object1 = CrmIdValueObject::fromNative(null);
        $this->assertTrue($object1->isNull());
        $object1 = CrmIdValueObject::fromNative('');
        $this->assertTrue($object1->isNull());
    }

    public function testInvalidArgument(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        CrmIdValueObject::fromNative('42dfs');
    }
}
