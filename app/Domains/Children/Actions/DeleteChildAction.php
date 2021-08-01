<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Models\Child;

final class DeleteChildAction extends \Parents\Actions\Action
{
    public function handle(int $id): bool
    {
        Child::whereId($id)->firstOrFail()->delete();
        return true;
    }
}
