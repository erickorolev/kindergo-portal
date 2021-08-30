<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Requests\Api;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Trips\Enums\TripStatusEnum;
use Parents\Requests\Request;

final class TripStoreApiRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'data.attributes.name' => ['required', 'max:190', 'string'],
            'data.attributes.where_address' => ['required', 'max:190', 'string'],
            'data.attributes.date' => ['required', 'date'],
            'data.attributes.time' => ['required', 'date_format:H:i:s'],
            'data.attributes.childrens' => ['required', 'numeric'],
            'data.attributes.duration' => ['required', 'numeric'],
            'data.attributes.distance' => ['required', 'numeric'],
            'data.attributes.status' => [
                'required',
                new EnumValue(TripStatusEnum::class),
            ],
            'data.attributes.attendant_id' => ['nullable'],
            'data.attributes.scheduled_wait_where' => ['required', 'numeric'],
            'data.attributes.not_scheduled_wait_where' => ['nullable', 'numeric'],
            'data.attributes.scheduled_wait_from' => ['required', 'numeric'],
            'data.attributes.not_scheduled_wait_from' => ['nullable', 'numeric'],
            'data.attributes.parking_cost' => ['nullable', 'numeric'],
            'data.attributes.attendant_income' => ['nullable', 'numeric'],
            'data.attributes.crmid' => ['nullable', 'max:50', 'min:3'],
            'data.attributes.description' => ['nullable', 'string', 'max:1000'],
            'data.attributes.parking_info' => ['nullable', 'string', 'max:1000'],
            'data.attributes.cf_timetable_id' => ['required', 'max:50', 'min:3'],
            'data.attributes.assigned_user_id' => ['nullable', 'max:50', 'min:3'],
        ];
        return $this->mergeWithDefaultRules($rules);
    }

    public function authorize(): bool
    {
        return $this->check('create trips');
    }
}
