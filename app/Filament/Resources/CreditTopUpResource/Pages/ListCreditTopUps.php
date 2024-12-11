<?php

namespace App\Filament\Resources\CreditTopUpResource\Pages;

use App\Filament\Resources\CreditTopUpResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCreditTopUps extends ListRecords
{
    protected static string $resource = CreditTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
