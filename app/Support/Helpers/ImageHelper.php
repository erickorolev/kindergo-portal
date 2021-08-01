<?php

declare(strict_types=1);

namespace Support\Helpers;

use Parents\ValueObjects\UrlValueObject;

class ImageHelper
{
    public static function imageUrl(
        int $width = 640,
        int $height = 480,
        ?int $id = null,
        bool $randomize = true,
        ?string $word = null,
        bool $gray = false
    ): string {
        // Example : "https://i.picsum.photos/id/10/200/300.jpg";

        $baseUrl = "https://picsum.photos/";

        // ID Random image
//        $url = "id/".$id."/";
        $url = "{$width}/{$height}/";

        return $baseUrl . $url;
    }

    public static function convertToUrlValues(array $urls): array
    {
        $externalFiles = [];
        foreach ($urls as $file) {
            $externalFiles[] =  UrlValueObject::fromNative($file);
        }
        return $externalFiles;
    }
}
