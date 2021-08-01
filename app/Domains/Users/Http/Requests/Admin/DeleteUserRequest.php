<?php

declare(strict_types=1);

namespace Domains\Users\Http\Requests\Admin;

use Parents\Requests\Request;

final class DeleteUserRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('delete users');
    }
}
