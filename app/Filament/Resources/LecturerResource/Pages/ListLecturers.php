<?php

namespace App\Filament\Resources\LecturerResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\LecturerResource;

class ListLecturers extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = LecturerResource::class;
}
