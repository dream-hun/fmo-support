<?php

namespace App\Filament\Resources\ZamukaResource\Pages;

use App\Filament\Resources\ZamukaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListZamukas extends ListRecords
{
    protected static string $resource = ZamukaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
