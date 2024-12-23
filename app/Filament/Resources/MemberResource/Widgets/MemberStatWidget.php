<?php

namespace App\Filament\Resources\MemberResource\Widgets;

use App\Filament\Resources\MemberResource\Pages\ListMembers;
use App\Models\Member;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MemberStatWidget extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListMembers::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Female', Member::where('gender', '=', 'FEMALE')->count())
                ->description('Total Female Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Male', Member::where('gender', '=', 'MALE')->count())
                ->description('Total Male Beneficiaries')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),
        ];
    }
}
