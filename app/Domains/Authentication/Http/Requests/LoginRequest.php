<?php

declare(strict_types=1);

namespace Domains\Authentication\Http\Requests;

use Parents\Requests\Request;

final class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
