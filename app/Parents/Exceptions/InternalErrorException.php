<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class InternalErrorException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class InternalErrorException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Something went wrong!';
}
