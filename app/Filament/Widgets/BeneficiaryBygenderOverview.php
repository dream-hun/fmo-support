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

class BeneficiaryBygenderOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $ecdBeneficiaries = Ecd::where('gender', 'F')->count();
        $treeBeneficiaries = Tree::where('gender', 'F')->count();
        $zamukaBeneficiaries = Zamuka::count();
        $scholarshipBeneficiaries = Scholarship::where('gender', 'F')->count();
        $malnutritionBeneficiaries = Malnutrition::where('gender', 'F')->count();
        $urgentBeneficiaries = Urgent::count();
        $microcreditBeneficiaries = Member::where('gender', 'F')->count();
        $mvtcBeneficiaries = Mvtc::where('gender', 'F')->count();
        $musaBeneficiaries = Musa::count();
        $schoolFeedingBeneficiaries = SchoolFeeding::where('gender', 'F')->count();
        $toolKitBeneficiaries = Toolkit::where('gender', 'F')->count();
        $totalFemaleBeneficiaries = $ecdBeneficiaries + $treeBeneficiaries + $zamukaBeneficiaries + $scholarshipBeneficiaries + $malnutritionBeneficiaries + $urgentBeneficiaries + $microcreditBeneficiaries + $mvtcBeneficiaries + $musaBeneficiaries + $schoolFeedingBeneficiaries + $toolKitBeneficiaries;
        $totalMaleBeneficiaries = $ecdBeneficiaries + $treeBeneficiaries + $zamukaBeneficiaries + $scholarshipBeneficiaries + $malnutritionBeneficiaries + $urgentBeneficiaries + $microcreditBeneficiaries + $mvtcBeneficiaries + $musaBeneficiaries + $schoolFeedingBeneficiaries + $toolKitBeneficiaries;
        return [
            Stat::make('Female Beneficiaries', $totalFemaleBeneficiaries),
            Stat::make('Male Beneficiaries', $totalMaleBeneficiaries),
        ];
    }
}
