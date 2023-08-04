<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use Filament\Resources\Pages\ListRecords;
use App\Filament\Traits\HasDescendingOrder;
use App\Filament\Resources\AttendanceResource;

class ListAttendances extends ListRecords
{
    use HasDescendingOrder;

    protected static string $resource = AttendanceResource::class;
}
