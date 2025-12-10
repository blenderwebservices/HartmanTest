<?php

namespace App\Filament\Resources\HvpItemResource\Pages;

use App\Filament\Resources\HvpItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHvpItem extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = HvpItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
