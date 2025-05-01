<?php

namespace App\Filament\Resources\CustomersResource\Pages;

use App\Filament\Resources\CustomersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

use App\Model;
use App\Models\MealPlan;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class EditCustomers extends EditRecord
{
    protected static string $resource = CustomersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('editMealPlan')
                ->label('Edit Meal Plan')
                ->modalHeading('Edit Meal Plan')
                ->mountUsing(function ($form, $record) {
                    // Pre-fill form with existing meal plan data if it exists
                    $mealPlan = $record->mealPlan;

                    if ($mealPlan) {
                        $form->fill([
                            'type' => $mealPlan->type,
                            'breakfast' => $mealPlan->breakfast,
                            'lunch' => $mealPlan->lunch,
                            'dinner' => $mealPlan->dinner,
                            'cycle_number' => $mealPlan->cycle_number,
                            'current_day' => $mealPlan->current_day,
                            'restrictions_note' => $mealPlan->restrictions_note,
                            'special_instruction' => $mealPlan->special_instruction,
                            'veg_day' => $mealPlan->veg_day,
                            'is_skiped' => $mealPlan->is_skiped,
                            'skips_used' => $mealPlan->skips_used,

                        ]);
                    }
                })
                ->form([
                    Forms\Components\Select::make('type')
                        ->options([
                            'muscle gain' => 'Muscle Gain',
                            'weight loss' => 'Weight Loss',
                            'diabetic' => 'Diabetic',
                        ])
                        ->required()
                        ->label('Meal Plan Type'),

                    Forms\Components\TextInput::make('breakfast')
                        ->label('Breakfast')
                        ->default(false),

                    Forms\Components\TextInput::make('lunch')
                        ->default(false),

                    Forms\Components\TextInput::make('dinner')
                        ->label('Dinner')
                        ->default(false),

                    Forms\Components\TextInput::make('cycle_number')
                        ->label('Cycle Number')
                        ->numeric()
                        ->default(1),

                    Forms\Components\TextInput::make('current_day')
                        ->label('Current Day')
                        ->numeric()
                        ->default(1),

                    Forms\Components\TextInput::make('restrictions_note')
                        ->label('Restrictions Note'),

                    Forms\Components\TextInput::make('special_instruction')
                        ->label('Special Instruction'),

                    Forms\Components\TextInput::make('veg_day')
                        ->label('Veg Day'),

                    Forms\Components\TextInput::make('is_skiped')
                        ->label('Is Skiped'),

                ])
                ->action(function (array $data, $record): void {
                    // Create or update the meal plan
                    $record->mealPlan()->updateOrCreate(
                        [], // No conditions needed for hasOne
                        $data
                    );

                    // Show a success notification

                    // Refresh the form to show updated data
                    $this->refreshFormData(['mealPlan']);
                }),

        ];
    }
}
