<?php

namespace Domains\Users\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Users\Enums\AttendantCategoryEnum;
use Domains\Users\Enums\AttendantStatusEnum;
use Domains\Users\Jobs\SendUserToVtigerJob;
use Domains\Users\Models\User;
use Illuminate\Support\Facades\Bus;
use Parents\Enums\GenderEnum;
use Parents\Tests\PhpUnit\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
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
    public function it_displays_index_view_with_users(): void
    {
        /** @var User[] $users */
        $users = User::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('admin.users.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.users.index')
            ->assertViewHas('users');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_user(): void
    {
        $response = $this->get(route('admin.users.create'));

        $response->assertOk()->assertViewIs('app.users.create');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_stores_the_user(): void
    {
        Bus::fake();

        $data = User::factory()
            ->make()
            ->toArray();
        $data['phone'] = '+79876757777';
        $data['otherphone'] = '+79022884433';
        $data['password'] = \Str::random(8);
        $data['birthday'] = '1986-08-06';
        $data['attendant_hired'] = '2021-08-07';

        try {
            $response = $this->post(route('admin.users.store'), $data);

            $user = User::latest('id')->first();

            $response->assertRedirect(route('admin.users.edit', $user));
        } catch (\Illuminate\Validation\ValidationException $exception) {
            dump($exception->errors());
            $this->assertTrue(false, $exception->getMessage());
        }

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['current_team_id']);
        unset($data['imagename']);
        unset($data['name']);

        $this->assertDatabaseHas('users', $data);
        Bus::assertDispatched(SendUserToVtigerJob::class);
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.show', $user));

        $response
            ->assertOk()
            ->assertViewIs('app.users.show')
            ->assertViewHas('user');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->get(route('admin.users.edit', $user));

        $response
            ->assertOk()
            ->assertViewIs('app.users.edit')
            ->assertViewHas('user');
    }

    /**
     * @test
     * @psalm-suppress InvalidArrayOffset
     */
    public function it_updates_the_user(): void
    {
        Bus::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'middle_name' => $this->faker->lastName(),
            'phone' => '+79087568899',
            'gender' => GenderEnum::getRandomValue(),
            'attendant_category' => AttendantCategoryEnum::getRandomValue(),
            'attendant_status' => AttendantStatusEnum::getRandomValue(),
            'resume' => $this->faker->text(),
            'payment_data' => $this->faker->text(),
            'otherphone' => '+79024456879',
            'assigned_user_id' => '19x1'
        ];

        $data['password'] = \Str::random(8);

        $response = $this->put(route('admin.users.update', $user), $data);

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['current_team_id']);
        unset($data['imagename']);
        unset($data['name']);

        $data['id'] = $user->id;

        $this->assertDatabaseHas('users', $data);

        $response->assertRedirect(route('admin.users.edit', $user));

        Bus::assertDispatched(SendUserToVtigerJob::class);
    }

    /**
     * @test
     * @psalm-suppress ImplicitToStringCast
     */
    public function it_deletes_the_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));

        $this->assertSoftDeleted($user);
    }
}
