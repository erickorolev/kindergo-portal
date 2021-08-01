<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Repositories;

use Domains\TemporaryFile\Models\TemporaryFile;
use Illuminate\Support\Collection;

interface TemporaryFileRepositoryInterface
{
    public function create(array $attributes): TemporaryFile;

    /**
     * @param int $id
     */
    public function delete($id): bool;

    public function findByFolder(string $folder): ?TemporaryFile;
}
