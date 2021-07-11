<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ClassDoesNotExistException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ClassDoesNotExistException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Class does not exist.';
}
