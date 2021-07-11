<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotAuthorizedResourceException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class NotAuthorizedResourceException extends Exception
{

    public int $httpStatusCode = Response::HTTP_FORBIDDEN;

    public $message = 'You are not authorized to request this resource.';
}
