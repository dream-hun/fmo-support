<?php

namespace App\Filament\Resources\MalnutritionResource\Pages;

use App\Filament\Resources\MalnutritionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMalnutritions extends ListRecords
{
    protected static string $resource = MalnutritionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
