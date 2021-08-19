<?php

declare(strict_types=1);

namespace Domains\Users\Http\Requests\Api;

use BenSampo\Enum\Rules\EnumValue;
use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantGenderEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Parents\Enums\GenderEnum;
use Parents\Requests\Request;

final class UserUpdateApiRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'data.attributes.name' => ['nullable', 'max:255', 'string'],
            'data.attributes.email' => ['required',
                Rule::unique('users', 'email')->ignore($this->user, 'id'),
                'email',],
            'data.attributes.password' => ['nullable'],
            'data.attributes.firstname' => ['required', 'max:190', 'string'],
            'data.attributes.lastname' => ['required', 'max:190', 'string'],
            'data.attributes.middle_name' => ['nullable', 'max:190', 'string'],
            'data.attributes.phone' => ['required', 'phone:RU'],
            'data.attributes.gender' => ['required', new EnumValue(GenderEnum::class)],
            'data.attributes.attendant_status' => ['required', new EnumValue(AttendantStatusEnum::class)],
            'data.attributes.attendant_category' => ['required', new EnumValue(AttendantCategoryEnum::class)],
            'data.attributes.attendant_hired' => [
                'nullable', 'date'
            ],
            'data.attributes.birthday' => [
                'nullable', 'date'
            ],
            'data.attributes.mailingzip' => ['nullable', 'max:10', 'string'],
            'data.attributes.mailingstate' => ['nullable', 'max:190', 'string'],
            'data.attributes.mailingcountry' => ['nullable', 'max:190', 'string'],
            'data.attributes.mailingcity' => ['nullable', 'max:190', 'string'],
            'data.attributes.mailingstreet' => ['nullable', 'max:190', 'string'],
            'data.attributes.otherzip' => ['nullable', 'max:10', 'string'],
            'data.attributes.otherstate' => ['nullable', 'max:50', 'string'],
            'data.attributes.othercountry' => ['nullable', 'max:190', 'string'],
            'data.attributes.othercity' => ['nullable', 'max:190', 'string'],
            'data.attributes.otherstreet' => ['nullable', 'max:190', 'string'],
            'data.attributes.metro_station' => ['nullable', 'max:190', 'string'],
            'data.attributes.car_model' => ['nullable', 'max:100', 'string'],
            'data.attributes.car_year' => ['nullable', 'max:10', 'string'],
            'data.attributes.car_color' => ['nullable', 'max:190', 'string'],
            'data.attributes.resume' => ['nullable', 'max:255', 'string'],
            'data.attributes.payment_data' => ['nullable', 'max:255', 'string'],
            'data.attributes.otherphone' => ['nullable', 'phone:RU'],
            'data.attributes.file' => ['nullable', 'max:100'],
            'data.attributes.roles' => ['nullable', 'array'],
            'data.attributes.external_file' => ['nullable', 'url'],
            'data.attributes.crmid' => ['nullable', 'max:50', 'min:3'],
            'data.attributes.assigned_user_id' => ['nullable', 'max:50', 'min:3'],
        ];
        return $this->mergeWithDefaultRules($rules);
    }

    public function authorize(): bool
    {
        return Auth::id() == $this->user || $this->check('update users');
    }
}
