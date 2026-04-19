<?php

namespace App\Filament\Resources\AiProviders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\AiProvider;

class AiProvidersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vendor.name')
                    ->label('Proveedor')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('aiModel.name')
                    ->label('Modelo')
                    ->searchable(),
                IconColumn::make('is_default')
                    ->label('Predeterminado')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('web_search_enabled')
                    ->label('Búsqueda Web')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('default')
                    ->label('Set Default')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (AiProvider $record): bool => $record->is_default)
                    ->action(function (AiProvider $record) {
                        AiProvider::where('id', '!=', $record->id)->update(['is_default' => false]);
                        $record->update(['is_default' => true]);
                    })
                    ->requiresConfirmation(),
                EditAction::make(),
                \Filament\Actions\ReplicateAction::make()
                    ->excludeAttributes(['is_default'])
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['name'] = $data['name'] . ' (Copia)';
                        $data['is_default'] = false;
                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('clone')
                        ->label('Clonar seleccionados')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('warning')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            foreach ($records as $record) {
                                $clone = $record->replicate();
                                $clone->name = $clone->name . ' (Copia)';
                                $clone->is_default = false;
                                $clone->save();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
