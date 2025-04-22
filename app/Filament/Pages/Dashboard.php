<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use Filament\Actions\Action;


class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';



    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
