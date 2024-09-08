<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlimentoResource\Pages;
use App\Filament\Resources\AlimentoResource\RelationManagers;
use App\Models\Alimento;
use App\Models\Componente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

class AlimentoResource extends Resource
{
    protected static ?string $model = Alimento::class;

    protected static ?string $navigationIcon = 'gmdi-no-food-tt';

    protected static ?string $navigationGroup = 'Alimentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1
                ])
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('Datos Alimentos')
                                ->icon('heroicon-m-shopping-bag')
                                ->schema([
                                    Grid::make([
                                        'default' => 2
                                    ])
                                        ->schema([
                                            TextInput::make('codigo')
                                                ->rule('regex:/^[a-zA-Z0-9]+$/')
                                                ->afterStateUpdated(fn($state, callable $set) => $set('codigo', strtoupper($state)))
                                                ->required()
                                        ]),
                                    TextInput::make('alimento')
                                        ->afterStateUpdated(fn($state, callable $set) => $set('alimento', strtoupper($state)))
                                        ->required()
                                ]),
                            Wizard\Step::make('Informacion Alimentos')
                                ->icon('heroicon-m-shopping-bag')
                                ->schema([
                                    Select::make('grupo_id')
                                        ->label('Grupos de Alimentos')
                                        ->relationship(name: 'grupo', titleAttribute: 'grupo')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    Select::make('parte_id')
                                        ->label('Parte Analizada')
                                        ->relationship(name: 'parte', titleAttribute: 'parte')
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    TextInput::make('comestible')
                                        ->required()
                                        ->numeric()
                                        ->rule('integer')
                                        ->rule('between:0,100')
                                        ->label('Parte Comestible (%)')
                                ]),
                            Wizard\Step::make('Composicion Alimentos')
                                ->icon('heroicon-m-shopping-bag')
                                ->schema([
                                    Repeater::make('item_alimentos')

                                        ->relationship()
                                        ->schema([
                                            Select::make('tipo_id')
                                                ->label('Tipo de Análisis')
                                                ->relationship(name: 'tipo', titleAttribute: 'tipo')
                                                ->searchDebounce(500) // Debounce de 500ms
                                                ->searchable()
                                                ->preload()
                                                ->live(),
                                            Select::make('componente_id')
                                                ->label('Componentes')
                                                ->relationship(name: 'componente', titleAttribute: 'componente')
                                                ->options(function (callable $get, callable $set, $state) {
                                                    $tipoId = $get('tipo_id'); // Obtener el valor seleccionado del primer Select
                                                    $selectedComponents = collect($get('../../item_alimentos')) // Obtener todos los componentes seleccionados
                                                        ->pluck('componente_id')
                                                        ->filter(); // Filtrar valores vacíos

                                                    $query = Componente::query();

                                                    if ($tipoId) {
                                                        // Filtrar por el tipo seleccionado
                                                        $query->where('tipo_id', $tipoId);
                                                    }

                                                    if ($selectedComponents->isNotEmpty()) {
                                                        // Excluir componentes que ya han sido seleccionados
                                                        $query->whereNotIn('id', $selectedComponents);
                                                    }

                                                    return $query->pluck('componente', 'id');
                                                })
                                                ->searchDebounce(500) // Debounce de 500ms
                                                ->searchable()
                                                ->preload()
                                                ->reactive() // Escucha cambios del campo 'tipo_id'
                                                ->live(),
                                            TextInput::make('valor')
                                                ->label('Valor Nutricional')
                                                ->numeric()
                                                ->rule('regex:/^\d+(\.\d{1,})?$/') // Permite solo números decimales con punto
                                        ])->grid(3)
                                ]),
                        ])

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlimentos::route('/'),
            'create' => Pages\CreateAlimento::route('/create'),
            'edit' => Pages\EditAlimento::route('/{record}/edit'),
        ];
    }
}
