<?php

declare(strict_types=1);

namespace Domains\Children\Http\Requests\Admin;

use BenSampo\Enum\Rules\EnumValue;
use Parents\Enums\GenderEnum;
use Parents\Requests\Request;

final class ChildStoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'max:190', 'string'],
            'lastname' => ['required', 'max:190', 'string'],
            'middle_name' => ['nullable', 'max:190', 'string'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', new EnumValue(GenderEnum::class)],
            'phone' => ['required', 'max:20', 'phone:RU'],
            'otherphone' => ['nullable', 'max:20', 'phone:RU'],
            'imagename' => ['nullable', 'image'],
            'crmid' => ['nullable', 'max:50'],
            'assigned_user_id' => ['nullable', 'max:50', 'min:3'],
            'users' => ['nullable', 'array']
        ];
    }

    public function authorize(): bool
    {
        return $this->check('create children');
    }
}
