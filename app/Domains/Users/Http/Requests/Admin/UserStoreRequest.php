<?php

declare(strict_types=1);

namespace Domains\Users\Http\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantGenderEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Parents\Enums\GenderEnum;
use Parents\Requests\Request;

final class UserStoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'max:255', 'string'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required'],
            'firstname' => ['required', 'max:190', 'string'],
            'lastname' => ['required', 'max:190', 'string'],
            'middle_name' => ['nullable', 'max:190', 'string'],
            'phone' => ['required', 'max:20', 'phone:RU'],
            'gender' => ['required', new EnumValue(GenderEnum::class)],
            'otherphone' => ['nullable', 'max:20', 'phone:RU'],
            'attendant_status' => ['required', new EnumValue(AttendantStatusEnum::class)],
            'attendant_category' => ['required', new EnumValue(AttendantCategoryEnum::class)],
            'attendant_hired' => [
                'nullable', 'date'
            ],
            'birthday' => [
                'nullable', 'date'
            ],
            'mailingzip' => ['nullable', 'max:10', 'string'],
            'mailingstate' => ['nullable', 'max:190', 'string'],
            'mailingcountry' => ['nullable', 'max:190', 'string'],
            'mailingcity' => ['nullable', 'max:190', 'string'],
            'mailingstreet' => ['nullable', 'max:190', 'string'],
            'otherzip' => ['nullable', 'max:10', 'string'],
            'otherstate' => ['nullable', 'max:50', 'string'],
            'othercountry' => ['nullable', 'max:190', 'string'],
            'othercity' => ['nullable', 'max:190', 'string'],
            'otherstreet' => ['nullable', 'max:190', 'string'],
            'metro_station' => ['nullable', 'max:190', 'string'],
            'car_model' => ['nullable', 'max:100', 'string'],
            'car_year' => ['nullable', 'max:10', 'string'],
            'car_color' => ['nullable', 'max:190', 'string'],
            'resume' => ['nullable', 'max:255', 'string'],
            'payment_data' => ['nullable', 'max:255', 'string'],
            'imagename' => ['nullable', 'image'],
            'roles' => 'array',
            'external_file' => ['nullable', 'url'],
            'crmid' => ['nullable', 'max:50', 'min:3'],
            'assigned_user_id' => ['required', 'max:50', 'min:3'],
        ];
    }

    public function authorize(): bool
    {
        return $this->check('create users');
    }
}
