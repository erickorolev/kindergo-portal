<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class IncorrectIdException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class IncorrectIdException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_BAD_REQUEST;

    public $message = 'ID input is incorrect.';
}
