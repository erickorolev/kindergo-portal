<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ValidationFailedException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ValidationFailedException extends Exception
{

    public int $httpStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    public $message = 'Invalid Input.';
}
