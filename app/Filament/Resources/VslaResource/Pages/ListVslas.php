<?php

namespace App\Filament\Resources\VslaResource\Pages;

use App\Filament\Resources\VslaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVslas extends ListRecords
{
    protected static string $resource = VslaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
