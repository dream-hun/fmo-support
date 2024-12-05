<?php

namespace App\Filament\Resources\TreeResource\Pages;

use App\Filament\Resources\TreeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTree extends CreateRecord
{
    protected static string $resource = TreeResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
