<?php

namespace App\Filament\Resources\FacultyResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\FacultyResource;

class ListFaculties extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = FacultyResource::class;
}
