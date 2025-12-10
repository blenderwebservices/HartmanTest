<?php

namespace App\Filament\Resources\HvpItemResource\Pages;

use App\Filament\Resources\HvpItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHvpItem extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = HvpItemResource::class;
}
