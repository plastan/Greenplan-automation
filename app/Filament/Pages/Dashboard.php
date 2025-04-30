<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\HeatmapWidget;
use Filament\Pages\Page;

use Filament\Actions\Action;


class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';



    public function mount(): void {}
    protected function getActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
    public static function getWidgets(): array
    {
        return [];
    }
    protected function getFooterWidgets(): array
    {
        return [];
    }
}
