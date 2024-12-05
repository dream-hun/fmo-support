<?php

namespace App\Filament\Resources\MvtcResource\Pages;

use App\Filament\Resources\MvtcResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMvtcs extends ListRecords
{
    protected static string $resource = MvtcResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
