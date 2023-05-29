<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\StudentResource;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;
}
