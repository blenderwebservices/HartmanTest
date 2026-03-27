<?php

namespace App\Filament\Resources\AiProviders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AiProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Select::make('ai_vendor_id')
                    ->label('Proveedor IA')
                    ->relationship('vendor', 'name')
                    ->createOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. OpenAI)'),
                        TextInput::make('key')->required()->label('Clave interna (Ej. openai)'),
                    ])
                    ->editOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. OpenAI)'),
                        TextInput::make('key')->required()->label('Clave interna (Ej. openai)'),
                    ])
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->suffixActions([
                        \Filament\Actions\Action::make('deleteVendor')
                            ->label('Eliminar Proveedor')
                            ->icon('heroicon-m-trash')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->visible(fn ($state) => filled($state))
                            ->action(function (Select $component, $state) {
                                \App\Models\AiVendor::find($state)?->delete();
                                $component->state(null);
                            }),
                    ]),
                TextInput::make('api_key')
                    ->label('API Key')
                    ->password()
                    ->revealable(),
                TextInput::make('base_url')
                    ->label('URL Base')
                    ->url(),
                Select::make('ai_model_id')
                    ->label('Modelo')
                    ->relationship('aiModel', 'name', function ($query, callable $get) {
                        $vendorId = $get('ai_vendor_id');
                        if ($vendorId) {
                            $query->where('ai_vendor_id', $vendorId);
                        }
                    })
                    ->createOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. GPT-4o)'),
                        TextInput::make('key')->required()->label('Identificador (Ej. gpt-4o)'),
                    ])
                    ->createOptionAction(
                        fn (\Filament\Actions\Action $action) => $action->mutateFormDataUsing(function (array $data, callable $get) {
                            $data['ai_vendor_id'] = $get('ai_vendor_id');
                            return $data;
                        })
                    )
                    ->editOptionForm([
                        TextInput::make('name')->required()->label('Nombre (Ej. GPT-4o)'),
                        TextInput::make('key')->required()->label('Identificador (Ej. gpt-4o)'),
                    ])
                    ->required()
                    ->searchable()
                    ->preload()
                    ->suffixActions([
                        \Filament\Actions\Action::make('deleteModel')
                            ->label('Eliminar Modelo')
                            ->icon('heroicon-m-trash')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->visible(fn ($state) => filled($state))
                            ->action(function (Select $component, $state) {
                                \App\Models\AiModel::find($state)?->delete();
                                $component->state(null);
                            }),
                    ]),
                Textarea::make('system_prompt')
                    ->label('System Prompt')
                    ->helperText('Instrucciones del sistema para este modelo. Deja vacío para usar las instrucciones por defecto del agente.')
                    ->rows(8)
                    ->columnSpanFull(),
                Toggle::make('is_default')
                    ->label('¿Establecer como predeterminado?')
                    ->helperText('Esta configuración será la que use el Chatbot por defecto.')
                    ->default(false),
                Toggle::make('web_search_enabled')
                    ->label('Habilitar Búsqueda Web')
                    ->helperText('Permite al chatbot buscar información en tiempo real en internet.')
                    ->default(false),
            ]);
    }
}
