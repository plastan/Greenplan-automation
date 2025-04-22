<?php

namespace App\Filament\Resources\MenuItemsResource\Pages;

use App\Filament\Resources\MenuItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
