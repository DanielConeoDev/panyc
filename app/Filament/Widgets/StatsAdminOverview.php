<?php

namespace App\Filament\Widgets;

use App\Models\Alimento;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('usuarios_count', User::query()->count())
                ->label('Usuarios Registrados')
                ->description('Último registro: ' . User::latest()->first()?->created_at->format('d/m/Y'))
                ->descriptionIcon('heroicon-s-user-group') // Icono de la descripción
                ->icon('heroicon-o-user') // Icono del stat
                ->color('success')
                ->extraAttributes(['class' => 'text-xl font-semibold']), // Estilos opcionales

            Stat::make('alimento_count', Alimento::query()->count())
                ->label('Alimentos Registrados')
                ->description('Registrados este mes: ' . Alimento::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
                ->descriptionIcon('heroicon-m-arrow-trending-up') // Puedes cambiarlo según lo que prefieras
                ->icon('gmdi-no-food-tt') // Puedes cambiar este icono por algo relacionado con alimentos
                ->color('success') // Ajusta el color según sea necesario
                ->extraAttributes(['class' => 'text-xl font-semibold']),

            Stat::make('Recetas', '0')
                ->description('En Desarrollo')
                ->icon('gmdi-code-r')
                ->descriptionIcon('gmdi-code-r')
                ->color('warning'),
        ];
    }
}
