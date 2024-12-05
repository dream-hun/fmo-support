<?php

namespace App\Filament\Resources\MusaResource\Pages;

use App\Filament\Resources\MusaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMusa extends CreateRecord
{
    protected static string $resource = MusaResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
