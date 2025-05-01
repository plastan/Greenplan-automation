<?php

namespace App\Livewire;

use App\Services\CustomerService;

use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Livewire\Attributes\Reactive;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use App\Models\Customers;
use Filament\Forms\Concerns\InteractsWithForms;

class Heatmap extends Component implements HasForms
{
    use InteractsWithForms;
    public $heatmapData = [];


    public $data = [
        'id' => null,
    ];


    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Select::make('id')
                    ->label('customers')
                    ->options(Customers::all()->pluck('name', 'id'))
                    ->searchable()
                    ->afterStateUpdated(function ($state) {
                        if ($state) {
                            $this->loadHeatmapData($state);
                        }
                    })
            ])

            ->statePath('data');
    }


    public function loadHeatmapData($customerId)
    {
        if (!$customerId) {
            $this->heatmapData = [];
            return;
        }
        $this->heatmapData = app(CustomerService::class)->get_monthly_data($customerId);
    }

    public function create()
    {
        $this->loadHeatmapData($this->data['id']);
        $this->dispatch('heatmapDataUpdated', ['data' => $this->heatmapData]);
    }

    public function render()
    {
        return view('livewire.heatmap');
    }
}
