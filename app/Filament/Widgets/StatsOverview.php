<?php

namespace App\Filament\Widgets;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Subject;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total students', Student::count())
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total lecturers', Lecturer::count())
                ->description('1% decrease')
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('danger'),
            Card::make('Total subjects', Subject::count())
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
