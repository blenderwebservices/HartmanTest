<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HvpResultResource\Pages;
use App\Filament\Resources\HvpResultResource\RelationManagers;
use App\Models\HvpResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HvpResultResource extends Resource
{
    protected static ?string $model = HvpResult::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label('User ID')
                    ->disabled(),
                Forms\Components\TextInput::make('guest_name')
                    ->label('Guest Name')
                    ->disabled(),
                Forms\Components\Textarea::make('part_1_ranking')
                    ->label('Part 1 Ranking')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('part_2_ranking')
                    ->label('Part 2 Ranking')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('scores')
                    ->label('Scores')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->label('User ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guest_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListHvpResults::route('/'),
            'view' => Pages\ViewHvpResult::route('/{record}'),
        ];
    }
}
