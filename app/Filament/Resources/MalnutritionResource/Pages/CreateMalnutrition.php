<?php

namespace App\Filament\Resources\MalnutritionResource\Pages;

use App\Filament\Resources\MalnutritionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMalnutrition extends CreateRecord
{
    protected static string $resource = MalnutritionResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
