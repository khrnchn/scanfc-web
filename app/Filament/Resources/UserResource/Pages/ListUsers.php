<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;

class ListUsers extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = UserResource::class;
}
