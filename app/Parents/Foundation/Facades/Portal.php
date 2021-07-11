<?php

declare(strict_types=1);

namespace Parents\Foundation\Facades;

class Portal extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Portal';
    }
}
