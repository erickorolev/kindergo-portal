<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\DataTransferObjects\ChildData;
use Domains\Children\Models\Child;
use Domains\Children\Services\ChildConnector;

final class ReceiveChildFromCrmAction extends \Parents\Actions\Action
{
    public function handle(int $id): Child
    {
        $service = app(ChildConnector::class);
        $crmUser = $service->receiveById('Contacts', $id);
        $childData = ChildData::fromConnector($crmUser);
        $existingUser = GetChildByCrmIdAction::run($childData->crmid);
        if ($existingUser) {
            $childData->id = $existingUser->id;
            /** @var Child $child */
            $child = UpdateChildAction::run($childData, false);
        } else {
            /** @var Child $child */
            $child = StoreChildAction::run($childData, false);
        }
        return $child;
    }
}
