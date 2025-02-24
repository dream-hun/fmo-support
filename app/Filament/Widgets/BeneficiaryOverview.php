<?php

namespace App\Filament\Widgets;

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
        $ecdBeneficiaries = Ecd::count();
        $treeBeneficiaries = Tree::count();
        $zamukaBeneficiaries = Zamuka::count();
        $scholarshipBeneficiaries = Scholarship::count();
        $malnutritionBeneficiaries = Malnutrition::count();
        $urgentBeneficiaries = Urgent::count();
        $microcreditBeneficiaries = Member::count();
        $mvtcBeneficiaries = Mvtc::count();
        $musaBeneficiaries = Musa::count();
        $schoolFeedingBeneficiaries = SchoolFeeding::count();
        $toolKitBeneficiaries = Toolkit::count();
        $totalBeneficiaries = $ecdBeneficiaries + $treeBeneficiaries + $zamukaBeneficiaries + $scholarshipBeneficiaries + $malnutritionBeneficiaries + $urgentBeneficiaries + $microcreditBeneficiaries + $mvtcBeneficiaries + $musaBeneficiaries + $schoolFeedingBeneficiaries + $toolKitBeneficiaries;
        return [
            Stat::make('Total Beneficiaries', $totalBeneficiaries),
        ];
    }
}
