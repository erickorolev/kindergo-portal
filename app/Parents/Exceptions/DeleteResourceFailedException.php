<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteResourceFailedException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class DeleteResourceFailedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Failed to delete Resource.';
}
