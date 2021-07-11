<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class UndefinedMethodException
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UndefinedMethodException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_FORBIDDEN;

    public $message = 'Undefined HTTP Verb!';
}
