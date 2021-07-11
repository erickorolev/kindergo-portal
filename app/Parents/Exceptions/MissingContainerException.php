<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class MissingContainerException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class MissingContainerException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Container not installed.';
}
