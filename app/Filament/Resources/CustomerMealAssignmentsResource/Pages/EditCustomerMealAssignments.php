<?php

namespace App\Filament\Resources\CustomerMealAssignmentsResource\Pages;

use App\Filament\Resources\CustomerMealAssignmentsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerMealAssignments extends EditRecord
{
    protected static string $resource = CustomerMealAssignmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
