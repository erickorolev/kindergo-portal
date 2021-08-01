<?php

declare(strict_types=1);

namespace Domains\Children\Transformers;

use Domains\Children\Models\Child;
use Domains\Trips\Models\Trip;
use Domains\Trips\Transformers\TripTransformer;
use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Parents\Transformers\MediaTransformer;
use Parents\Transformers\Transformer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class ChildTransformer extends Transformer
{
    protected $availableIncludes = [
        'users', 'trips'
    ];

    public function transform(Child $model): array
    {
        $medias = $model->getMedia('avatar');
        $transformer = new MediaTransformer();
        $medias = $medias->map(function (Media $media) use ($transformer) {
            return $transformer->transform($media);
        });
        return [
            'id' => $model->id,
            'firstname' => $model->firstname,
            'lastname' => $model->lastname,
            'middle_name' => $model->middle_name,
            'phone' => $model->phone?->toDisplayValue(),
            'gender' => $model->gender->toArray(),
            'otherphone' => $model->otherphone?->toDisplayValue(),
            'crmid' => $model->crmid?->toNative(),
            'birthday' => $model->birthday,
            'meta' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at
            ],
            'media' => $medias,
        ];
    }

    public function includeUsers(Child $model): \League\Fractal\Resource\Collection
    {
        return $this->collection($model->users, new UserTransformer(), User::RESOURCE_NAME);
    }

    public function includeTrips(Child $model): \League\Fractal\Resource\Collection
    {
        return $this->collection($model->trips, new TripTransformer(), Trip::RESOURCE_NAME);
    }
}
