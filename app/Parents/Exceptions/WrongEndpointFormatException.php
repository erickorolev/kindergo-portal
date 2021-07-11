<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class WrongEndpointFormatException
 * @psalm-suppress PropertyNotSetInConstructor
 */
class WrongEndpointFormatException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'tests ($this->endpoint) property must be formatted as "verb@url".';
}
