<?php

namespace App\Filament\Resources\TestResource\Widgets;

use App\Models\Test;
use App\Models\Question;
use App\Models\Choice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tests', Test::count()),
            Stat::make('Total Questions', Question::count()),
            Stat::make('Total Choices', Choice::count()),
        ];
    }
}
