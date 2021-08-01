<?php

declare(strict_types=1);

namespace Domains\Users\Actions;

use Domains\Users\Models\User;
use Domains\Users\Repositories\UserRepositoryInterface;

/**
 * Class GetUserByIdAction
 * @package Domains\Users\Actions
 * @method static User run(int $id)
 */
final class GetUserByIdAction extends \Parents\Actions\Action
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    public function handle(int $id): User
    {
        return $this->repository->findUser($id);
    }
}
