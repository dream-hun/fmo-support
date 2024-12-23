<?php

namespace App\Filament\Resources\CreditTopUpResource\Pages;

use App\Filament\Resources\CreditTopUpResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCreditTopUp extends EditRecord
{
    protected static string $resource = CreditTopUpResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
