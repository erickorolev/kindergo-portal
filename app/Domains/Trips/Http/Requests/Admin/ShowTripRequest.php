<?php

declare(strict_types=1);

namespace Domains\Trips\Http\Requests\Admin;

use Parents\Requests\Request;

final class ShowTripRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('view trips');
    }
}
