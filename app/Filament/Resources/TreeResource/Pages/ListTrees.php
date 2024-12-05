<?php

namespace App\Filament\Resources\TreeResource\Pages;

use App\Filament\Resources\TreeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrees extends ListRecords
{
    protected static string $resource = TreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
