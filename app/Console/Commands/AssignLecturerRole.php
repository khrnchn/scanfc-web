<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignLecturerRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign-lecturer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the "lecturer" role to all users who have a relationship with the Lecturer model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Find or create the "lecturer" role
        $lecturerRole = Role::firstOrCreate(['name' => 'lecturer']);

        // Find or create the permissions
        $permissions = [
            'view_faculty',
            'view_any_faculty',
            'view_subject',
            'view_any_subject',
            'view_section',
            'view_any_section',
            'view_classroom',
            'view_any_classroom',
        ];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $lecturerRole->givePermissionTo($permission);
        }

        // Get all users who have a relationship with the Lecturer model
        $users = User::whereHas('lecturer')->get();

        foreach ($users as $user) {
            // Assign the "lecturer" role to each user
            $user->assignRole($lecturerRole);

            // Get permissions via roles and assign them directly to the user
            $permissionsViaRoles = $user->getPermissionsViaRoles();
            $user->syncPermissions($permissionsViaRoles);
        }

        $this->info('Role "lecturer" assigned to all users with a relationship to the Lecturer model.');
    }
}
