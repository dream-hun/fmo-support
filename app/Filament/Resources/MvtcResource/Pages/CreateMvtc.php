<?php

namespace App\Filament\Resources\MvtcResource\Pages;

use App\Filament\Resources\MvtcResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMvtc extends CreateRecord
{
    protected static string $resource = MvtcResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
