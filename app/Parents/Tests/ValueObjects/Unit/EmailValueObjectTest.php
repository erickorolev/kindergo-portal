<?php

namespace Parents\Tests\ValueObjects\Unit;

use Parents\ValueObjects\EmailValueObject;

/**
 * Class EmailValueObjectTest
 * @package Parents\Tests\ValueObjects\Unit
 */
class EmailValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testIsNullReturnsFalse(): void
    {
        $test = new EmailValueObject('test@test.com');
        $this->assertFalse($test->isNull());
    }

    public function testIsSameReturnsTrueWhenValuesMatch(): void
    {
        $test1 = new EmailValueObject('test@test.com');
        $test2 = new EmailValueObject('test@test.com');

        $this->assertTrue($test1->sameValueAs($test2));
    }

    public function testIsSameReturnsFalseWhenValuesMismatch(): void
    {
        $test1 = new EmailValueObject('test@test.com');
        $test2 = new EmailValueObject('test2@test.com');

        $this->assertFalse($test1->sameValueAs($test2));
    }

    public function testFromNativeInstantiatesWithValidString(): void
    {
        $test = EmailValueObject::fromNative('test@test.com');
        $this->assertEquals('test@test.com', $test->toNative());
    }

    public function test_from_native_throws_exception_with_invalid_string(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        EmailValueObject::fromNative('invalid');
    }
}
