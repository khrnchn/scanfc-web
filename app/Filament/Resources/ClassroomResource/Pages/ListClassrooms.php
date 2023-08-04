<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\ClassroomResource;

class ListClassrooms extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = ClassroomResource::class;
}
