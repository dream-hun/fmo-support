<?php

namespace App\Filament\Resources\MusaResource\Pages;

use App\Filament\Resources\MusaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMusas extends ListRecords
{
    protected static string $resource = MusaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
