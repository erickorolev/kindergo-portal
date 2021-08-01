<?php

declare(strict_types=1);

namespace Domains\Trips\Tests\Feature;

use Domains\Children\Models\Child;
use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Parents\Tests\PhpUnit\TestCase;

class ModelRelationTest extends TestCase
{
    public function testUserRelationship(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Trip $trip */
        $trip = Trip::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $trip->user_id);
        $this->assertInstanceOf(User::class, $trip->user);
        $this->assertEquals($user->id, $trip->user->id);
    }

    public function testChildrenRelationship(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();
        /** @var Child $child */
        $child = Child::factory()->create();
        $trip->children()->attach($child);

        $this->assertInstanceOf(Collection::class, $trip->children);
        $this->assertInstanceOf(Child::class, $trip->children->first());
        $this->assertEquals($child->id, $trip->children->first()?->id);
    }
}
