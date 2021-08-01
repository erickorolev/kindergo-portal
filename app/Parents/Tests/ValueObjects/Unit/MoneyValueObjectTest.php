<?php

namespace Parents\Tests\ValueObjects\Unit;

use Akaunting\Money\Money;
use Parents\ValueObjects\MoneyValueObject;

/**
 * Class MoneyValueObjectTest
 * @package Parents\Tests\ValueObjects\Unit
 */
class MoneyValueObjectTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testIsNullReturnsFalse(): void
    {
        $test = new MoneyValueObject(money(5000, 'RUB'));
        $this->assertFalse($test->isNull());
    }

    public function testCreateFromNativeWithNullReturnsNull(): void
    {
        $test = MoneyValueObject::fromNative(null);
        $this->assertNull($test);
    }

    public function testIsSameReturnsTrueWherAmountAndCurrencyMatch(): void
    {
        $money = money(10000, 'RUB');

        $test1 = new MoneyValueObject($money);
        $test2 = new MoneyValueObject($money);

        $this->assertTrue($test1->sameValueAs($test2));
    }

    public function testIsSameReturnsFalseAmountDoesNotMatch(): void
    {
        $money1 = money(1000, 'RUB');
        $money2 = money(1001, 'RUB');

        $test1 = new MoneyValueObject($money1);
        $test2 = new MoneyValueObject($money2);

        $this->assertFalse($test1->sameValueAs($test2));
    }

    public function testIsSameReturnsExceptionCurrencyDoesNotMatch(): void
    {
        $money1 = money(5000, 'RUB');
        $money2 = money(5000, 'EUR');

        $test1 = new MoneyValueObject($money1);
        $test2 = new MoneyValueObject($money2);

        $this->expectException(\InvalidArgumentException::class);
        $test1->sameValueAs($test2);
    }

    public function testFromNativeInstances(): void
    {
        $native = 6300;

        $test = MoneyValueObject::fromNative($native);
        $this->assertEquals($native * 100, $test?->toInt());
    }


    public function testToNativeReturnsCorrectRepresentationOfMoney(): void
    {
        $money = money(1200, 'RUB');

        $test = new MoneyValueObject($money);
        $this->assertEquals([
            'amount' => 1200,
            'value' => $test->toFloat(),
            'currency' => '₽'
        ], $test->toNative());
    }

    public function testReturnsCorrectMoneyObject(): void
    {
        $money = money(5000, 'RUB');

        $test = new MoneyValueObject($money);
        $this->assertEquals(5000, $test->getMoney()->getAmount());
        $this->assertEquals('Russian Ruble', $test->getMoney()->getCurrency()->getName());
    }

    public function testToIntReturnsCorrectValue(): void
    {
        $money = money(10000, 'RUB');

        $test1 = new MoneyValueObject($money);
        $this->assertEquals(10000, $test1->toInt());
    }

    public function testFormattedValue(): void
    {
        $money = money(15000, 'RUB');

        $test1 = new MoneyValueObject($money);
        $this->assertEquals('150,00 ₽', $test1->getFormattedValue('ru'));
    }
}
