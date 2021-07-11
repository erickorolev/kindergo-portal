<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateResourceFailedException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CreateResourceFailedException extends Exception
{
    public int $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Failed to create Resource.';
}
