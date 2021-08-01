<?php

declare(strict_types=1);

namespace Parents\Loaders;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Parents\Foundation\Facades\Portal;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class RoutesLoaderTrait.
 *
 */
trait RoutesLoaderTrait
{

    /**
     * Register all the containers routes files in the framework
     */
    public function runRoutesAutoLoader(): void
    {
        /** @var array<string> $containersPaths */
        $containersPaths = Portal::getContainersPaths();
        /** @var string $containersNamespace */
        $containersNamespace = Portal::getContainersNamespace();

        foreach ($containersPaths as $containerPath) {
            $this->loadApiContainerRoutes($containerPath, $containersNamespace);
            $this->loadWebContainerRoutes($containerPath, $containersNamespace);
        }
    }

    /**
     * Register the Containers API routes files
     *
     * @param string $containerPath
     * @param string $containersNamespace
     */
    private function loadApiContainerRoutes(string $containerPath, string $containersNamespace): void
    {
        // build the container api routes path
        $apiRoutesPath = $containerPath . '/Routes/Api';
        // build the namespace from the path
        $controllerNamespace = $containersNamespace . '\\Domains\\' .
            basename($containerPath) . '\\Http\Controllers\Api';

        if (File::isDirectory($apiRoutesPath)) {
            $files = File::allFiles($apiRoutesPath);
            $files = Arr::sort($files, function (SplFileInfo $file) {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadApiRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * Register the Containers WEB routes files
     *
     * @param  string  $containerPath
     * @param  string  $containersNamespace
     */
    private function loadWebContainerRoutes(string $containerPath, string $containersNamespace): void
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/Routes/Web';
        // build the namespace from the path
        $controllerNamespace = $containersNamespace . '\\Domains\\' .
            basename($containerPath) . '\\Http\Controllers\Admin';

        if (File::isDirectory($webRoutesPath)) {
            $files = File::allFiles($webRoutesPath);
            $files = Arr::sort($files, function (SplFileInfo $file) {
                return $file->getFilename();
            });

            foreach ($files as $file) {
                $this->loadWebRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * @param  SplFileInfo  $file
     * @param  string  $controllerNamespace
     * @psalm-suppress UnresolvableInclude
     * @psalm-suppress UnusedParam
     */
    private function loadWebRoute(SplFileInfo $file, string $controllerNamespace): void
    {
        Route::group(['prefix' => 'admin',
            'as' => 'admin.', 'middleware' => [
                'web', 'auth']], function (Router $router) use ($file) {
                    require $file->getPathname();
                });
    }

    /**
     * @param  SplFileInfo  $file
     * @param  string  $controllerNamespace
     * @psalm-suppress UnresolvableInclude
     */
    private function loadApiRoute(SplFileInfo $file, string $controllerNamespace): void
    {
        $routeGroupArray = $this->getRouteGroup($file, $controllerNamespace);

        Route::group($routeGroupArray, function (Router $router) use ($file) {
            require $file->getPathname();
        });
    }

    /**
     * @param  SplFileInfo|string  $endpointFileOrPrefixString
     * @param ?string  $controllerNamespace
     *
     * @return  array
     */
    public function getRouteGroup(
        SplFileInfo|string $endpointFileOrPrefixString,
        ?string $controllerNamespace = null
    ): array {
        return [
            'middleware' => $this->getMiddlewares(),
//            'domain'     => $this->getApiUrl(),
            'as' => 'api.',
            // if $endpointFileOrPrefixString is a file then get the version name from the file name,
            // else if string use that string as prefix
            'prefix'     =>  is_string($endpointFileOrPrefixString) ? $endpointFileOrPrefixString :
                $this->getApiVersionPrefix($endpointFileOrPrefixString),
        ];
    }

    /**
     * @return  string
     */
    private function getApiUrl(): string
    {
        /** @var string $url */
        $url = Config::get('portal.api.url');
        return $url;
    }

    /**
     * @param $file
     *
     * @return  string
     */
    private function getApiVersionPrefix(SplFileInfo $file): string
    {
        /** @var string $prefix */
        $prefix = Config::get('portal.api.prefix');
        /** @var string $version */
        $version = Config::get('portal.api.enable_version_prefix');
        return $prefix . ($version ? $this->getRouteFileVersionFromFileName($file) : '');
    }

    /**
     * @return  array
     */
    private function getMiddlewares(): array
    {
        return array_filter([
            'auth:sanctum',
            $this->getRateLimitMiddleware(), // returns NULL if feature disabled. Null will be removed form the array.
        ]);
    }

    /**
     * @return  null|string
     */
    private function getRateLimitMiddleware(): ?string
    {
        $rateLimitMiddleware = null;
        $attempts = (string) Config::get('portal.api.throttle.attempts');
        $expires = (string) Config::get('portal.api.throttle.expires');

        if (Config::get('portal.api.throttle.enabled')) {
            $rateLimitMiddleware = 'throttle:' . $attempts . ',' . $expires;
        }

        return $rateLimitMiddleware;
    }

    /**
     * @param $file
     *
     * @return  string
     */
    private function getRouteFileVersionFromFileName(SplFileInfo $file): string
    {
        $fileNameWithoutExtension = $this->getRouteFileNameWithoutExtension($file);

        $fileNameWithoutExtensionExploded = explode('.', $fileNameWithoutExtension);

        end($fileNameWithoutExtensionExploded);

        $apiVersion = prev($fileNameWithoutExtensionExploded); // get the array before the last one

        // Skip versioning the API's root route
        if ($apiVersion === 'ApisRoot') {
            $apiVersion = '';
        }
        if (!$apiVersion) {
            $apiVersion = '';
        }
        return $apiVersion;
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $file
     *
     * @return  string
     */
    private function getRouteFileNameWithoutExtension(SplFileInfo $file): string
    {
        $fileInfo = pathinfo($file->getFileName());

        return $fileInfo['filename'];
    }
}
