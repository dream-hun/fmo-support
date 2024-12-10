<?php

namespace App\Filament\Widgets;

use App\Models\Ecd;
use App\Models\Member;
use App\Models\Mvtc;
use App\Models\Vsla;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        return [
            Stat::make('ECD', Ecd::count())
                ->description('Total ECD Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Micro Credit', Member::count())
                ->description('Total Micro Credit Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            Stat::make('VSLAS', Vsla::count())->description('Total Vslas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('info'),
            Stat::make('MVTC', Mvtc::count())->description('Total Students')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),

            Stat::make('ECD', Ecd::where('gender', 'F')->count())
                ->description('Total Female Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make('ECD', Ecd::where('gender', 'M')->count())
                ->description('Total Male Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

        ];
    }
}
