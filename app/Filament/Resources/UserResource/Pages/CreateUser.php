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
        $user->assignRole('lecturer');
        $permissions = $user->getPermissionsViaRoles();
        $user->givePermissionTo($permissions);

        $lastLecturer = Lecturer::orderBy('id', 'desc')->first();

        if ($lastLecturer) {
            $lastStaffId = $lastLecturer->staff_id;
            $staffNumber = intval(substr($lastStaffId, 5)); // Extract the number from the last staff_id
            $staffNumber++; // Increment the number
            $staffId = 'STAFF' . str_pad($staffNumber, 3, '0', STR_PAD_LEFT); // Format the new staff_id
        }

        Lecturer::create([
            'user_id' => $user->id,
            'staff_id' => $staffId,
            'faculty_id' => $user->faculty_id,
        ]);

        return $user;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
