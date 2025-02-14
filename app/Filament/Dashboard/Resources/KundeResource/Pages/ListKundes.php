<?php

namespace App\Filament\Dashboard\Resources\KundeResource\Pages;

use App\Filament\Dashboard\Resources\KundeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKundes extends ListRecords
{
    protected static string $resource = KundeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
