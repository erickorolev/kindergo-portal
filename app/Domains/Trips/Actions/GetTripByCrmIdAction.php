<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\Models\Trip;
use Parents\ValueObjects\CrmIdValueObject;

final class GetTripByCrmIdAction extends \Parents\Actions\Action
{
    public function handle(CrmIdValueObject $crmid): ?Trip
    {
        return Trip::where('crmid', $crmid->toNative())->first();
    }
}
