<?php

declare(strict_types=1);

namespace Domains\Users\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Models\Child;
use Domains\TemporaryFile\Actions\UploadFileAction;
use Domains\Users\Actions\GetUserByEmailAction;
use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Domains\Users\Http\Controllers\Api\UserApiController;
use Domains\Users\Http\Requests\Admin\DeleteUserRequest;
use Domains\Users\Http\Requests\Admin\IndexUserRequest;
use Domains\Users\Http\Requests\Api\UserStoreApiRequest;
use Domains\Users\Http\Requests\Api\UserUpdateApiRequest;
use Domains\Users\Jobs\SendUserToVtigerJob;
use Domains\Users\Models\User;
use Domains\Users\Notifications\PasswordSendNotification;
use Domains\Users\Repositories\Eloquent\UserRepository;
use Domains\Users\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Parents\Enums\GenderEnum;
use Parents\Tests\PhpUnit\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create([
            'email' => 'admin@admin.com',
            'phone' => '+79067598835',
            'otherphone' => '+79087756389'
        ]);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_users_list(): void
    {
        User::factory()
            ->count(5)
            ->create([
                'phone' => '+79025689977',
                'otherphone' => '+79086675566'
            ]);

        $response = $this->getJson(route('api.users.index'));

        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 6, fn(AssertableJson $json) =>
            $json
                ->where('type', 'users')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.name',
                    'attributes.email',
                    'attributes.firstname',
                    'attributes.lastname',
                    'attributes.middle_name',
                    'attributes.phone',
                    'attributes.gender',
                    'attributes.gender.value',
                    'attributes.gender.description',
                    'attributes.otherphone',
                    'attributes.media',
                ])->etc())->etc());
    }

    /**
     * @test
     */
    public function it_uses_correct_repository(): void
    {
        $repModel = app(UserRepositoryInterface::class);
        $this->assertInstanceOf(UserRepository::class, $repModel);
    }

    /**
     * @test
     */
    public function it_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.users.index', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_uses_index_request(): void
    {
        $this->assertActionUsesFormRequest(
            UserApiController::class,
            'index',
            IndexUserRequest::class
        );
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_user(): void
    {
        Bus::fake();

        Notification::fake();
        Notification::assertNothingSent();

        $data = User::factory()
            ->make()
            ->toArray();
        $data['phone'] = '+79876757777';
        $data['otherphone'] = '+79022884433';
        $data['password'] = \Str::random(8);
        $data['birthday'] = '1986-08-06';
        $data['attendant_hired'] = '2021-08-07';

        try {
            $response = $this->postJson(route('api.users.store'), [
                'data' => [
                    'type' => 'users',
                    'attributes' => $data
                ]
            ]);
            unset($data['password']);
            unset($data['email_verified_at']);
            unset($data['current_team_id']);
            unset($data['imagename']);
            unset($data['name']);

            $this->assertDatabaseHas('users', $data);

            $response->assertStatus(201)->assertJson([
                'data' => [
                    'attributes' => [
                        'name' => $data['firstname'] . ' ' . $data['middle_name'] . ' ' . $data['lastname'],
                        'email' => $data['email'],
                        'firstname' => $data['firstname'],
                        'lastname' => $data['lastname'],
                        'phone' => '8 (987) 675-77-77',
                        'otherphone' => '8 (902) 288-44-33'
                    ]
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            dump($ex->errors());
            $this->assertTrue(false, $ex->getMessage());
        }
        Bus::assertDispatched(SendUserToVtigerJob::class);
        Notification::assertSentTo(
            [GetUserByEmailAction::run($data['email'])],
            PasswordSendNotification::class
        );
    }

    /**
     * @test
     */
    public function store_uses_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            UserApiController::class,
            'store',
            UserStoreApiRequest::class
        );
    }

    /**
     * @test
     */
    public function store_controller_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.users.store', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_updates_the_user(): void
    {
        Bus::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $data = [
            'data' => [
                'type' => 'users',
                'id' => (string) $user->id,
                'attributes' => [
                    'name' => $this->faker->name(),
                    'email' => $this->faker->email(),
                    'firstname' => $this->faker->firstName(),
                    'lastname' => $this->faker->lastName(),
                    'middle_name' => $this->faker->text(10),
                    'phone' => '+79876757777',
                    'gender' => GenderEnum::getRandomValue(),
                    'attendant_category' => AttendantCategoryEnum::getRandomValue(),
                    'attendant_status' => AttendantStatusEnum::getRandomValue(),
                    'otherphone' => '+79086665478',
                    'assigned_user_id' => '19x1'
                ]
            ]
        ];

        $response = $this->putJson(route('api.users.update', ['user' => $user->id]), $data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'middle_name' => $data['data']['attributes']['middle_name']
        ]);
        $user->refresh();

        $response->assertStatus(202)->assertJson([
            'data' => [
                'attributes' => [
                ]
            ]
        ]);
        $this->assertEquals($data['data']['attributes']['middle_name'], $user->middle_name);
        $this->assertEquals($data['data']['attributes']['firstname'], $user->firstname);
        $this->assertEquals($data['data']['attributes']['lastname'], $user->lastname);
        $this->assertEquals($data['data']['attributes']['phone'], $user->phone?->toNative());
        $this->assertEquals($data['data']['attributes']['otherphone'], $user->otherphone?->toNative());

        Bus::assertDispatched(SendUserToVtigerJob::class);
    }

    /**
     * @test
     */
    public function update_uses_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            UserApiController::class,
            'update',
            UserUpdateApiRequest::class
        );
    }

    /**
     * @test
     */
    public function update_controller_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.users.update', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_deletes_the_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->deleteJson(route('api.users.destroy', $user));

        $this->assertSoftDeleted($user);

        $response->assertNoContent();
    }

    /**
     * @test
     */
    public function delete_uses_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            UserApiController::class,
            'destroy',
            DeleteUserRequest::class
        );
    }

    /**
     * @test
     */
    public function delete_controller_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.users.destroy', ['auth:sanctum']);
    }

    public function testImagesAdding(): void
    {
        Bus::fake();
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
        $result = UploadFileAction::run($file);
        $this->assertFileExists(storage_path('app/public/uploads/tmp/' . $result . '/test.pdf'));
        $user = User::factory()->makeOne([
            'phone' => '+79086447896',
            'otherphone' => '+79996457899'
        ]);
        $userData = $user->toArray();
        $userData['birthday'] = '1986-08-06';
        $userData['attendant_hired'] = '2021-08-07';
        $userData['file'] = $result;
        try {
            $response = $this->postJson(route('api.users.store'), [
                'data' => [
                    'type' => 'users',
                    'attributes' => $userData
                ]
            ], [
                'Accept' => 'application/vnd.api+json',
                'Content-Type' => 'application/vnd.api+json'
            ]);
            $response->assertSessionDoesntHaveErrors();
            $response->assertCreated();
            $response->assertJson(fn(AssertableJson $json) =>
            $json->has('data')->has('data.id')->has('data.type')
                ->has('data.attributes.media')
                ->count('data.attributes.media', 1)
                ->etc());
        } catch (\Illuminate\Validation\ValidationException $exception) {
            dump($exception->errors());
            $this->assertTrue(false, $exception->getMessage());
        }


        $this->assertDatabaseHas('users', [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname
        ]);
        $this->assertDatabaseHas('media', [
            'collection_name' => 'avatar',
            'model_type' => 'Domains\Users\Models\User'
        ]);
        Bus::assertDispatched(SendUserToVtigerJob::class);
    }

    public function testChildrenIncludeInUser(): void
    {
        /** @var User $user */
        $user = User::factory()
            ->createOne([
                'phone' => '+79025689977',
                'otherphone' => '+79086675566'
            ]);
        /** @var Child $child */
        $child = Child::factory()->createOne([
            'phone' => '+79025689988',
            'otherphone' => '+79086675599'
        ]);
        $user->children()->attach($child->id);
        $response = $this->getJson(route('api.users.show', [
            'user' => $user->id,
            'include' => 'children'
        ]));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data')
            ->where('data.type', 'users')
            ->where('data.id', (string) $user->id)
            ->has('included')
            ->where('included.0.type', 'children')
            ->where('included.0.id', (string) $child->id)
            ->etc());
    }

    public function testGettingRelatedChildFromUser(): void
    {
        /** @var Child $child */
        $child = Child::factory()->createOne([
            'phone' => '+79876689875',
            'otherphone' => '+79026645879'
        ]);
        /** @var User $user */
        $user = User::factory()
            ->createOne([
                'phone' => '+79025689977',
                'otherphone' => '+79086675566'
            ]);
        $child->users()->attach($user->id);
        $response = $this->getJson(route('api.users.relations', [
            'id' => $user->id,
            'relation' => 'children'
        ]));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 1, fn(AssertableJson $json) =>
            $json
                ->where('type', 'children')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.firstname',
                    'attributes.lastname',
                    'attributes.middle_name',
                    'attributes.phone'
                ])->etc())->etc());
    }
}
