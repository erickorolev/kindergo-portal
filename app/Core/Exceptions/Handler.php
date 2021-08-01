<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<array-key, string>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<array-key, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e) && app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    /**
     * @param  Request  $request
     * @param  \Exception|Throwable  $e
     * @return JsonResponse
     * @psalm-suppress all
     */
    protected function prepareJsonResponse($request, \Exception | \Throwable $e): \Illuminate\Http\JsonResponse
    {
        if (config('app.env') === 'local') {
            return parent::prepareJsonResponse($request, $e);
        }
        return response()->json([
            'errors' => [
                [
                    'title' => Str::title(Str::snake(class_basename($e), ' ')),
                    'details' => $e->getMessage(),
                ]
            ]
        ], $this->isHttpException($e) ? $e->getStatusCode() : 500);
    }

    /**
     * @param  Request  $request
     * @param  ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     * @psalm-suppress InvalidArgument
     */
    protected function invalidJson($request, ValidationException $exception): \Illuminate\Http\JsonResponse
    {
        $errors = ( new Collection($exception->validator->errors()) )
            ->map(function (array $error, string $key): array {
                return [
                    'title' => 'Validation Error',
                    'details' => $error[0],
                    'source' => [
                        'pointer' => '/' . str_replace('.', '/', $key),
                    ]
                ];
            })->values();
        /** @var JsonResponse $response */
        $response = response()->json([
            'errors' => $errors
        ], $exception->status);
        return $response;
    }

    /**
     * @param  Request  $request
     * @param  AuthenticationException  $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception): Response
    {
        if ($request->expectsJson()) {
            return \response()->json([
                'errors' => [
                    [
                        'title' => 'Unauthenticated',
                        'details' => 'You are not authenticated'
                    ]
                ]
            ], 403);
        }
        return redirect()->guest($exception->redirectTo());
    }
}
