<?php

namespace App\Filament\Dashboard\Resources\AngebotResource\Pages;

use App\Filament\Dashboard\Resources\AngebotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAngebots extends ListRecords
{
    protected static string $resource = AngebotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
