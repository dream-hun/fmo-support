<?php

namespace App\Filament\Resources\MalnutritionResource\Widgets;

use App\Filament\Resources\MalnutritionResource\Pages\ListMalnutritions;
use App\Models\Malnutrition;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MalnutritionStatWidget extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListMalnutritions::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Female', Malnutrition::where('gender', '=', 'F')->count())
                ->description('Total Female Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Male', Malnutrition::where('gender', '=', 'M')->count())
                ->description('Total Male Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
        ];
    }
}
