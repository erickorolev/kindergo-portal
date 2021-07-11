<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class MissingJSONHeaderException
 * @psalm-suppress PropertyNotSetInConstructor
 */
class MissingJSONHeaderException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_BAD_REQUEST;

    public $message = 'Your request must contain [Accept = application/json].';
}
