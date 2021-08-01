<?php

declare(strict_types=1);

namespace Domains\Authorization\Seeders;

use Domains\Users\Actions\GetUserByEmailAction;
use Domains\Users\Models\User;
use Domains\Authorization\Models\Role;
use Domains\Authorization\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

final class PermissionsSeeder extends \Parents\Seeders\Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list children']);
        Permission::create(['name' => 'view children']);
        Permission::create(['name' => 'create children']);
        Permission::create(['name' => 'update children']);
        Permission::create(['name' => 'delete children']);

        Permission::create(['name' => 'list attendants']);
        Permission::create(['name' => 'view attendants']);
        Permission::create(['name' => 'create attendants']);
        Permission::create(['name' => 'update attendants']);
        Permission::create(['name' => 'delete attendants']);

        Permission::create(['name' => 'list timetables']);
        Permission::create(['name' => 'view timetables']);
        Permission::create(['name' => 'create timetables']);
        Permission::create(['name' => 'update timetables']);
        Permission::create(['name' => 'delete timetables']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'view payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list trips']);
        Permission::create(['name' => 'view trips']);
        Permission::create(['name' => 'create trips']);
        Permission::create(['name' => 'update trips']);
        Permission::create(['name' => 'delete trips']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);
        $clientRole = Role::create(['name' => 'client']);
        $clientRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);
        /** @var ?User $user */
        $user = GetUserByEmailAction::run('admin@admin.com');

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
