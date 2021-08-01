<?php

declare(strict_types=1);

namespace Parents\Middlewares\Http;

use Closure;
use Domains\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class IsAdmin extends \Parents\Middlewares\Middleware
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     * @psalm-suppress MissingReturnType
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasAnyRole(['user', 'super-admin'])) {
            return $next($request);
        }

        abort(403);
    }
}
