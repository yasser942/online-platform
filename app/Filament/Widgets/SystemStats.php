<?php

namespace App\Filament\Widgets;

use App\Models\Unit;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SystemStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make('Total Users', User::count())
    ->description('Total Users')
    ->descriptionIcon('heroicon-o-user', IconPosition::Before)
    ->descriptionColor(Color::Amber)
    ->url(route('filament.admin.resources.users.index'))
    ->chart(
        User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count') // Get user count per day
            ->toArray()
    )
    ->chartColor(Color::Amber),
            

            // Courses
            Stat::make('Total Courses', Course::count())
            ->description('Total Courses')
            ->descriptionIcon('heroicon-o-book-open', IconPosition::Before)
            ->descriptionColor(Color::Blue)
            ->url(route('filament.admin.resources.courses.index'))
            ->chart(
                Course::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count') // Get user count per day
            ->toArray()
                )->chartColor(Color::Blue),

            // Levels
            Stat::make('Total Levels', Level::count())
            ->description('Total Levels')
            ->descriptionIcon('heroicon-o-bars-3-bottom-left', IconPosition::Before)
            ->descriptionColor(Color::Green)
            ->url(route('filament.admin.resources.levels.index'))
            ->chart(
                Level::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count') // Get user count per day
            ->toArray()
            )
            ->chartColor(Color::Green),

            // Units
            Stat::make('Total Units',           Unit::count())
            ->description('Total Units')
            ->descriptionIcon('heroicon-o-academic-cap', IconPosition::Before)
            ->descriptionColor(Color::Purple) // Changed color to Purple
            ->url(route('filament.admin.resources.units.index'))
            ->chart(
                Unit::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count') // Get user count per day
            ->toArray()
            )
            ->chartColor(Color::Purple),

            // Lessons
            Stat::make('Total Lessons', Lesson::count())
            ->description('Total Lessons')
            ->descriptionIcon('heroicon-o-book-open', IconPosition::Before)
            ->descriptionColor(Color::Orange) // Changed color to Orange
            ->url(route('filament.admin.resources.lessons.index'))
            ->chart(
                Lesson::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count') // Get user count per day
            ->toArray()
            )
            ->chartColor(Color::Orange),
        ];
    }
}
