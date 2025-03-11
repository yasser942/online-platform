<?php

namespace App\Filament\Resources\LessonResource\Widgets;

use App\Models\Pdf;
use App\Models\Video;
use App\Models\Lesson;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

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
