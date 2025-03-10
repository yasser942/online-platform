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

            Stat::make(__('dashboard.dashboard.total-users'), User::count())
            ->description(__('dashboard.dashboard.total-users'))
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
            Stat::make(__('dashboard.dashboard.total-courses'), Course::count())
            ->description(__('dashboard.dashboard.total-courses'))
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
            Stat::make(__('dashboard.dashboard.total-levels'), Level::count())
            ->description(__('dashboard.dashboard.total-levels'))
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
            Stat::make(__('dashboard.dashboard.total-units'), Unit::count())
            ->description(__('dashboard.dashboard.total-units'))
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
            Stat::make(__('dashboard.dashboard.total-lessons'), Lesson::count())
            ->description(__('dashboard.dashboard.total-lessons'))
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
