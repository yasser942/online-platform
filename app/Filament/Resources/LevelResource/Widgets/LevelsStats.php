<?php

namespace App\Filament\Resources\LevelResource\Widgets;

use App\Models\Level;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class LevelsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Levels', Level::count())
            ->description('Total Levels')
            ->descriptionIcon('heroicon-o-bars-3-bottom-left')
            ->descriptionColor('success'),
        ];
    }
}
