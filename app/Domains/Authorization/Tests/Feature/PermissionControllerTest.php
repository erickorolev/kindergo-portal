<?php

namespace Domains\Authorization\Tests\Feature;

use Domains\Authorization\Seeders\PermissionsSeeder;
use Domains\Users\Models\User;
use Spatie\Permission\Models\Permission;
use Parents\Tests\PhpUnit\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionControllerTest extends TestCase
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
    public function it_displays_index_view_with_permissions(): void
    {
        $response = $this->get(route('admin.permissions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.permissions.index')
            ->assertViewHas('permissions');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_create_view_for_permission(): void
    {
        $response = $this->get(route('admin.permissions.create'));

        $response->assertOk()->assertViewIs('app.permissions.create');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_stores_the_permission(): void
    {
        $response = $this->post(route('admin.permissions.store'), [
            'name' => 'list secretaries',
            'roles' => []
        ]);

        $this->assertDatabaseHas('permissions', ['name' => 'list secretaries']);

        $permission = Permission::latest('id')->first();

        $response->assertRedirect(route('admin.permissions.edit', $permission));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_show_view_for_permission(): void
    {
        /** @var \Domains\Authorization\Models\Permission $permission */
        $permission = Permission::first();

        $response = $this->get(route('admin.permissions.show', $permission));

        $response
            ->assertOk()
            ->assertViewIs('app.permissions.show')
            ->assertViewHas('permission');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_displays_edit_view_for_permission(): void
    {
        /** @var PermissionsSeeder $permission */
        $permission = Permission::first();

        $response = $this->get(route('admin.permissions.edit', $permission));

        $response
            ->assertOk()
            ->assertViewIs('app.permissions.edit')
            ->assertViewHas('permission');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_updates_the_permission(): void
    {
        /** @var \Domains\Authorization\Models\Permission $permission */
        $permission = Permission::first();

        $data = [
            'name' => 'list managers',
            'roles' => [],
        ];

        $response = $this->put(route('admin.permissions.update', $permission), $data);

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'list managers'
        ]);

        $response->assertRedirect(route('admin.permissions.edit', $permission));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_deletes_the_permission(): void
    {
        /** @var Permission $permission */
        $permission = Permission::first();

        $response = $this->delete(route('admin.permissions.destroy', $permission));

        $response->assertRedirect(route('admin.permissions.index'));

        $this->assertDeleted($permission);
    }
}
