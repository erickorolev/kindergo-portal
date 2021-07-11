<?php

declare(strict_types=1);

namespace Units\Tests\Traits;

trait VndApiJsonTrait
{
    /**
     * Visit the given URI with a GET request, expecting a JSON response.
     *
     * @param  string  $uri
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function getJson($uri, array $headers = []): \Illuminate\Testing\TestResponse
    {
        if (empty($headers)) {
            $headers = array(
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json'
            );
        }
        return parent::getJson($uri, $headers);
    }

    /**
     * Visit the given URI with a POST request, expecting a JSON response.
     *
     * @param  string  $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function postJson($uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        if (empty($headers)) {
            $headers = array(
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json'
            );
        }
        return parent::postJson($uri, $data, $headers);
    }

    /**
     * @param string $uri
     * @param  array  $data
     * @param  array  $headers
     * @return \Illuminate\Testing\TestResponse
     */
    public function putJson($uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        if (empty($headers)) {
            $headers = array(
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json'
            );
        }
        return parent::putJson($uri, $data, $headers);
    }
}
