<?php

namespace App\Filament\Resources\MenuItemsResource\Pages;

use App\Filament\Resources\MenuItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Imports\MenuItemImport;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('import')
            ->label('Import Excel')
            ->form([
                Forms\Components\FileUpload::make('excel_file')
                    ->label('Excel File')
                    ->disk('local') // or 'public'
                    ->directory('storage')
                    // ->acceptedFileTypes(['.xlsx', '.xls', '.csv'])
                    ->required(),
            ])
            ->action(function (array $data): void {
                $filePath = Storage::disk('local')->path($data['excel_file']);
                Excel::import(new MenuItemImport, $filePath);
                Notification::make()
                    ->title('Imported successfully!')
                    ->success()
                    ->send();
            })
            ->modalHeading('Import Menu Items from Excel'),
        ];
    }
}
