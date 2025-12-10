<?php

namespace App\Filament\Resources\HvpItemResource\Pages;

use App\Filament\Resources\HvpItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHvpItems extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = HvpItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
