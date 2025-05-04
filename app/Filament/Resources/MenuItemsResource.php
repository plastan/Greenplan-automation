<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemsResource\Pages;
use App\Filament\Resources\MenuItemsResource\RelationManagers;
use App\Models\MenuItems;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;

use Filament\Forms\Components\Select;

class MenuItemsResource extends Resource
{
    protected static ?string $model = MenuItems::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';


    public static function form($form): Form
    {
        return $form
            ->schema([
                Repeater::make('Menu Items')->schema([

                    Split::make([
                        Section::make('Primary Details')->schema([

                            Forms\Components\DatePicker::make('week_start_date')->default(Carbon::now()->next('Monday'))->visible(false),

                            Forms\Components\DatePicker::make('meal_date')
                                ->autofocus() // Autofocus the field.
                                ->displayFormat($format = 'D F j, Y')
                                ->default(Carbon::now()),

                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('description')
                                ->required()
                                ->maxLength(255),

                            Select::make('category')
                                ->options([
                                    'breakfast' => 'Breakfast',
                                    'lunch' => 'Lunch',
                                    'dinner' => 'Dinner',
                                ])
                                ->required(),

                            Select::make('dietary_type')
                                ->options(['diabetic' => "diabetic", 'muscle gain' => 'muscle_gain', 'weight loss' => 'weight_loss', 'veg' => 'veg','regular' => 'regular'])
                                ->required(),

                        ])->grow(),


                        Section::make('Nutritional Information')->schema([
                            Forms\Components\TextInput::make('calories')
                                ->numeric(),

                            Forms\Components\TextInput::make('fat')
                                ->numeric(),

                            Forms\Components\TextInput::make('carbs')
                                ->numeric(),

                            Forms\Components\TextInput::make('protein')
                                ->numeric(),

                        ])->columns()
                    ])

                ])->columnSpanFull()->defaultItems(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->defaultGroup('week_start_date')
            ->columns([
                Tables\Columns\TextColumn::make('week_start_date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                Tables\Columns\TextColumn::make('meal_date')
                    ->date($format = "d D")
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dietary_type')->label('Meal plan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('calories')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('fat')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('carbs')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('protein')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(true)->defaultPaginationPageOption(25);
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItems::route('/create'),
            'edit' => Pages\EditMenuItems::route('/{record}/edit'),
        ];
    }
}
