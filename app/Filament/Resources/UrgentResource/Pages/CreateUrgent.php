<?php

namespace App\Filament\Resources\UrgentResource\Pages;

use App\Filament\Resources\UrgentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUrgent extends CreateRecord
{
    protected static string $resource = UrgentResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
