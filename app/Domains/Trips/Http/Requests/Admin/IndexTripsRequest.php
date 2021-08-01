<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Requests\Admin;

use Parents\Requests\Request;

final class IndexTripsRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('list trips');
    }
}
