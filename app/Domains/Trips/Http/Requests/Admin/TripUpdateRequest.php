<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Trips\Enums\TripStatusEnum;
use Parents\Requests\Request;

final class TripUpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:190', 'string'],
            'where_address' => ['required', 'max:190', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'childrens' => ['required', 'numeric'],
            'duration' => ['required', 'numeric'],
            'distance' => ['required', 'numeric'],
            'status' => [
                'required',
                new EnumValue(TripStatusEnum::class),
            ],
            'attendant_id' => ['nullable'],
            'scheduled_wait_where' => ['required', 'numeric'],
            'not_scheduled_wait_where' => ['nullable', 'numeric'],
            'scheduled_wait_from' => ['required', 'numeric'],
            'not_scheduled_wait_from' => ['nullable', 'numeric'],
            'parking_cost' => ['required', 'numeric'],
            'attendant_income' => ['nullable', 'numeric'],
            'crmid' => ['nullable', 'max:50', 'min:3'],
            'assigned_user_id' => ['nullable', 'max:50', 'min:3'],
            'document' => 'nullable',
            'document.*' => 'mimes:doc,pdf,docx,zip,png,jpn'
        ];
    }

    public function authorize(): bool
    {
        return $this->check('update trips');
    }
}
