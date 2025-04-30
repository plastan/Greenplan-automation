<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('breakfast')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('icepacks_returned')
                    ->required(),
                Forms\Components\Textarea::make('special_note')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_delivered')
                    ->required(),
                Forms\Components\DateTimePicker::make('delivery_time')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    //TODO:
    //default sort by undeliverd
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('meal_date'),
                Tables\Columns\TextColumn::make('id')
                    ->label('Delivery ID')
                    ->sortable(),

                Tables\Columns\IconColumn::make('icepacks_returned')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_delivered')
                    ->boolean(),
                Tables\Columns\TextColumn::make('delivery_time')
                    ->dateTime()
                    ->sortable(),
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
                // Tables\Actions\EditAction::make(),
                Action::make('Deliver')
                    ->label(fn($record) => $record->is_delivered ? 'Edit' : 'Deliver')
                    ->action(fn(Delivery $record) => $record->delete())
                    ->form([
                        Wizard::make([
                            Step::make('Delivery')->schema([
                                Forms\Components\Toggle::make('icepacks_returned')->required(),
                                Forms\Components\Textarea::make('special_note')->columnSpanFull(),
                                Forms\Components\Toggle::make('is_delivered')->required(),
                            ]),

                        ])


                    ])
                    ->action(function (array $data, $record) {
                        $record->update([
                            'icepacks_returned' => $data['icepacks_returned'],
                            'special_note' => $data['special_note'],
                            'is_delivered' => $data['is_delivered'],
                            'delivery_time' => now(),
                        ]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Complition')
                    ->modalSubmitActionLabel('Submit')
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
            'index' => Pages\ListDeliveries::route('/'),
            // 'create' => Pages\CreateDelivery::route('/create'),
            // 'edit' => Pages\EditDelivery::route('/{record}/edit'),
        ];
    }
}
