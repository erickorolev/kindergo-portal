<?php

declare(strict_types=1);

namespace Domains\Children\Actions;

use Domains\Children\Models\Child;
use Domains\Children\Repositories\ChildRepositoryInterface;

final class GetChildByIdAction extends \Parents\Actions\Action
{
    public function __construct(
        protected ChildRepositoryInterface $repository
    ) {
    }

    public function handle(int $id): Child
    {
        /** @var Child $result */
        $result = $this->repository->findJson($id);
        return $result;
    }
}
