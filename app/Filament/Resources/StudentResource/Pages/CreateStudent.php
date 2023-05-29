<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentResource;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
