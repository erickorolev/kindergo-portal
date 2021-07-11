<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class WrongConfigurationException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class WrongConfigurationException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Ops! Some Containers configurations are incorrect!';
}
