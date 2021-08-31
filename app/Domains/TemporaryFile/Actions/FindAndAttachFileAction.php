<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Actions;

use Domains\TemporaryFile\Models\TemporaryFile;
use Domains\TemporaryFile\Tasks\AttachFileToModelTask;
use Domains\TemporaryFile\Tasks\FindFileTask;
use Parents\Exceptions\ValidationFailedException;
use Parents\Models\Model;
use Spatie\MediaLibrary\HasMedia;

final class FindAndAttachFileAction extends \Parents\Actions\Action
{
    public function handle(string $folder, HasMedia $destination, string $collection = 'avatar'): bool
    {
        /** @var ?TemporaryFile $fileModel */
        $fileModel = FindFileTask::run($folder);

        if (!$fileModel) {
            /** @var Model $destination */
            $destination->forceDelete();
            throw new ValidationFailedException('Passed folder is incorrect!');
        }
        /** @var bool $result */
        $result = AttachFileToModelTask::run($fileModel, $destination, $collection);
        return $result;
    }
}
