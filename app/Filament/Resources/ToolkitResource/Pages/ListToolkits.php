<?php

namespace App\Filament\Resources\ToolkitResource\Pages;

use App\Filament\Resources\ToolkitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToolkits extends ListRecords
{
    protected static string $resource = ToolkitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

        ];
    }
}
