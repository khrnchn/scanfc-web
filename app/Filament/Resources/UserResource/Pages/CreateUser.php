<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Lecturer;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): User
    {
        $user = User::create($data);
        $user->assignRole('teacher');
        $permissions = $user->getPermissionsViaRoles();
        $user->givePermissionTo($permissions);

        // handle lecturer or student

        return $user;
    }
}
