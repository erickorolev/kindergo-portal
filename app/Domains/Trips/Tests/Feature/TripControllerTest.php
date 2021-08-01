<?php

declare(strict_types=1);

namespace Domains\Trips\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Models\Child;
use Domains\Trips\Enums\TripStatusEnum;
use Domains\Trips\Models\Trip;
use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Parents\Tests\PhpUnit\TestCase;

class TripControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create(['email' => 'admin@admin.com']);

        $this->actingAs(
            $user
        );

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_trips(): void
    {
        /** @var Trip[] $trips */
        $trips = Trip::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('admin.trips.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.index')
            ->assertViewHas('trips');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_trip(): void
    {
        $response = $this->get(route('admin.trips.create'));

        $response->assertOk()->assertViewIs('app.trips.create');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_trip(): void
    {
        /** @var Child $child */
        $child = Child::factory()->createOne();

        $data = Trip::factory()
            ->make()
            ->toArray();

        $data['date'] = '2021-08-06';
        $data['children'] = [$child->id];

        $response = $this->post(route('admin.trips.store'), $data);

        $data['parking_cost'] *= 100;
        $data['attendant_income'] *= 100;
        unset($data['created_at']);
        unset($data['updated_at']);
        unset($data['children']);

        $this->assertDatabaseHas('trips', $data);
        /** @var Trip $trip */
        $trip = Trip::latest('id')->first();
        $this->assertCount(1, $trip->children);

        $response->assertRedirect(route('admin.trips.edit', $trip));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_trip(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();

        $response = $this->get(route('admin.trips.show', $trip));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.show')
            ->assertViewHas('trip');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_trip(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();

        $response = $this->get(route('admin.trips.edit', $trip->id));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.edit')
            ->assertViewHas('trip');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_updates_the_trip(): void
    {
        /** @var User $user */
        $user = User::first();
        /** @var Trip $trip */
        $trip = Trip::factory()->create([
            'user_id' => $user->id
        ]);

        $data = [
            'name' => $this->faker->address(),
            'where_address' => $this->faker->address(),
            'date' => '2021-06-05',
            'attendant_income' => 1456,
            'duration' => 15,
            'distance' => 730.54,
            'time' => $this->faker->time(),
            'childrens' => $this->faker->randomNumber(1),
            'status' => TripStatusEnum::getRandomValue(),
            'scheduled_wait_where' => $this->faker->randomNumber(1),
            'not_scheduled_wait_where' => 23,
            'scheduled_wait_from' => $this->faker->randomNumber(1),
            'not_scheduled_wait_from' => 11,
            'parking_cost' => $this->faker->randomNumber(3),
            'assigned_user_id' => '19x1',
            'cf_timetable_id' => '43x33',
        ];

        $response = $this->put(route('admin.trips.update', $trip), $data);

        $data['id'] = $trip->id;
        $data['parking_cost'] *= 100;
        $data['attendant_income'] *= 100;
        unset($data['created_at']);
        unset($data['updated_at']);

        $this->assertDatabaseHas('trips', $data);

        $response->assertRedirect(route('admin.trips.edit', $trip->id));
    }

    /**
     * @test
     */
    public function it_deletes_the_trip(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();

        $response = $this->delete(route('admin.trips.destroy', $trip));

        $response->assertRedirect(route('admin.trips.index'));

        $this->assertSoftDeleted($trip);
    }
}
