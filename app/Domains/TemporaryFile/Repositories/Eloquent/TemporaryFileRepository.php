<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Repositories\Eloquent;

use Domains\TemporaryFile\Models\TemporaryFile;
use Parents\Repositories\Repository;
use Domains\TemporaryFile\Repositories\TemporaryFileRepositoryInterface;

/**
 * Class TemporaryFileRepository
 * @package Domains\TemporaryFile\Repositories\Eloquent
 */
final class TemporaryFileRepository extends Repository implements TemporaryFileRepositoryInterface
{
    public function create(array $attributes): TemporaryFile
    {
        unset($attributes['id']);
        /** @var TemporaryFile $file */
        $file = parent::create($attributes);
        return $file;
    }

    /**
     * @param int $id
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function delete($id): bool
    {
        return (bool) parent::delete($id);
    }

    public function findByFolder(string $folder): ?TemporaryFile
    {
        return TemporaryFile::where('folder', $folder)->first();
    }
}
