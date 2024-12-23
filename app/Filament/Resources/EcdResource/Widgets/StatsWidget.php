<?php

namespace App\Filament\Resources\EcdResource\Widgets;

use App\Filament\Resources\EcdResource\Pages\ListEcds;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsWidget extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListEcds::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Female', \App\Models\Ecd::where('gender', '=', 'F')->count())
                ->description('Total Female Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Male', \App\Models\Ecd::where('gender', '=', 'M')->count())
                ->description('Total Male Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
        ];
    }
}
