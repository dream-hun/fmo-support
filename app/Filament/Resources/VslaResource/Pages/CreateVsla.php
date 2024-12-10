<?php

namespace App\Filament\Resources\VslaResource\Pages;

use App\Filament\Resources\VslaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVsla extends CreateRecord
{
    protected static string $resource = VslaResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
