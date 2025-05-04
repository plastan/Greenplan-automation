<?php

namespace App\Filament\Resources\CustomerMealAssignmentsResource\Pages;

use App\Exports\DailyMealAssignmentExport;
use App\Filament\Resources\CustomerMealAssignmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;


class ListCustomerMealAssignments extends ListRecords
{
    protected static string $resource = CustomerMealAssignmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\Action::make('Download chart')
                ->action(

                    function () {
                        $sheets = new DailyMealAssignmentExport();
                        if ($sheets->sheets() == []) { return; }
                        else {
                            return Excel::download($sheets, 'daily_meal_assignments' . now()->format('YmdHis') . '.xlsx');
                        }

                    }
                )
        ];
    }
}
