<?php

declare(strict_types=1);


namespace Tests\Unit\System;

use App\Parents\Middlewares\Http\EnsureCorrectApiHeaders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PHPUnit\Framework\TestCase;

class EnsureCorrectApiHeadersTest extends TestCase
{
    public function testAbortsRequestIfAcceptHeaderDoesNotAdhereToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'GET');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            $this->fail('Did not abort request because of invalid Accept header');
        });
        $this->assertEquals(406, $response->status());
        $this->assertEquals('application/vnd.api+json', $response->headers->get('content-type'));
    }

    public function testAcceptsRequestIfAcceptHeaderAdheresToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'GET');
        $request->headers->set('accept', 'application/vnd.api+json');
        $request->headers->set('content-type', 'application/vnd.api+json');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            return new Response();
        });
        $this->assertEquals(200, $response->status());
    }

    public function testAbortsPostRequestIfContentTypeHeaderDoesNotAdhereToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'POST');
        $request->headers->set('accept', 'application/vnd.api+json');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            $this->fail('Did not abort request because of invalid Content-Type header');
        });
        $testStatus = $response->status();
        /** @var string $testHeader */
        $testHeader = $response->headers->get('content-type');
        $this->assertEquals(415, $testStatus);
        $this->assertEquals('application/vnd.api+json', $testHeader);
    }

    public function testAbortsPatchRequestIfContentTypeHeaderDoesNotAdhereToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'PATCH');
        $request->headers->set('accept', 'application/vnd.api+json');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            $this->fail('Did not abort request because of invalid Content-Type header');
        });
        $testStatus = $response->status();
        $this->assertEquals(415, $testStatus);
    }

    public function testAcceptsPostRequestIfContentTypeHeaderDoesNotAdhereToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'POST');
        $request->headers->set('accept', 'application/vnd.api+json');
        $request->headers->set('content-type', 'application/vnd.api+json');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            return new Response();
        });
        $this->assertEquals(200, $response->status());
    }

    public function testAcceptsPatchRequestIfContentTypeHeaderDoesNotAdhereToJsonApiSpec(): void
    {
        $request = Request::create('/test', 'POST');
        $request->headers->set('accept', 'application/vnd.api+json');
        $request->headers->set('content-type', 'application/vnd.api+json');
        $middleware = new EnsureCorrectApiHeaders();
        /** @var Response $response */
        $response = $middleware->handle($request, function (): Response {
            return new Response();
        });
        $this->assertEquals(200, $response->status());
    }
}
