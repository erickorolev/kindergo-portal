<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Models\Child;
use Illuminate\Support\Collection;

final class GetChildrenDropdownListAction extends \Parents\Actions\Action
{
    public function handle(): Collection
    {
        return Child::all()->pluck('lastname', 'id');
    }
}
