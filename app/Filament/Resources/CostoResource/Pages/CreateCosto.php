<?php

namespace App\Filament\Resources\CostoResource\Pages;

use App\Filament\Resources\CostoResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateCosto extends CreateRecord
{
    protected static string $resource = CostoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('instrucciones')
                ->label('Instrucciones')
                ->icon('heroicon-m-information-circle')
                ->modalHeading('Registro de Alimentos – Guía de Usuario')
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Cerrar')
                ->modalContent(view('costo.instrucciones')),
        ];
    }
}
