<?php

namespace App\Filament\Resources\CreditTopUpResource\Pages;

use App\Filament\Resources\CreditTopUpResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCreditTopUp extends ViewRecord
{
    protected static string $resource = CreditTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
