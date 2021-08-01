<?php

declare(strict_types=1);

namespace Domains\Authorization\DataTransferObjects;

use Parents\DataTransferObjects\ObjectData;
use Illuminate\Support\Carbon;
use Parents\Requests\Request;

final class RoleData extends ObjectData
{
    public ?int $id;

    public string $name;

    public array $permissions = [];

    public Carbon $created_at;

    public Carbon $updated_at;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'created_at' => now(),
            'updated_at' => now(),
            'name' => $request->input('name'),
            'permissions' => $request->input('permissions', [])
        ]);
    }
}
