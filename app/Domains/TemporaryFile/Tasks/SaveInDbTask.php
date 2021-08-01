<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Tasks;

use Domains\TemporaryFile\DataTransferObject\TemporaryFileData;
use Domains\TemporaryFile\Models\TemporaryFile;
use Domains\TemporaryFile\Repositories\TemporaryFileRepositoryInterface;

final class SaveInDbTask extends \Parents\Tasks\Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function handle(TemporaryFileData $fileData): TemporaryFile
    {
        return $this->repository->create($fileData->toArray());
    }
}
