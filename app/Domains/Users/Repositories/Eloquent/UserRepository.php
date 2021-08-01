<?php

declare(strict_types=1);

namespace Domains\Users\Repositories\Eloquent;

use Domains\Users\Models\User;
use Parents\Models\Model;
use Parents\QueryBuilder\QB;
use Parents\Repositories\Repository;
use Domains\Users\Repositories\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{

    public function findUser(int $id): User
    {
        /** @var string $type */
        $type = $this->model()::RESOURCE_NAME;
        $includes = $this->getIncludesData($type);
        /** @var User $model */
        $model = QB::for($this->model())
            ->allowedIncludes($includes)
            ->findOrFail($id);

        return $model;
    }
}
