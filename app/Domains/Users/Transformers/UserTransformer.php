<?php

declare(strict_types=1);

namespace Domains\Users\Transformers;

use Domains\Children\Models\Child;
use Domains\Children\Transformers\ChildTransformer;
use Domains\Payments\Models\Payment;
use Domains\Payments\Transformers\PaymentTransformer;
use Domains\Users\Models\User;
use Parents\Transformers\MediaTransformer;
use Parents\Transformers\Transformer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class UserTransformer extends Transformer
{
    protected $availableIncludes = [
        'children', 'timetables', 'payments'
    ];

    /**
     * @param  User  $model
     * @return array
     * @throws \Propaganistas\LaravelPhone\Exceptions\CountryCodeException
     */
    public function transform(User $model): array
    {
        $medias = $model->getMedia('avatar');
        $transformer = new MediaTransformer();
        $medias = $medias->map(function (Media $media) use ($transformer) {
            return $transformer->transform($media);
        });
        return [
            'id' => $model->id,
            'name' => $model->name->toNative(),
            'email' => $model->email,
            'firstname' => $model->firstname,
            'lastname' => $model->lastname,
            'middle_name' => $model->middle_name,
            'phone' => $model->phone?->toDisplayValue(),
            'gender' => $model->gender->toArray(),
            'otherphone' => $model->otherphone?->toDisplayValue(),
            'attendant_category' => $model->attendant_category->toArray(),
            'attendant_status' => $model->attendant_status?->toArray(),
            'attendant_hired' => $model->attendant_hired,
            'birthday' => $model->birthday,
            'mailingzip' => $model->mailingzip,
            'mailingstate' => $model->mailingstate,
            'mailingcountry' => $model->mailingcountry,
            'mailingcity' => $model->mailingcity,
            'mailingstreet' => $model->mailingstreet,
            'otherzip' => $model->otherzip,
            'otherstate' => $model->otherstate,
            'othercountry' => $model->othercountry,
            'othercity' => $model->othercity,
            'otherstreet' => $model->otherstreet,
            'metro_station' => $model->metro_station,
            'car_model' => $model->car_model,
            'car_year' => $model->car_year,
            'car_color' => $model->car_color,
            'resume' => $model->resume,
            'payment_data' => $model->payment_data,
            'meta' => [
                'created_at' => $model->created_at,
                'updated_at' => $model->updated_at
            ],
            'media' => $medias,
        ];
    }

    public function includeChildren(User $model): \League\Fractal\Resource\Collection
    {
        return $this->collection($model->children, new ChildTransformer(), Child::RESOURCE_NAME);
    }

    public function includePayments(User $model): \League\Fractal\Resource\Collection
    {
        return $this->collection($model->payments, new PaymentTransformer(), Payment::RESOURCE_NAME);
    }
}
