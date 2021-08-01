<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\Http\Requests;

/**
 * Class FileUploadRequest
 * @package Domains\TemporaryFile\Http\Requests
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class FileUploadRequest extends \Parents\Requests\Request
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file_upload' => [
                'file', 'mimes:jpg,png,bmp,pdf'
            ]
        ];
    }
}
