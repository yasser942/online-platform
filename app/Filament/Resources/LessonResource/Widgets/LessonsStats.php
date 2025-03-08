<?php

namespace App\Filament\Resources\LessonResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Lesson;
class LessonsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Lessons', Lesson::count())
            ->description('Total Lessons')
            ->descriptionIcon('heroicon-o-book-open')
            ->descriptionColor('success'),
        ];
    }
}
