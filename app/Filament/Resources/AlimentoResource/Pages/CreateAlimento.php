<?php

namespace App\Filament\Resources\AlimentoResource\Pages;

use App\Filament\Resources\AlimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateAlimento extends CreateRecord
{
    protected static string $resource = AlimentoResource::class;

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
                ->modalContent(view('alimento.instrucciones')),
        ];
    }
}
