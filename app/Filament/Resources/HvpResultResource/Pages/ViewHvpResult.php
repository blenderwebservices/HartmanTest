<?php

namespace App\Filament\Resources\HvpResultResource\Pages;

use App\Filament\Resources\HvpResultResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHvpResult extends ViewRecord
{
    protected static string $resource = HvpResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
