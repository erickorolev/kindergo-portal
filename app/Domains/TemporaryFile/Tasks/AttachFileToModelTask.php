<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Tasks;

use Domains\TemporaryFile\Models\TemporaryFile;
use Domains\TemporaryFile\Repositories\TemporaryFileRepositoryInterface;
use Spatie\MediaLibrary\HasMedia;

final class AttachFileToModelTask extends \Parents\Tasks\Task
{
    protected TemporaryFileRepositoryInterface $repository;

    public function __construct(
        TemporaryFileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function handle(TemporaryFile $file, HasMedia $destination, string $collection = 'avatar'): bool
    {
        $destination->addMedia(storage_path('app/public/uploads/tmp/' . $file->folder . '/' . $file->filename))
            ->toMediaCollection($collection);
        rmdir(storage_path('app/public/uploads/tmp/' . $file->folder . '/'));
        $this->repository->delete($file->id);
        return true;
    }
}
