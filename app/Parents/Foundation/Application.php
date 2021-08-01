<?php

declare(strict_types=1);

namespace Parents\Foundation;

final class Application extends \Illuminate\Foundation\Application
{
    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     * @psalm-suppress RedundantConditionGivenDocblockType
     */
    public function getNamespace()
    {
        if (! is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->basePath('composer.json')), true);

        foreach ((array) data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array) $path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
                if (realpath($this->path()) . '/Core' === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }


        throw new \RuntimeException('Unable to detect application namespace.');
    }
}
