<?php

namespace Parents\Tests\PhpUnit;

use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Tests\CreatesApplication;
use Units\Tests\Traits\VndApiJsonTrait;

abstract class TestCase extends BaseTestCase
{
    use VndApiJsonTrait;
    use RefreshDatabase;
    use CreatesApplication;

    public bool $seed = false;

    public function authUser(User $user): void
    {
        Sanctum::actingAs($user, ['*']);
    }

    public function getJson($uri, array $headers = []): \Illuminate\Testing\TestResponse
    {
        if (empty($headers)) {
            $headers = [
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json'
            ];
        }
        return parent::getJson($uri, $headers);
    }
}
