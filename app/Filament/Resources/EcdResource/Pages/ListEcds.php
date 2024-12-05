<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEcds extends ListRecords
{
    protected static string $resource = EcdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Add New Beneficiary')->icon('heroicon-s-plus-circle'),
        ];
    }
}
