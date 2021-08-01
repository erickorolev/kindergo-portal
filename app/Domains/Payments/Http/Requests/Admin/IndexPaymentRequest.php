<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Requests\Admin;

use Parents\Requests\Request;

final class IndexPaymentRequest extends Request
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function authorize(): bool
    {
        return $this->check('list payments');
    }
}
