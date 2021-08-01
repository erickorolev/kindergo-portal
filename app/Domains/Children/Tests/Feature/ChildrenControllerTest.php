<?php

declare(strict_types=1);

namespace Domains\Children\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Children\Jobs\SendChildToVtigerJob;
use Domains\Children\Models\Child;
use Domains\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use JMac\Testing\Traits\AdditionalAssertions;
use Parents\Enums\GenderEnum;
use Parents\Tests\PhpUnit\TestCase;

class ChildrenControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use AdditionalAssertions;

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
    public function it_displays_index_view_with_children(): void
    {
        /** @var Child[] $children */
        $children = Child::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('admin.children.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.children.index')
            ->assertViewHas('children');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_child(): void
    {
        $response = $this->get(route('admin.children.create'));

        $response->assertOk()->assertViewIs('app.children.create');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_child(): void
    {
        Bus::fake();

        /** @var User $user */
        $user = User::factory()->createOne();
        $data = Child::factory()
            ->make()
            ->toArray();
        $data['phone'] = '+79876754455';
        $data['otherphone'] = '+79086645785';
        $data['birthday'] = '1999-05-06';
        $data['users'] = [$user->crmid];
        try {
            $response = $this->post(route('admin.children.store'), $data);
            unset($data['users']);

            $this->assertDatabaseHas('children', $data);
            /** @var Child $child */
            $child = Child::latest('id')->first();

            $response->assertRedirect(route('admin.children.edit', $child));
            $this->assertCount(1, $child->users);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            dump($ex->errors());
            $this->assertTrue(false, $ex->getMessage());
        }
        Bus::assertDispatched(SendChildToVtigerJob::class);
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_with_file(): void
    {
        $this->withoutExceptionHandling();

        config()->set('filesystems.disks.media', [
            'driver' => 'local',
            'root' => __DIR__ . '/../../temp', // choose any path...
        ]);

        config()->set('medialibrary.default_filesystem', 'media');

        $photo = UploadedFile::fake()->image('photo.jpg');

        $data = Child::factory()
            ->make()
            ->toArray();
        $data['phone'] = '+79876754455';
        $data['otherphone'] = '+79086645785';
        $data['birthday'] = '1999-05-06';
        $data['imagename'] = $photo;

        try {
            $response = $this->post(route('admin.children.store'), $data);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            dump($ex->errors());
            $this->assertTrue(false, $ex->getMessage());
        }

        $this->assertDatabaseHas('children', [
            'firstname' => $data['firstname']
        ]);
        /** @var Child $child */
        $child = Child::latest('id')->first();

        $photos = $child->getMedia('avatar');

        $this->assertCount(1, $photos);
        $this->assertFileExists($photos->first()?->getPath() ?? '');
        $this->assertFileExists($photos->first()?->getPath('thumb') ?? '');
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_child(): void
    {
        /** @var Child $child */
        $child = Child::factory()->create();

        $response = $this->get(route('admin.children.show', $child));

        $response
            ->assertOk()
            ->assertViewIs('app.children.show')
            ->assertViewHas('child');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_child(): void
    {
        /** @var Child $child */
        $child = Child::factory()->create();

        $response = $this->get(route('admin.children.edit', $child));

        $response
            ->assertOk()
            ->assertViewIs('app.children.edit')
            ->assertViewHas('child');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_updates_the_child(): void
    {
        Bus::fake();

        /** @var User $user */
        $user = User::factory()->createOne();
        /** @var Child $child */
        $child = Child::factory()->create();

        $data = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'middle_name' => $this->faker->text(15),
            'birthday' => '1999-05-06',
            'gender' => GenderEnum::getRandomValue(),
            'phone' => '+79876757777',
            'otherphone' => '+79876757799',
            'users' => [$user->id],
            'assigned_user_id' => '19x1'
        ];

        $response = $this->put(route('admin.children.update', ['child' => $child->id]), $data);

        $data['id'] = $child->id;
        $child->refresh();
        unset($data['users']);

        $this->assertDatabaseHas('children', $data);

        $response->assertRedirect(route('admin.children.edit', $child));
        $this->assertCount(1, $child->users);
        Bus::assertDispatched(SendChildToVtigerJob::class);
    }

    /**
     * @test
     */
    public function it_deletes_the_child(): void
    {
        /** @var Child $child */
        $child = Child::factory()->create();

        $response = $this->delete(route('admin.children.destroy', $child));

        $response->assertRedirect(route('admin.children.index'));

        $this->assertSoftDeleted($child);
    }
}
