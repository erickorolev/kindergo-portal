<?php

declare(strict_types=1);

namespace Domains\Users\Http\Requests\Admin;

use Parents\Requests\Request;

final class IndexUserRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('list users');
    }
}
