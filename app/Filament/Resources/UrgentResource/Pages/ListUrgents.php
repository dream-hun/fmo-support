<?php

namespace App\Filament\Resources\UrgentResource\Pages;

use App\Filament\Resources\UrgentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUrgents extends ListRecords
{
    protected static string $resource = UrgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
