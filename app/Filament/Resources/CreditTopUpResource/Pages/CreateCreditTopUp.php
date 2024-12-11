<?php

namespace App\Filament\Resources\CreditTopUpResource\Pages;

use App\Filament\Resources\CreditTopUpResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCreditTopUp extends CreateRecord
{
    protected static string $resource = CreditTopUpResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['amount'] = $data['amount'] ?? 0; // Default to 0 if not set

        return $data;
    }
}
