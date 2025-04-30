<?php

namespace App\Filament\Pages;

use App\Models\Customers;
use App\Services\CustomerService;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Interfaces\HasLabel;
use Illuminate\Support\Collection;
use Filament\Pages\Concerns\HasSearchableActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class HeatmapPage extends Page implements HasForms, HasActions
{



    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static string $view = 'filament.pages.heatmap-calendar-page';
    protected static ?string $navigationLabel = 'Data Heatmap';
    protected static ?string $title = 'Data Visualization Heatmap';
    protected static ?int $navigationSort = 3; // Adjust as needed
    public string $search = '';
}
