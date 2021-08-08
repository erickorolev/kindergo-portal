<?php

declare(strict_types=1);

namespace Support\Tests\Unit;

use Support\Helpers\ImageHelper;
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

    public function testGettingValueObjectFromArray(): void
    {
        $data = array(
            [
                "id" => "74",
                "orgname" => "2021-06-28_10-30.png",
                "path" => "storage/2021/August/week1/74",
                "name" => "2021-06-28_10-30.png",
                "url" => "http://crm.kindergou.test/public.php?fid=74&key=2021-06-28_10-30.png"
            ]
        );
        $result = ImageHelper::getValueObjectFromArray($data);
        $this->assertEquals(
            'http://crm.kindergou.test/public.php?fid=74&key=2021-06-28_10-30.png',
            $result->toNative()
        );
    }
}
