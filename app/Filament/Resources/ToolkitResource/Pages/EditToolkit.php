<?php

namespace App\Filament\Resources\ToolkitResource\Pages;

use App\Filament\Resources\ToolkitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToolkit extends EditRecord
{
    protected static string $resource = ToolkitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
