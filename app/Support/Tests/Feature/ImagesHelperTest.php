<?php

declare(strict_types=1);

namespace Support\Tests\Feature;

use Support\Helpers\ImageHelper;

class ImagesHelperTest extends \Parents\Tests\PhpUnit\TestCase
{
    public function testConvertImageArray(): void
    {
        $data = array(
            [
                "attachmentsid" => "74",
                "name" => "2021-06-28_10-30.png",
                "description" => "",
                "type" => "image/png",
                "path" => "storage/2021/August/week1/",
                "storedname" => "89061811daaad0ac66dd2dfa0d331903.png",
                "subject" => null,
                "crmid" => "70"
            ]
        );
        $result = ImageHelper::convertDocumentsToValueObject($data);
        $this->assertEquals(
            config('services.vtiger.url') .
            'storage/2021/August/week1/74_89061811daaad0ac66dd2dfa0d331903.png',
            $result[0]->toNative()
        );
    }
}
