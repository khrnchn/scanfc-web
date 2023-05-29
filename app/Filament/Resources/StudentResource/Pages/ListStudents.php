<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\StudentResource;

class ListStudents extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = StudentResource::class;
}
