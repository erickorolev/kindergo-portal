<?php

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class UndefinedTransporterException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UndefinedTransporterException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Default Transporter for Request not defined. Please override $transporter in Parents\Request\.';
}
