<?php

declare(strict_types=1);

namespace Parents\Exceptions;

use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UnsupportedFractalIncludeException extends \Exception
{
    public int $httpStatusCode = SymfonyResponse::HTTP_BAD_REQUEST;

    public $message = 'Requested a invalid Include Parameter.';
}
