<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Tasks;

use Domains\TemporaryFile\Models\TemporaryFile;
use Domains\TemporaryFile\Repositories\TemporaryFileRepositoryInterface;

final class FindFileTask extends \Parents\Tasks\Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function handle(string $folder): ?TemporaryFile
    {
        return $this->repository->findByFolder($folder);
    }
}
