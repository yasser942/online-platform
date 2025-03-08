<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CoursesStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::count())
            ->description('Total Courses')
            ->descriptionIcon('heroicon-o-book-open')
            ->descriptionColor('success'),
        ];
    }
}
