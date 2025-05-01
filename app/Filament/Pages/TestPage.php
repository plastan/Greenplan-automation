<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use App\Models\Customers;
use Filament\Forms\Concerns\InteractsWithForms;

class TestPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static string $view = 'filament.pages.test-page';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $navigationLabel = 'Activity Calendar';

    protected static ?string $title = 'Activity Calendar';

    protected static ?int $navigationSort = 3;

    use InteractsWithForms;
    public function getActivityData()
    {
        // In a real application, you would fetch real data from your database
        // This is just example data for demonstration purposes
        return $this->generateSampleActivityData();
    }

    /**
     * Generate sample activity data for demonstration purposes
     * @return array
     */

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


    private function generateSampleActivityData(): array
    {
        $data = [];
        $startDate = Carbon::parse('2025-01-01');
        $endDate = Carbon::parse('2025-12-31');

        // Example of providing some seed data
        $seedDates = [
            '2025-01-03',
            '2025-01-15',
            '2025-02-10',
            '2025-03-22',
            '2025-06-18',
            '2025-09-01',
            '2025-12-25'
        ];

        foreach ($seedDates as $date) {
            $data[] = [
                'date' => $date,
                'value' => rand(5, 50)
            ];
        }

        // Generate some random activity data
        for ($date = clone $startDate; $date->lte($endDate); $date->addDay()) {
            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            // Only add data for some days (30% chance)
            if (rand(1, 100) <= 30) {
                // Check if this date already exists in seed data
                $dateStr = $date->format('Y-m-d');
                $exists = false;

                foreach ($data as $item) {
                    if ($item['date'] === $dateStr) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    $value = rand(1, 50);

                    $data[] = [
                        'date' => $dateStr,
                        'value' => $value
                    ];
                }
            }
        }

        return $data;
    }
    function update()
    {
        $this->generateSampleActivityData();
        $this->dispatch('heatmapDataUpdated', data: $this->heatmapData);
    }

    protected function getHeaderActions(): array
    {
        return [
            // You can add any header actions here if needed
        ];
    }
}
