<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignStudentRole extends Command
{
    protected $signature = 'role:assign-student';

    protected $description = 'Assign the "student" role to all users who have a relationship with the Student model';

    public function handle()
    {
        // Find or create the "student" role
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Find or create the permissions
        $permissions = [
            'create_attendance',
            'update_attendance',
            'view_classroom',
            'view_any_classroom'
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $studentRole->givePermissionTo($permission);
        }

        // Get all users who have a relationship with the Student model
        $users = User::whereHas('student')->get();

        foreach ($users as $user) {
            // Assign the "student" role to each user
            $user->assignRole($studentRole);

            // Get permissions via roles and assign them directly to the user
            $permissionsViaRoles = $user->getPermissionsViaRoles();
            $user->syncPermissions($permissionsViaRoles);
        }

        $this->info('Role "student" assigned to all users with a relationship to the Student model.');
    }
}
