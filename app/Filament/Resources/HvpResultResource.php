<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HvpResultResource\Pages;
use App\Filament\Resources\HvpResultResource\RelationManagers;
use App\Models\HvpResult;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HvpResultResource extends Resource
{
    protected static ?string $model = HvpResult::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->label('User ID')
                    ->disabled(),
                Forms\Components\TextInput::make('guest_name')
                    ->label('Guest Name')
                    ->disabled(),
                Forms\Components\Placeholder::make('part_1_ranking')
                    ->label('Part 1 Ranking')
                    ->content(fn ($record) => new \Illuminate\Support\HtmlString('<pre style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-family: monospace; font-size: 0.875rem;">' . json_encode($record?->part_1_ranking ?? [], JSON_PRETTY_PRINT) . '</pre>'))
                    ->columnSpanFull(),
                Forms\Components\Placeholder::make('part_2_ranking')
                    ->label('Part 2 Ranking')
                    ->content(fn ($record) => new \Illuminate\Support\HtmlString('<pre style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-family: monospace; font-size: 0.875rem;">' . json_encode($record?->part_2_ranking ?? [], JSON_PRETTY_PRINT) . '</pre>'))
                    ->columnSpanFull(),
                Forms\Components\Placeholder::make('scores')
                    ->label('Scores')
                    ->content(fn ($record) => new \Illuminate\Support\HtmlString('<pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; font-family: monospace; font-size: 0.875rem;">' . json_encode($record?->scores ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>'))
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
                \Filament\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
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
