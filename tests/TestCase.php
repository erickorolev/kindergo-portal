<?php

namespace Tests;

use App\Domains\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;
use Tests\Traits\VndApiJsonTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use VndApiJsonTrait;

    public function authUser(User $user): void
    {
        Sanctum::actingAs($user, ['*']);
    }
}
