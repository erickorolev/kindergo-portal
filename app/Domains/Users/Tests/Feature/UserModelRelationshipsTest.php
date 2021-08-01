<?php

declare(strict_types=1);

namespace Domains\Users\Tests\Feature;

use Domains\Children\Models\Child;
use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Parents\Tests\PhpUnit\TestCase;
use Illuminate\Database\Eloquent\Collection;

class UserModelRelationshipsTest extends TestCase
{
    public function testChildManyRelationships(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Child $child */
        $child = Child::factory()->create();
        $user->children()->attach($child);

        $this->assertInstanceOf(Collection::class, $user->children);
        $this->assertInstanceOf(Child::class, $user->children->first());
        $this->assertEquals($child->id, $user->children->first()?->id);
    }

    public function testPaymentsManyRelationships(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Payment $payment */
        $payment = Payment::factory()->createOne([
            'user_id' => $user->id
        ]);
        $this->assertInstanceOf(Collection::class, $user->payments);
        $this->assertInstanceOf(Payment::class, $user->payments->first());
        $this->assertEquals($payment->id, $user->payments->first()?->id);
    }
}
