<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Course;
use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use Filament\Support\Colors\Color;
class SystemStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            // Users
            Stat::make('Total Users', User::count())
            ->description('Total Users')
            ->descriptionIcon('heroicon-o-user')
            ->descriptionColor(Color::Amber)
            ->url(route('filament.admin.resources.users.index'))
            ->chart(
                [
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                ]
            )->chartColor(Color::Amber)
            
            ,
            

            // Courses
            Stat::make('Total Courses', Course::count())
            ->description('Total Courses')
            ->descriptionIcon('heroicon-o-book-open')
            ->descriptionColor(Color::Blue)
            ->url(route('filament.admin.resources.courses.index'))
            ->chart(
                [
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                ]
            )->chartColor(Color::Blue),

            // Levels
            Stat::make('Total Levels', Level::count())
            ->description('Total Levels')
            ->descriptionIcon('heroicon-o-bars-3-bottom-left')
            ->descriptionColor(Color::Green)
            ->url(route('filament.admin.resources.levels.index'))
            ->chart(
                [
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                    random_int(1, 10),
                ]
            )->chartColor(Color::Green),

            // Units
            Stat::make('Total Units',           Unit::count())
            ->description('Total Units')
            ->descriptionIcon('heroicon-o-academic-cap')
            ->descriptionColor(Color::Purple) // Changed color to Purple
            ->url(route('filament.admin.resources.units.index'))
            ->chart(
                [
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                ]
            ) ->chartColor(Color::Purple),

            // Lessons
            Stat::make('Total Lessons', Lesson::count())
            ->description('Total Lessons')
            ->descriptionIcon('heroicon-o-book-open')
            ->descriptionColor(Color::Orange) // Changed color to Orange
            ->url(route('filament.admin.resources.lessons.index'))
            ->chart(
                [
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                random_int(1, 10),
                ]
            )
            ->chartColor(Color::Orange),
        ];
    }
}
