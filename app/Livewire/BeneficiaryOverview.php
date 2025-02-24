<?php

namespace App\Livewire;

use App\Models\Ecd;
use App\Models\Malnutrition;
use App\Models\Member;
use App\Models\Musa;
use App\Models\Mvtc;
use App\Models\Scholarship;
use App\Models\SchoolFeeding;
use App\Models\Toolkit;
use App\Models\Tree;
use App\Models\Urgent;
use App\Models\Zamuka;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BeneficiaryOverview extends BaseWidget
{
    protected function getStats(): array
    {
        

        return [
            Stat::make('Total Beneficiaries', $totalBeneficiaries),
        ];
    }
}
