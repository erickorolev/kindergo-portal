<?php

namespace Domains\Authorization\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Users\Models\User;
use Domains\Authorization\Models\Role;
use Parents\Tests\PhpUnit\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create(['email' => 'admin@admin.com']);
        $this->actingAs($user);

        $this->seed(PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_index_view_with_roles(): void
    {
        $response = $this->get(route('admin.roles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.index')
            ->assertViewHas('roles');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_create_view_for_role(): void
    {
        $response = $this->get(route('admin.roles.create'));

        $response->assertOk()->assertViewIs('app.roles.create');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_stores_the_role(): void
    {
        $response = $this->post(route('admin.roles.store'), [
            'name' => 'secretary',
            'permissions' => []
        ]);

        $this->assertDatabaseHas('roles', ['name' => 'secretary']);
        /** @var Role $role */
        $role = Role::latest('id')->first();

        $response->assertRedirect(route('admin.roles.edit', $role));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_show_view_for_role(): void
    {
        /** @var Role $role */
        $role = Role::first();

        $response = $this->get(route('admin.roles.show', $role));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.show')
            ->assertViewHas('role');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_edit_view_for_role(): void
    {
        /** @var Role $role */
        $role = Role::first();

        $response = $this->get(route('admin.roles.edit', $role));

        $response
            ->assertOk()
            ->assertViewIs('app.roles.edit')
            ->assertViewHas('role');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_updates_the_role(): void
    {
        /** @var Role $role */
        $role = Role::first();

        $data = [
            'name' => 'manager',
            'permissions' => [],
        ];

        $response = $this->put(route('admin.roles.update', $role), $data);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'manager'
        ]);

        $response->assertRedirect(route('admin.roles.edit', $role));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_deletes_the_role(): void
    {
        /** @var Role $role */
        $role = Role::first();

        $response = $this->delete(route('admin.roles.destroy', $role));

        $response->assertRedirect(route('admin.roles.index'));

        $this->assertDeleted($role);
    }
}
