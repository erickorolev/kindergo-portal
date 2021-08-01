<?php

declare(strict_types=1);

namespace Domains\Authorization\Http\Requests\Admin;

use Parents\Requests\Request;

final class ShowPermissionRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('view permissions');
    }
}
