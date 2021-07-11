<?php

declare(strict_types=1);

namespace Parents\Controllers;

use Illuminate\Http\ResponseTrait;

abstract class ApiController extends Controller
{
    use ResponseTrait;

    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     *
     * @var  string
     */
    public string $ui = 'api';

    public function getUrl(): string
    {
        /** @var string $url */
        $url = config('app.url');
        return $url . '/api/v1/';
    }
}
