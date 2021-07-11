<?php

namespace Parents\Transformers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaTransformer extends Transformer
{
    public function transform(Media $media): array
    {
        return [
            'id' => $media->id,
            'url' => $media->getFullUrl(),
            'size' => $media->size,
            'mime_type' => $media->mime_type,
            'responsive' => $media->getResponsiveImageUrls()
        ];
    }
}
