<?php

namespace App\Filament\Resources\AiProviders;

use App\Filament\Resources\AiProviders\Pages\CreateAiProvider;
use App\Filament\Resources\AiProviders\Pages\EditAiProvider;
use App\Filament\Resources\AiProviders\Pages\ListAiProviders;
use App\Filament\Resources\AiProviders\Schemas\AiProviderForm;
use App\Filament\Resources\AiProviders\Tables\AiProvidersTable;
use App\Models\AiProvider;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AiProviderResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    protected static ?string $model = AiProvider::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationLabel = 'Configuración IA';

    protected static ?string $modelLabel = 'Proveedor IA';

    protected static ?string $pluralModelLabel = 'Proveedores IA';

    protected static \UnitEnum|string|null $navigationGroup = 'Inteligencia Artificial';

    public static function form(Schema $schema): Schema
    {
        return AiProviderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AiProvidersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAiProviders::route('/'),
            'create' => CreateAiProvider::route('/create'),
            'edit'   => EditAiProvider::route('/{record}/edit'),
        ];
    }
}
