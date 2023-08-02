<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignStudentRole extends Command
{
    protected $signature = 'role:assign-student';

    protected $description = 'Assign the "student" role to all users who have a relationship with the Student model';

    public function handle()
    {
        // Find the "student" role
        $studentRole = Role::where('name', 'student')->first();

        if (!$studentRole) {
            $this->error('Role "student" not found.');
            return;
        }

        // Get all users who have a relationship with the Student model
        $users = User::whereHas('student')->get();

        foreach ($users as $user) {
            $user->assignRole($studentRole); // Now, you can use assignRole() method on the User model
        }

        $this->info('Role "student" assigned to all users with a relationship to the Student model.');
    }
}
