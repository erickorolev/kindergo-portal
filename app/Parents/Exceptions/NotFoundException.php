<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateResourceFailedException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class NotFoundException extends Exception
{

    public int $httpStatusCode = Response::HTTP_NOT_FOUND;

    public $message = 'The requested Resource was not found.';
}
