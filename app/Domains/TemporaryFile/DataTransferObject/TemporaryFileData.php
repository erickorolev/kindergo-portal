<?php

declare(strict_types=1);

namespace Domains\TemporaryFile\DataTransferObject;

use Illuminate\Support\Carbon;
use Parents\DataTransferObjects\ObjectData;
use Parents\Requests\Request;

/**
 * Class TemporaryFileData
 * @package Domains\TemporaryFile\DataTransferObject
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class TemporaryFileData extends \Parents\DataTransferObjects\ObjectData
{
    public ?int $id;

    public string $folder;

    public string $filename;

    public ?Carbon $created_ad;

    public ?Carbon $updated_at;

    /**
     * @param  Request  $request
     * @return static
     * @psalm-suppress MixedArgument
     */
    public static function fromRequest(Request $request): self
    {
        return new self([

        ]);
    }
}
