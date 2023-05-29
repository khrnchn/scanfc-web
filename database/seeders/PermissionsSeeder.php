<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list attendances']);
        Permission::create(['name' => 'view attendances']);
        Permission::create(['name' => 'create attendances']);
        Permission::create(['name' => 'update attendances']);
        Permission::create(['name' => 'delete attendances']);

        Permission::create(['name' => 'list classrooms']);
        Permission::create(['name' => 'view classrooms']);
        Permission::create(['name' => 'create classrooms']);
        Permission::create(['name' => 'update classrooms']);
        Permission::create(['name' => 'delete classrooms']);

        Permission::create(['name' => 'list faculties']);
        Permission::create(['name' => 'view faculties']);
        Permission::create(['name' => 'create faculties']);
        Permission::create(['name' => 'update faculties']);
        Permission::create(['name' => 'delete faculties']);

        Permission::create(['name' => 'list lecturers']);
        Permission::create(['name' => 'view lecturers']);
        Permission::create(['name' => 'create lecturers']);
        Permission::create(['name' => 'update lecturers']);
        Permission::create(['name' => 'delete lecturers']);

        Permission::create(['name' => 'list sections']);
        Permission::create(['name' => 'view sections']);
        Permission::create(['name' => 'create sections']);
        Permission::create(['name' => 'update sections']);
        Permission::create(['name' => 'delete sections']);

        Permission::create(['name' => 'list students']);
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'create students']);
        Permission::create(['name' => 'update students']);
        Permission::create(['name' => 'delete students']);

        Permission::create(['name' => 'list subjects']);
        Permission::create(['name' => 'view subjects']);
        Permission::create(['name' => 'create subjects']);
        Permission::create(['name' => 'update subjects']);
        Permission::create(['name' => 'delete subjects']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

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

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
