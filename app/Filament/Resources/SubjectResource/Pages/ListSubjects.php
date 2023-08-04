<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SubjectResource;

class ListSubjects extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SubjectResource::class;
}
