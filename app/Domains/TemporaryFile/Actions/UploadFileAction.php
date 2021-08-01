<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Actions;

use Domains\TemporaryFile\DataTransferObject\TemporaryFileData;
use Domains\TemporaryFile\Models\TemporaryFile;
use Domains\TemporaryFile\Tasks\SaveInDbTask;
use Domains\TemporaryFile\Tasks\StoreFileTask;

final class UploadFileAction extends \Parents\Actions\Action
{
    public function handle(\Illuminate\Http\UploadedFile | array | null $file): string
    {
        if (!$file) {
            return '';
        }
        /** @var ?TemporaryFileData $fileData */
        $fileData = StoreFileTask::run($file);
        if (!$fileData) {
            return '';
        }
        /** @var TemporaryFile $fileModel */
        $fileModel = SaveInDbTask::run($fileData);
        return $fileModel->folder;
    }
}
