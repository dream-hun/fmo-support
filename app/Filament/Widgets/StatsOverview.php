<?php

namespace App\Filament\Widgets;

use App\Models\Ecd;
use App\Models\Member;
use App\Models\Vsla;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('', Ecd::count())->description('Total ECD Beneficiaries'),
            Stat::make('', Member::count())->description('Total Micro Credit Beneficiaries'),
            Stat::make('', Vsla::count())->description('Total Vslas'),

        ];
    }
}
