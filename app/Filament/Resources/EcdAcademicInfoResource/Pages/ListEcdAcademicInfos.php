<?php

namespace App\Filament\Resources\EcdAcademicInfoResource\Pages;

use App\Filament\Resources\EcdAcademicInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEcdAcademicInfos extends ListRecords
{
    protected static string $resource = EcdAcademicInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
