<?php

namespace App\Filament\Resources\EcdResource\Pages;

use App\Filament\Resources\EcdResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEcd extends ViewRecord
{
    protected static string $resource = EcdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
