<?php

declare(strict_types=1);

namespace Domains\Payments\Tests\Feature;

use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Parents\Tests\PhpUnit\TestCase;

class ModelRelationTest extends TestCase
{
    public function testUserRelation(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var Payment $payment */
        $payment = Payment::factory()->createOne([
            'user_id' => $user->id
        ]);
        $this->assertEquals($user->id, $payment->user_id);
        $this->assertInstanceOf(User::class, $payment->user);
        $this->assertEquals($user->id, $payment->user->id);
    }
}
