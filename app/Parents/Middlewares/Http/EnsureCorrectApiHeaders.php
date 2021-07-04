<?php

declare(strict_types=1);

namespace App\Parents\Middlewares\Http;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class EnsureCorrectApiHeaders extends \App\Parents\Middlewares\Middleware
{
    /**
     * Handle an incoming request
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @psalm-suppress PossiblyInvalidMethodCall
     * @psalm-suppress MixedMethodCall
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->routeIs('*.*.storeMedia')) {
            return $next($request);
        }
        if ($request->headers->get('accept') !== 'application/vnd.api+json') {
            return $this->addCorrectContentType(new Response('', 406));
        }
        if ($request->isMethod('POST') || $request->isMethod('PATCH')) {
            if ($request->isMethod('POST') && $request->route()?->getName() == 'api.fileUpload') {
                return $next($request);
            }
            if ($request->header('content-type') !== 'application/vnd.api+json') {
                return $this->addCorrectContentType(new Response('', 415));
            }
        }
        return $next($request);
    }

    private function addCorrectContentType(
        \Symfony\Component\HttpFoundation\Response $response
    ): \Symfony\Component\HttpFoundation\Response {
        $response->headers->set('content-type', 'application/vnd.api+json');
        return $response;
    }
}
