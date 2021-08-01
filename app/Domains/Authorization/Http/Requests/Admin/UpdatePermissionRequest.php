<?php

declare(strict_types=1);

namespace Domains\Authorization\Http\Requests\Admin;

use Parents\Requests\Request;

final class UpdatePermissionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:40',
            'roles' => 'array'
        ];
    }

    public function authorize(): bool
    {
        return $this->check('update permissions');
    }
}
