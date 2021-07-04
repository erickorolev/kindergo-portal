<?php

declare(strict_types=1);


namespace Tests\Feature\System;

use App\Exceptions\Handler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class HandlerTest extends TestCase
{
    public function testConvertExceptionIntoAJsonApiSpec(): void
    {
        $handler = app(Handler::class);
        $request = Request::create('/test', 'GET');
        $request->headers->set('accept', 'application/vnd.api+json');
        $exception = new \Exception('Test exception');
        /** @var \Illuminate\Http\Response $response */
        $response = $handler->render($request, $exception);
        TestResponse::fromBaseResponse($response)->assertJson([
            'errors' => [
                [
                    'title' => 'Exception',
                    'details' => 'Test exception'
                ]
            ]
        ])->assertStatus(500);
    }

    public function testConvertsAnHttpExceptionIntoAJsonApiSpec(): void
    {
        $handler = app(Handler::class);
        $request = Request::create('/test', 'GET');
        $request->headers->set('accept', 'application/vnd.api+json');
        $exception = new HttpException(404, 'Not Found');
        /** @var \Illuminate\Http\Response $response */
        $response = $handler->render($request, $exception);
        TestResponse::fromBaseResponse($response)->assertJson([
            'errors' => [
                [
                    'title' => 'Http Exception',
                    'details' => 'Not Found'
                ]
            ]
        ])->assertStatus(404);
    }

    public function testConvertsAnUnauthenticatedExceptionIntoAJsonApiSpec(): void
    {
        $handler = app(Handler::class);
        $request = Request::create('/test', 'GET');
        $request->headers->set('accept', 'application/vnd.api+json');
        $exception = new AuthenticationException();
        /** @var \Illuminate\Http\Response $response */
        $response = $handler->render($request, $exception);
        TestResponse::fromBaseResponse($response)->assertJson([
            'errors' => [
                [
                    'title' => 'Unauthenticated',
                    'details' => 'You are not authenticated'
                ]
            ]
        ]);
    }
}
