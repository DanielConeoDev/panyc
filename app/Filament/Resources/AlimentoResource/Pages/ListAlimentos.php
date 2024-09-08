<?php

namespace App\Filament\Resources\AlimentoResource\Pages;

use App\Filament\Resources\AlimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlimentos extends ListRecords
{
    protected static string $resource = AlimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
