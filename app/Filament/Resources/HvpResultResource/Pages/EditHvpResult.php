<?php

namespace App\Filament\Resources\HvpResultResource\Pages;

use App\Filament\Resources\HvpResultResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHvpResult extends EditRecord
{
    protected static string $resource = HvpResultResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
