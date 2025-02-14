<?php

namespace App\Filament\Dashboard\Resources\KundeResource\Pages;

use App\Filament\Dashboard\Resources\KundeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKunde extends EditRecord
{
    protected static string $resource = KundeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
