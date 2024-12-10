<?php

namespace App\Filament\Resources\ZamukaResource\Pages;

use App\Filament\Resources\ZamukaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateZamuka extends CreateRecord
{
    protected static string $resource = ZamukaResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
