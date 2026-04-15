<?php

namespace App\Filament\Widgets;

use App\Models\AiProvider;
use App\Models\HvpResult;
use App\Filament\Resources\HvpResultResource;
use App\Filament\Resources\AiProviders\AiProviderResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $isAdmin = $user?->isAdmin();

        $stats = [
            Stat::make('Resultados de Hartman', $isAdmin 
                ? HvpResult::count() 
                : HvpResult::where('user_id', $user->id)->count()
            )
                ->description($isAdmin ? 'Total de pruebas registradas' : 'Tus pruebas registradas')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('success')
                ->url(HvpResultResource::getUrl('index')),
        ];

        if ($isAdmin) {
            $stats[] = Stat::make('Agentes de IA', AiProvider::count())
                ->description('Proveedores de IA configurados')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('primary')
                ->url(AiProviderResource::getUrl('index'));
        }

        return $stats;
    }
}
