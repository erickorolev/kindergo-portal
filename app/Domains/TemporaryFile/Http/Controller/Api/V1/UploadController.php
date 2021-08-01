<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Http\Controller\Api\V1;

use Domains\TemporaryFile\Actions\UploadFileAction;
use Domains\TemporaryFile\Http\Requests\FileUploadRequest;

final class UploadController extends \Parents\Controllers\Controller
{
    public function __invoke(FileUploadRequest $request): string
    {
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            return UploadFileAction::run($file);
        }
        return '';
    }
}
