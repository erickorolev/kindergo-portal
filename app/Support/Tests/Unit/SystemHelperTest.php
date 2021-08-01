<?php

declare(strict_types=1);

namespace Support\Tests\Unit;

use Support\Helpers\SystemHelper;

class SystemHelperTest extends \Parents\Tests\PhpUnit\UnitTestCase
{
    public function testConvertInteger(): void
    {
        $this->assertEquals(1250, SystemHelper::convertToInt('12.5'));
        $this->assertEquals(1480, SystemHelper::convertToInt(1480));
        $this->assertEquals(0, SystemHelper::convertToInt(null));
        $this->assertEquals(2977, SystemHelper::convertToInt(29.77));
    }
}
