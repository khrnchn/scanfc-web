<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;

class SubjectChart extends BarChartWidget
{
    protected static ?string $heading = 'Registered subjects';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Student attendance',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',   // Jan - Red
                        'rgba(54, 162, 235, 0.2)',   // Feb - Blue
                        'rgba(255, 205, 86, 0.2)',   // Mar - Yellow
                        'rgba(75, 192, 192, 0.2)',   // Apr - Teal
                        'rgba(153, 102, 255, 0.2)',  // May - Purple
                        'rgba(255, 159, 64, 0.2)',   // Jun - Orange
                        'rgba(0, 128, 0, 0.2)',       // Jul - Green
                        'rgba(255, 0, 0, 0.2)',       // Aug - Red
                        'rgba(0, 0, 255, 0.2)',       // Sep - Blue
                        'rgba(255, 255, 0, 0.2)',     // Oct - Yellow
                        'rgba(128, 128, 128, 0.2)',   // Nov - Gray
                        'rgba(210, 105, 30, 0.2)',    // Dec - Chocolate
                    ],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
