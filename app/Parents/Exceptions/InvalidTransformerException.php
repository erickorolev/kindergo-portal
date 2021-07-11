<?php

namespace Parent\Exceptions;

use Parents\Transformers\Transformer;
use Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class InvalidTransformerException.
 * @psalm-suppress PropertyNotSetInConstructor
 */
class InvalidTransformerException extends Exception
{

    public int $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Transformers must extended the ' . Transformer::class . ' class.';
}
