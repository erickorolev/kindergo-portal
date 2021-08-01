<?php

declare(strict_types=1);

namespace Parents\Tests\ValueObjects\Unit;

use DateTime;
use Parents\ValueObjects\TimeValueObject;

final class TimeValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testFactory(): void
    {
        $object = TimeValueObject::create(10, 2, 5);

        $this->assertEquals(10, $object->hour());
        $this->assertEquals(2, $object->minute());
        $this->assertEquals(5, $object->second());

        $object = TimeValueObject::createFromDateTime(new DateTime('10:05:25'));

        $this->assertEquals(10, $object->hour());
        $this->assertEquals(5, $object->minute());
        $this->assertEquals(25, $object->second());

        $object = TimeValueObject::fromNative('10:05:25');

        $this->assertEquals(10, $object?->hour());
        $this->assertEquals(5, $object?->minute());
        $this->assertEquals(25, $object?->second());

        $object = TimeValueObject::fromNative(null);
        $this->assertNull($object);
    }

    public function testConvertToString(): void
    {
        $object = TimeValueObject::create(10, 2, 5);
        $this->assertEquals('10:02:05', $object->toNative());
        $this->assertEquals('10:02:05', (string) $object);
    }

    public function testEqualsTo(): void
    {
        $object1 = TimeValueObject::create(10, 2, 5);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertTrue($object1->sameValueAs($object2));

        $object1 = TimeValueObject::create(10, 2, 4);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertFalse($object1->sameValueAs($object2));
    }

    public function testLaterThan(): void
    {
        $object1 = TimeValueObject::create(10, 2, 6);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertTrue($object1->laterThan($object2));

        $object1 = TimeValueObject::create(10, 2, 5);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertFalse($object1->laterThan($object2));

        $object1 = TimeValueObject::create(10, 2, 4);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertFalse($object1->laterThan($object2));
    }

    public function testEarlierThan(): void
    {
        $object1 = TimeValueObject::create(10, 2, 6);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertFalse($object1->earlierThan($object2));

        $object1 = TimeValueObject::create(10, 2, 5);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertFalse($object1->earlierThan($object2));

        $object1 = TimeValueObject::create(10, 2, 4);
        $object2 = TimeValueObject::createFromDateTime(new DateTime('10:02:05'));

        $this->assertTrue($object1->earlierThan($object2));
    }
}
