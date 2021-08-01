<?php

declare(strict_types=1);

namespace Domains\Authorization\Http\Requests\Admin;

use Parents\Requests\Request;
use Laravel\Sanctum\Sanctum;

final class StorePermissionRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:64'],
            'roles' => ['array']
        ];
    }

    /**
     * @return bool
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    public function authorize(): bool
    {
        Sanctum::actingAs(request()->user(), [], 'web');
        return $this->check('create permissions');
    }
}
