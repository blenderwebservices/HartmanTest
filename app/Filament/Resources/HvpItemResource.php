<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HvpItemResource\Pages;
use App\Filament\Resources\HvpItemResource\RelationManagers;
use App\Models\HvpItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Resources\Concerns\Translatable;

class HvpItemResource extends Resource
{
    use Translatable;

    protected static ?string $model = HvpItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('part')
                    ->options([
                        'part_1' => 'Part 1 (The World)',
                        'part_2' => 'Part 2 (The Self)',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('content')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('correct_order')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(18),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('part')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->searchable(),
                Tables\Columns\TextColumn::make('correct_order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListHvpItems::route('/'),
            'create' => Pages\CreateHvpItem::route('/create'),
            'edit' => Pages\EditHvpItem::route('/{record}/edit'),
        ];
    }
}
