<?php

declare(strict_types=1);

namespace Domains\Users\Tests\Unit;

use Domains\Users\ValueObjects\FullNameValueObject;

class FullNameValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testConvertingToString(): void
    {
        $object = FullNameValueObject::fromNative('Sergey', 'Emelyanov', 'Petrovich');
        $this->assertEquals('Sergey Petrovich Emelyanov', $object->toNative());
        $this->assertEquals('Sergey Petrovich Emelyanov', (string) $object);
    }

    public function testConvertingToStringWithEmptyMiddleName(): void
    {
        $object = FullNameValueObject::fromNative('Sergey', 'Emelyanov', null);
        $this->assertEquals('Sergey  Emelyanov', $object->toNative());
        $this->assertEquals('Sergey  Emelyanov', (string) $object);
    }

    public function testComparingTheSameObjects(): void
    {
        $object1 = FullNameValueObject::fromNative('Sergey', 'Emelyanov', 'Petrovich');
        $object2 = FullNameValueObject::fromNative('Sergey', 'Emelyanov', 'Petrovich');
        $this->assertTrue($object1->sameValueAs($object2));
    }

    public function testComparingDifferentObjects(): void
    {
        $object1 = FullNameValueObject::fromNative('Sergey', 'Emelyanov', 'Petrovich');
        $object2 = FullNameValueObject::fromNative('Sergey', 'Emelyanov', null);
        $this->assertFalse($object1->sameValueAs($object2));
    }

    public function testIsNull(): void
    {
        $object = FullNameValueObject::fromNative('', '', null);
        $this->assertFalse($object->isNull());
    }
}
