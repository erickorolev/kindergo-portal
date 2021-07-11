<?php

namespace Parents\Traits;

use Parents\Exceptions\CoreInternalErrorException;
use Parents\Repositories\Repository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Trait HasRequestCriteriaTrait
 * @package Parents\Traits
 */
trait HasRequestCriteriaTrait
{

    /**
     * Adds the RequestCriteria to a Repository
     *
     * @param null $repository
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedMethodCall
     */
    public function addRequestCriteria($repository = null): void
    {
        $validatedRepository = $this->validateRepository($repository);

        $validatedRepository->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Removes the RequestCriteria from a Repository
     *
     * @param null $repository
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedMethodCall
     */
    public function removeRequestCriteria($repository = null): void
    {
        $validatedRepository = $this->validateRepository($repository);

        $validatedRepository->popCriteria(RequestCriteria::class);
    }

    /**
     * Validates, if the given Repository exists or uses $this->repository on the Task/Action to apply functions
     *
     * @param $repository
     *
     * @return mixed
     * @throws CoreInternalErrorException
     * @psalm-suppress MixedAssignment
     */
    private function validateRepository(mixed $repository): mixed
    {
        $validatedRepository = $repository;

        // check if we have a "custom" repository
        if (null === $repository) {
            if (! isset($this->repository)) {
                throw new CoreInternalErrorException('No protected or public accessible repository available');
            }
            $validatedRepository = $this->repository;
        }

        // check, if the validated repository is null
        if (null === $validatedRepository) {
            throw new CoreInternalErrorException();
        }

        // check if it is a Repository class
        if (! ($validatedRepository instanceof Repository)) {
            throw new CoreInternalErrorException();
        }

        return $validatedRepository;
    }
}
