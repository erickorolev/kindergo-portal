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

    public static function convertDocumentsToValueObject(array $docs): array
    {
        $result = array();
        foreach ($docs as $doc) {
            $result[] = UrlValueObject::fromNative(config('services.vtiger.url') .
                $doc['path'] . $doc['attachmentsid'] . '_' . $doc['storedname']);
        }
        return $result;
    }

    public static function getValueObjectFromArray(array $image): UrlValueObject
    {
        if (empty($image)) {
            return UrlValueObject::fromNative(null);
        }
        return UrlValueObject::fromNative($image[0]['url']);
    }
}
