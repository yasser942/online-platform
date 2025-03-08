<?php

namespace App\Filament\Resources\UnitResource\Widgets;

use App\Models\Unit;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UnitsStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Units', Unit::count())
            ->description('Total Units')
            ->descriptionIcon('heroicon-o-academic-cap')
            ->descriptionColor('success')
            
            ,
        ];
    }
}
