<?php

namespace App\Filament\Resources\SectionResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\SectionResource;

class ListSections extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = SectionResource::class;
}
