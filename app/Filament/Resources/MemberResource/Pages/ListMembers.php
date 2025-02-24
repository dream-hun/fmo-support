<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected static ?string $title = 'All Vslas Members';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Add New Member'),
            ExcelImportAction::make()
                ->label('Import Data')
                ->color('info')->icon('heroicon-o-arrow-down-on-square-stack'),
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel().'-'.date('Y-m-d'))
                        ->withWriterType(Excel::CSV)
                        ->withColumns([
                            Column::make('updated_at'),
                        ]),
                ])->color('success')
                ->label('Export Data')->icon('heroicon-o-arrow-up-on-square-stack'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return MemberResource::getWidgets();
    }
}
