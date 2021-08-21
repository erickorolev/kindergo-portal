<?php

declare(strict_types=1);

namespace Domains\Trips\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Models\Child;
use Domains\Trips\Enums\TripStatusEnum;
use Domains\Trips\Http\Controllers\Api\TripApiController;
use Domains\Trips\Http\Requests\Admin\DeleteTripRequest;
use Domains\Trips\Http\Requests\Admin\IndexTripsRequest;
use Domains\Trips\Http\Requests\Api\TripStoreApiRequest;
use Domains\Trips\Http\Requests\Api\TripUpdateApiRequest;
use Domains\Trips\Models\Trip;
use Domains\Trips\Repositories\Eloquent\TripRepository;
use Domains\Trips\Repositories\TripRepositoryInterface;
use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Parents\Tests\PhpUnit\TestCase;

class TripApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_trips_list(): void
    {
        /** @var Trip[] $trips */
        $trips = Trip::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.trips.index'));

        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 5, fn(AssertableJson $json) =>
            $json
                ->where('type', 'trips')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.name',
                    'attributes.where_address',
                    'attributes.date',
                    'attributes.time',
                    'attributes.childrens',
                    'attributes.status',
                    'attributes.status.value',
                    'attributes.status.description',
                    'attributes.scheduled_wait_where',
                    'attributes.not_scheduled_wait_where',
                    'attributes.scheduled_wait_from',
                    'attributes.not_scheduled_wait_from',
                    'attributes.status',
                    'attributes.parking_cost',
                    'attributes.attendant_income',
                ])->etc())->etc());
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_trip(): void
    {
        $data = Trip::factory()
            ->make()
            ->toArray();
        $data['date'] = '2021-09-08';

        $response = $this->postJson(route('api.trips.store'), [
            'data' => [
                'type' => 'trips',
                'attributes' => $data
            ]
        ]);
        $data['parking_cost'] *= 100;
        $data['attendant_income'] *= 100;
        unset($data['created_at']);
        unset($data['updated_at']);
        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJson([
            'data' => [
                'type' => 'trips',
                'attributes' => [
                    'name' => $data['name'],
                    'where_address' => $data['where_address']
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function it_updates_the_trip(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();
        /** @var User $user */
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->address(),
            'where_address' => $this->faker->address(),
            'date' => '2021-06-08',
            'time' => $this->faker->time(),
            'childrens' => 3,
            'duration' => 8,
            'distance' => 800.54,
            'scheduled_wait_from' => 15,
            'not_scheduled_wait_from' => 16,
            'scheduled_wait_where' => 19,
            'not_scheduled_wait_where' => 25,
            'status' => TripStatusEnum::getRandomValue(),
            'user_id' => $user->id,
            'parking_cost' => $trip->parking_cost?->toFloat(),
            'attendant_income' => $trip->attendant_income?->toFloat(),
            'assigned_user_id' => '19x1',
            'cf_timetable_id' => '24x443',
        ];

        try {
            $response = $this->putJson(
                route('api.trips.update', $trip),
                [
                    'data' => [
                        'id' => (string) $trip->id,
                        'type' => 'trips',
                        'attributes' => $data
                    ]
                ]
            );
            $response->assertStatus(202)->assertJson([
                'data' => [
                    'type' => 'trips',
                    'attributes' => [
                        'name' => $data['name'],
                        'where_address' => $data['where_address'],
                        'childrens' => $data['childrens']
                    ]
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dump($e->errors());
            $this->assertTrue(false, $e->getMessage());
        }
        $data['parking_cost'] *= 100;
        $data['attendant_income'] *= 100;

        $this->assertDatabaseHas('trips', $data);
    }

    /**
     * @test
     */
    public function it_deletes_the_trip(): void
    {
        /** @var Trip $trip */
        $trip = Trip::factory()->create();

        $response = $this->deleteJson(
            route('api.trips.destroy', $trip)
        );

        $trip->refresh();

        $this->assertSoftDeleted($trip);

        $response->assertNoContent();
    }

    /**
     * @test
     */
    public function it_uses_correct_repository(): void
    {
        $repModel = app(TripRepositoryInterface::class);
        $this->assertInstanceOf(TripRepository::class, $repModel);
    }

    /**
     * @test
     */
    public function it_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.trips.index', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_uses_index_request(): void
    {
        $this->assertActionUsesFormRequest(
            TripApiController::class,
            'index',
            IndexTripsRequest::class
        );
    }

    /**
     * @test
     */
    public function store_trip_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            TripApiController::class,
            'store',
            TripStoreApiRequest::class
        );
    }

    /**
     * @test
     */
    public function update_uses_request(): void
    {
        $this->assertActionUsesFormRequest(
            TripApiController::class,
            'update',
            TripUpdateApiRequest::class
        );
    }

    /**
     * @test
     */
    public function delete_uses_request(): void
    {
        $this->assertActionUsesFormRequest(
            TripApiController::class,
            'destroy',
            DeleteTripRequest::class
        );
    }

    public function testGettingChildrenInclude(): void
    {
        /** @var Child $child */
        $child = Child::factory()->createOne([
            'phone' => '+79876757777',
            'otherphone' => '+79024445687'
        ]);
        /** @var Trip $trip */
        $trip = Trip::factory()->createOne();
        $trip->children()->attach($child->id);
        $response = $this->getJson(route('api.trips.show', [
            'trip' => $trip->id,
            'include' => 'children'
        ]));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data')
            ->where('data.type', 'trips')
            ->where('data.id', (string) $trip->id)
            ->has('included')
            ->where('included.0.type', 'children')
            ->where('included.0.id', (string) $child->id)
            ->etc());
    }
}
