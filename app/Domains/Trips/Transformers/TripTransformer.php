<?php

declare(strict_types=1);

namespace Domains\Trips\Transformers;

use Domains\Children\Models\Child;
use Domains\Children\Transformers\ChildTransformer;
use Domains\Timetables\Models\Timetable;
use Domains\Timetables\Transformers\TimetableTransformer;
use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Domains\Users\Transformers\UserTransformer;
use Parents\Transformers\MediaTransformer;
use Parents\Transformers\Transformer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class TripTransformer extends Transformer
{
    protected $availableIncludes = [
        'timetable', 'children', 'user', 'media'
    ];

    public function transform(Trip $model): array
    {
        $transformer = new MediaTransformer();
        $medias = $model->getMedia('documents');
        $medias = $medias->map(function (Media $media) use ($transformer) {
            return $transformer->transform($media);
        });

        return [
            'id' => $model->id,
            'name' => $model->name,
            'where_address' => $model->where_address,
            'date' => $model->date,
            'time' => $model->time?->toNative(),
            'childrens' => $model->childrens,
            'duration' => $model->duration,
            'distance' => $model->distance,
            'description' => $model->description,
            'parking_info' => $model->parking_info,
            'status' => $model->status->toArray(),
            'scheduled_wait_where' => $model->scheduled_wait_where,
            'scheduled_wait_from' => $model->scheduled_wait_from,
            'not_scheduled_wait_where' => $model->not_scheduled_wait_where,
            'not_scheduled_wait_from' => $model->not_scheduled_wait_from,
            'parking_cost' => $model->parking_cost?->toNative(),
            'attendant_income' => $model->attendant_income?->toNative(),
            'meta' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at
            ],
            'media' => $medias
        ];
    }

    public function includeUser(Trip $model): \League\Fractal\Resource\Item
    {
        return $this->item($model->user, new UserTransformer(), User::RESOURCE_NAME);
    }

    public function includeChildren(Trip $model): \League\Fractal\Resource\Collection
    {
        return $this->collection($model->children, new ChildTransformer(), Child::RESOURCE_NAME);
    }
}
