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
                \Filament\Actions\Action::make('analyze')
                    ->label('Analizar')
                    ->icon('heroicon-o-beaker')
                    ->color('indigo')
                    ->slideOver()
                    ->modalHeading(fn (HvpResult $record) => "Análisis: " . ($record->guest_name ?? "Usuario " . $record->user_id))
                    ->modalSubmitActionLabel('Recalcular Análisis')
                    ->modalIcon('heroicon-o-sparkles')
                    ->action(function (HvpResult $record) {
                        $record->recalculateScores();
                        $record->generateAiInterpretation();
                        \Filament\Notifications\Notification::make()
                            ->title('Análisis regenerado con éxito')
                            ->success()
                            ->send();
                    })
                    ->fillForm(fn (HvpResult $record): array => [
                        'ai_interpretation' => $record->ai_interpretation,
                    ])
                    ->infolist(function (Schema $infolist): Schema {
                        return $infolist
                            ->components([
                                \Filament\Schemas\Components\Section::make()
                                    ->components([
                                        \Filament\Schemas\Components\Text::make(fn ($record) => new \Illuminate\Support\HtmlString(\Illuminate\Support\Str::markdown($record->ai_interpretation ?? 'No se ha generado un análisis aún. Haz clic en "Recalcular Análisis" para comenzar.')))
                                            ->columnSpanFull(),
                                    ])
                            ]);
                        })
                        ->extraModalFooterActions([
                            \Filament\Actions\Action::make('downloadPdfDrawer')
                                ->label('Descargar PDF')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->color('gray')
                                ->action(fn (HvpResult $record) => static::downloadPdf($record)),
                        ]),
                    \Filament\Actions\Action::make('downloadPdf')
                        ->label('PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('gray')
                        ->action(fn (HvpResult $record) => static::downloadPdf($record)),
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->check() && !auth()->user()->isAdmin()) {
            return $query->where('user_id', auth()->id());
        }

        return $query;
    }

    public static function downloadPdf(HvpResult $record)
    {
        if (!$record->ai_interpretation) {
            \Filament\Notifications\Notification::make()
                ->title('Error')
                ->body('Primero debe generar un análisis para descargar el PDF.')
                ->danger()
                ->send();
            return;
        }

        $part1Normative = \App\Models\HvpItem::where('part', 'part_1')->pluck('correct_order', 'id')->toArray();
        $part2Normative = \App\Models\HvpItem::where('part', 'part_2')->pluck('correct_order', 'id')->toArray();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.diagnosis', [
            'result' => $record,
            'aiInterpretation' => \App\Models\HvpResult::formatForPdf($record->ai_interpretation),
            'date' => now()->format('d/m/Y'),
            'part1Normative' => $part1Normative,
            'part2Normative' => $part2Normative,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Diagnostico_Hartman_{$record->guest_name}.pdf");
    }
}
