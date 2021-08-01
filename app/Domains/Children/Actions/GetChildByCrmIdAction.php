<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Models\Child;
use Parents\ValueObjects\CrmIdValueObject;

final class GetChildByCrmIdAction extends \Parents\Actions\Action
{
    public function handle(CrmIdValueObject $crmid): ?Child
    {
        return Child::where('crmid', $crmid->toNative())->first();
    }
}
