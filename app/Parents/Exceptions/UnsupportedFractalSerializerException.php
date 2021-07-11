<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class UnsupportedFractalSerializerException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UnsupportedFractalSerializerException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Unsupported Fractal Serializer!';
}
