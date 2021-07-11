<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class NotImplementedException.
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class NotImplementedException extends Exception
{

    public int $httpStatusCode = Response::HTTP_NOT_IMPLEMENTED;

    public $message = 'This method is not yet implemented.';
}
