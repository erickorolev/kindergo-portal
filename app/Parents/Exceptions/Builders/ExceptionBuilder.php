<?php

declare(strict_types=1);

namespace Parents\Exceptions\Builders;

use Illuminate\Http\JsonResponse;
use Throwable;

class ExceptionBuilder
{
    /**
     * @param \Exception $e
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public static function make(Throwable $e): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
        ]);
    }
}
