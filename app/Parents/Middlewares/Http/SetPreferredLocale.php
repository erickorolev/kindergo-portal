<?php

declare(strict_types=1);

namespace Parents\Middlewares\Http;

use Closure;
use Parents\Requests\Request;

class SetPreferredLocale extends \Parents\Middlewares\Middleware
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param  Closure  $next
     * @return mixed
     * @psalm-suppress MixedMethodCall
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function handle($request, Closure $next)
    {
        /** @var array<array-key, mixed> $supportedLanguages */
        $supportedLanguages = config('project.supported_languages');
        $locales  = array_column($supportedLanguages, 'short_code');
        /** @var string $language */
        $language = $request->getPreferredLanguage($locales);

        app()->setLocale($language);

        return $next($request);
    }
}
