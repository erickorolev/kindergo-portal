<?php

namespace Parents\Tests\ValueObjects\Unit;

use Parents\ValueObjects\PhoneNumberValueObject;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * Class PhoneNumberValueObjectTest
 * @package Parents\Tests\ValueObjects\Unit
 */
class PhoneNumberValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testIsNullReturnsFalse(): void
    {
        $number = PhoneNumberValueObject::fromNative('+79876757777', 'RU');
        $this->assertFalse($number->isNull());
    }

    public function testIsSameReturnsTrueWhenWePassToSameNumbers(): void
    {
        $number1 = PhoneNumberValueObject::fromNative('+79876757777', 'RU');
        $number2 = PhoneNumberValueObject::fromNative('+79876757777', 'RU');
        $this->assertTrue($number1->sameValueAs($number2));
    }

    public function testIsSameReturnsFalseWhenNumbersDoesNotMatch(): void
    {
        $number1 = PhoneNumberValueObject::fromNative('+79876757778', 'RU');
        $number2 = PhoneNumberValueObject::fromNative('+79876757777', 'RU');
        $this->assertFalse($number1->sameValueAs($number2));
    }

    public function testFromNativeInstances(): void
    {
        $native = '9876757777';
        $test = PhoneNumberValueObject::fromNative($native, 'RU');
        $this->assertEquals($test->toNative(), $native);
    }

    public function testToDisplayValueReturnsCorrectPhoneNumberFormat(): void
    {
        $native = '+79876757777';
        $test = PhoneNumberValueObject::fromNative($native, 'RU');
        $this->assertEquals('8 (987) 675-77-77', $test->toDisplayValue('RU'));
    }
}
