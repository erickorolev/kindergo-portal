<?php

declare(strict_types=1);

namespace Domains\Children\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Http\Controllers\Api\ChildApiController;
use Domains\Children\Http\Requests\Admin\DeleteChildRequest;
use Domains\Children\Http\Requests\Admin\IndexChildRequest;
use Domains\Children\Http\Requests\Api\StoreChildApiRequest;
use Domains\Children\Http\Requests\Api\UpdateChildApiRequest;
use Domains\Children\Jobs\SendChildToVtigerJob;
use Domains\Children\Models\Child;
use Domains\Children\Repositories\ChildRepositoryInterface;
use Domains\Children\Repositories\Eloquent\ChildRepository;
use Domains\TemporaryFile\Actions\UploadFileAction;
use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Testing\Fluent\AssertableJson;
use JMac\Testing\Traits\AdditionalAssertions;
use Laravel\Sanctum\Sanctum;
use Parents\Tests\PhpUnit\TestCase;

class ChildrenApiTest extends TestCase
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
    public function it_gets_children_list(): void
    {
        Child::factory()
            ->count(5)
            ->create([
                'phone' => '+79025689977',
                'otherphone' => '+79086675566'
            ]);

        $response = $this->getJson(route('api.children.index'));

        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 5, fn(AssertableJson $json) =>
            $json
                ->where('type', 'children')
                ->hasAll([
                    'id',
                    'attributes',
                    'type',
                    'attributes.firstname',
                    'attributes.lastname',
                    'attributes.middle_name',
                    'attributes.phone',
                    'attributes.gender',
                    'attributes.gender.value',
                    'attributes.gender.description',
                    'attributes.otherphone',
                    'attributes.crmid',
                    'attributes.media',
                    'attributes.birthday'
                ])->etc())->etc());
    }

    /**
     * @test
     */
    public function it_uses_correct_repository(): void
    {
        $repModel = app(ChildRepositoryInterface::class);
        $this->assertInstanceOf(ChildRepository::class, $repModel);
    }

    /**
     * @test
     */
    public function it_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.children.index', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_uses_index_request(): void
    {
        $this->assertActionUsesFormRequest(
            ChildApiController::class,
            'index',
            IndexChildRequest::class
        );
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_child(): void
    {
        Bus::fake();

        $data = Child::factory()
            ->make()
            ->toArray();
        $data['phone'] = '+79876757777';
        $data['otherphone'] = '+79022884433';
        $data['birthday'] = '1995-08-06';

        try {
            $response = $this->postJson(route('api.children.store'), [
                'data' => [
                    'type' => 'children',
                    'attributes' => $data
                ]
            ]);
            unset($data['imagename']);

            $this->assertDatabaseHas('children', $data);

            $response->assertStatus(201)->assertJson([
                'data' => [
                    'attributes' => [
                        'firstname' => $data['firstname'],
                        'lastname' => $data['lastname'],
                        'crmid' => $data['crmid'],
                        'phone' => '8 (987) 675-77-77',
                        'otherphone' => '8 (902) 288-44-33',
                    ]
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            dump($ex->errors());
            $this->assertTrue(false, $ex->getMessage());
        }
        Bus::assertDispatched(SendChildToVtigerJob::class);
    }

    /**
     * @test
     */
    public function store_child_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            ChildApiController::class,
            'store',
            StoreChildApiRequest::class
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
    public function it_updates_the_child(): void
    {
        Bus::fake();

        /** @var Child $user */
        $user = Child::factory()->create();

        $data = [
            'data' => [
                'type' => 'children',
                'id' => (string) $user->id,
                'attributes' => [
                    'firstname' => $this->faker->firstName(),
                    'lastname' => $this->faker->lastName(),
                    'middle_name' => $this->faker->text(10),
                    'phone' => '+79876757777',
                    'gender' => 'Male',
                    'otherphone' => '+79086665478',
                    'birthday' => '1998-05-08',
                    'assigned_user_id' => '19x1'
                ]
            ]
        ];

        $response = $this->putJson(route('api.children.update', ['child' => $user->id]), $data);

        $this->assertDatabaseHas('children', [
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
        Bus::assertDispatched(SendChildToVtigerJob::class);
    }

    /**
     * @test
     */
    public function update_uses_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            ChildApiController::class,
            'update',
            UpdateChildApiRequest::class
        );
    }

    /**
     * @test
     */
    public function update_controller_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.children.update', ['auth:sanctum']);
    }

    /**
     * @test
     */
    public function it_deletes_the_user(): void
    {
        /** @var Child $user */
        $user = Child::factory()->create();

        $response = $this->deleteJson(route('api.children.destroy', $user));

        $this->assertSoftDeleted($user);

        $response->assertNoContent();
    }

    /**
     * @test
     */
    public function delete_uses_create_request(): void
    {
        $this->assertActionUsesFormRequest(
            ChildApiController::class,
            'destroy',
            DeleteChildRequest::class
        );
    }

    /**
     * @test
     */
    public function delete_controller_uses_middleware(): void
    {
        $this->assertRouteUsesMiddleware('api.children.destroy', ['auth:sanctum']);
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function testImagesAdding(): void
    {
        Bus::fake();
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');
        $result = UploadFileAction::run($file);
        $this->assertFileExists(storage_path('app/public/uploads/tmp/' . $result . '/test.pdf'));
        /** @var Child $user */
        $user = Child::factory()->makeOne([
            'phone' => '+79086447896',
            'otherphone' => '+79996457899'
        ]);
        $userData = $user->toArray();
        $userData['file'] = $result;
        $userData['birthday'] = '2000-05-06';
        try {
            $response = $this->postJson(route('api.children.store'), [
                'data' => [
                    'type' => 'children',
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


        $this->assertDatabaseHas('children', [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname
        ]);
        $this->assertDatabaseHas('media', [
            'collection_name' => 'avatar',
            'model_type' => 'Domains\Children\Models\Child'
        ]);
    }

    public function testGettingUsersInclude(): void
    {
        /** @var Child $child */
        $child = Child::factory()->createOne([
            'phone' => '+79876689875',
            'otherphone' => '+79026645879'
        ]);
        $child->users()->attach(User::first()?->id);
        $response = $this->getJson(route('api.children.show', [
            'child' => $child->id,
            'include' => 'users'
        ]));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data')
            ->where('data.type', 'children')
            ->where('data.id', (string) $child->id)
            ->has('included')
            ->where('included.0.type', 'users')
            ->where('included.0.id', (string) User::first()?->id)
            ->etc());
    }

    public function testGettingRelatedUsersFromChild(): void
    {
        /** @var Child $child */
        $child = Child::factory()->createOne([
            'phone' => '+79876689875',
            'otherphone' => '+79026645879'
        ]);
        $child->users()->attach(User::first()?->id);
        $response = $this->getJson(route('api.children.relations', [
            'id' => $child->id,
            'relation' => 'users'
        ]));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json
            ->has('data', 1, fn(AssertableJson $json) =>
            $json
                ->where('type', 'users')
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
