<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class EmailIsMissedException
 * @package Parents\Exceptions
 * @psalm-suppress PropertyNotSetInConstructor
 */
class EmailIsMissedException extends Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'One of the Emails is missed, check your configs..';
}
