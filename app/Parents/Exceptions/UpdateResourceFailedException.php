<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateResourceFailedException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UpdateResourceFailedException extends Exception
{

    public int $httpStatusCode = Response::HTTP_EXPECTATION_FAILED;

    public $message = 'Failed to update Resource.';
}
