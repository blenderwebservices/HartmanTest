<?php

namespace App\Filament\Resources\HvpResultResource\Pages;

use App\Filament\Resources\HvpResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHvpResults extends ListRecords
{
    protected static string $resource = HvpResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
