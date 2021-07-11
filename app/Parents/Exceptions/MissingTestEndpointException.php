<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class MissingTestEndpointException
 * @psalm-suppress PropertyNotSetInConstructor
 */
class MissingTestEndpointException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Property ($this->endpoint) is missed in your test.';
}
