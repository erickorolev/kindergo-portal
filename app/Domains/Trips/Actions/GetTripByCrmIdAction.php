<?php

declare(strict_types=1);

namespace Domains\Trips\Actions;

use Domains\Trips\Models\Trip;
use Parents\ValueObjects\CrmIdValueObject;

/**
 * @method static Trip|null run(?CrmIdValueObject $crmid)
 */
final class GetTripByCrmIdAction extends \Parents\Actions\Action
{
    public function handle(?CrmIdValueObject $crmid): ?Trip
    {
        if (!$crmid) {
            return null;
        }
        return Trip::where('crmid', $crmid->toNative())->first();
    }
}
