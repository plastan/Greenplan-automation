<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerMealAssignmentsResource\Pages;
use App\Filament\Resources\CustomerMealAssignmentsResource\RelationManagers;
use App\Models\CustomerMealAssignments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use App\Exports\DailyMealAssignmentExport;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerMealAssignmentsResource extends Resource
{
    protected static ?string $model = CustomerMealAssignments::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('menu_item_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('delivery_status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('meal_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('customer.name')->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('menuItem.category'),
                Tables\Columns\TextColumn::make('menu_item_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerMealAssignments::route('/'),
            'create' => Pages\CreateCustomerMealAssignments::route('/create'),
            'edit' => Pages\EditCustomerMealAssignments::route('/{record}/edit'),
        ];
    }
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole("admin") || auth()->user()->hasRole("superadmin");
    }
}
