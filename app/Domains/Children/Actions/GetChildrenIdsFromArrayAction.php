<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Models\Child;
use Domains\Users\Models\User;
use Illuminate\Support\Collection;
use Parents\ValueObjects\CrmIdValueObject;

/**
 * Class GetChildrenIdsFromArrayAction
 * @package Domains\Children\Actions
 * @method static Collection run(array $ids)
 */
final class GetChildrenIdsFromArrayAction extends \Parents\Actions\Action
{
    public function handle(array $ids): Collection
    {
        $result = collect([]);
        foreach ($ids as $id) {
            if (!$id) {
                continue;
            }
            try {
                $crmid = CrmIdValueObject::fromNative((string) $id);
                /** @var ?Child $user */
                $user = GetChildByCrmIdAction::run($crmid);
                $result->push($user?->id);
            } catch (\InvalidArgumentException $ex) {
                /** @var User $user */
                $user = GetChildByIdAction::run($id);
                $result->push($user->id);
            }
        }
        return $result;
    }
}
