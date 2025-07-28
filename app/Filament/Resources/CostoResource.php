<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Costo;
use Livewire\Livewire;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\CostoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CostoResource\RelationManagers;
use Filament\Forms\Components\TextInput\Mask;


class CostoResource extends Resource
{
    protected static ?string $model = Costo::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $label = 'Costos';
    protected static ?string $pluralLabel = 'Costos';

    protected static ?string $navigationGroup = 'Gestión de alimentos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 3, // 3 columnas para lograr proporción 2/3 - 1/3
                ])
                    ->schema([

                        // 🔹 Sección Principal (2/3)
                        Section::make('Selección de Alimento')
                            ->description('Busca y selecciona el alimento para ver su información de costos.')
                            ->schema([
                                Select::make('alimento_id')
                                    ->label('Alimento')
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->getSearchResultsUsing(function (string $search) {
                                        return \App\Models\Alimento::query()
                                            ->where('nombre_del_alimento', 'like', "%{$search}%")
                                            ->orWhere('codigo', 'like', "%{$search}%")
                                            ->limit(20)
                                            ->get()
                                            ->mapWithKeys(function ($alimento) {
                                                $tieneActivo = $alimento->costos()
                                                    ->where('estado', 'activo')
                                                    ->exists();

                                                $icono = $tieneActivo ? '✅' : '❌';

                                                return [
                                                    $alimento->codigo => "{$icono} {$alimento->nombre_del_alimento}",
                                                ];
                                            });
                                    })
                                    ->getOptionLabelUsing(function ($value): ?string {
                                        $alimento = \App\Models\Alimento::find($value);
                                        if (!$alimento) return null;

                                        $tieneActivo = $alimento->costos()
                                            ->where('estado', 'activo')
                                            ->exists();

                                        $icono = $tieneActivo ? '✅' : '❌';

                                        return "{$icono} {$alimento->nombre_del_alimento}";
                                    }),

                                Placeholder::make('leyenda')
                                    ->content('
                                    ✅ : El alimento tiene al menos un precio activo.  
                                    ❌ : El alimento no tiene precio activo actualmente.
                                ')
                                    ->columnSpan('full'),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'md' => 2,
                            ]),

                        // 🔹 Sección Secundaria (1/3)
                        Section::make('Precio Activo del Alimento')
                            ->description('Muestra el precio vigente y la fecha de actualización.')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Placeholder::make('precio_actual')
                                            ->label('💰 Precio actual')
                                            ->content(function ($get) {
                                                $alimentoCodigo = $get('alimento_id');
                                                if (!$alimentoCodigo) {
                                                    return 'Seleccione un alimento';
                                                }

                                                $costoActivo = \App\Models\Costo::where('alimento_id', $alimentoCodigo)
                                                    ->where('estado', 'activo')
                                                    ->latest('created_at')
                                                    ->first();

                                                return $costoActivo
                                                    ? '$' . number_format($costoActivo->precio, 2, ',', '.') . ' COP'
                                                    : 'No hay precio activo';
                                            }),

                                        Placeholder::make('fecha_precio')
                                            ->label('📅 Fecha del precio')
                                            ->content(function ($get) {
                                                $alimentoCodigo = $get('alimento_id');
                                                if (!$alimentoCodigo) {
                                                    return '—';
                                                }

                                                $costoActivo = \App\Models\Costo::where('alimento_id', $alimentoCodigo)
                                                    ->where('estado', 'activo')
                                                    ->latest('created_at')
                                                    ->first();

                                                return $costoActivo
                                                    ? $costoActivo->created_at->format('d/m/Y H:i')
                                                    : '—';
                                            }),
                                    ]),
                            ])
                            ->columnSpan([
                                'default' => 1,
                                'md' => 1,
                            ]),
                    ]),


                Section::make('💵 Nuevo Precio')
                    ->description('Registre el valor del alimento junto con la unidad de medida correspondiente.')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2, // en pantallas medianas o mayores: 2 columnas
                        ])
                            ->schema([
                                TextInput::make('precio')
                                    ->label('Nuevo precio')
                                    ->required()
                                    ->integer()
                                    ->minValue(1)
                                    ->prefix('$')
                                    ->suffix('COP')
                                    ->placeholder('Ejemplo: 3500')
                                    ->helperText('Ingrese el valor en pesos sin puntos ni comas.')
                                    ->live(onBlur: true) // 🔹 Solo valida al quitar el foco
                                    ->afterStateUpdated(function ($state) {
                                        if ($state === '') {
                                            return; // No validamos si está vacío (ya se validará por "required")
                                        }

                                        if (!ctype_digit($state)) {
                                            \Filament\Notifications\Notification::make()
                                                ->title('Error en el campo Precio')
                                                ->body('El precio debe contener solo números enteros sin puntos ni comas.')
                                                ->danger()
                                                ->send();
                                        } else {
                                            \Filament\Notifications\Notification::make()
                                                ->title('Precio válido')
                                                ->body('El valor ingresado es correcto.')
                                                ->success()
                                                ->send();
                                        }
                                    }),

                                Select::make('unidad_medida')
                                    ->label('Unidad de medida')
                                    ->options([
                                        'kg' => 'Kilogramos',
                                        'g' => 'Gramos',
                                        'l' => 'Litros',
                                        'ml' => 'Mililitros',
                                        'unidad' => 'Unidad',
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->native(false) // mejora el diseño del select
                                    ->helperText('Seleccione la unidad en la que aplica el precio.'),
                            ]),
                    ])

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alimento.codigo')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('alimento.nombre_del_alimento')
                    ->label('Alimento')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->tooltip(
                        fn(TextColumn $column): ?string =>
                        strlen($column->getState()) > $column->getCharacterLimit()
                            ? $column->getState()
                            : null
                    )
                    ->formatStateUsing(fn(string $state) => strtoupper($state)),

                Tables\Columns\TextColumn::make('precio')
                    ->label('Precio')
                    ->sortable()
                    ->formatStateUsing(fn($state) => '$' . number_format($state, 0, ',', '.') . ' COP'),

                Tables\Columns\TextColumn::make('unidad_medida')
                    ->label('Unidad')
                    ->searchable()
                    ->formatStateUsing(fn(string $state) => strtoupper($state)),

                Tables\Columns\IconColumn::make('estado')
                    ->label('Estado')
                    ->icon(fn(string $state) => $state === 'activo'
                        ? 'heroicon-o-check-circle'
                        : 'heroicon-o-x-circle')
                    ->color(fn(string $state) => $state === 'activo'
                        ? 'success'
                        : 'danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                Tables\Filters\Filter::make('buscar')
                    ->form([
                        Forms\Components\TextInput::make('codigo')
                            ->label('Código del alimento')
                            ->placeholder('Ej: A001'),

                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre del alimento')
                            ->placeholder('Ej: Arroz'),

                        Forms\Components\DatePicker::make('desde')
                            ->label('Fecha desde'),

                        Forms\Components\DatePicker::make('hasta')
                            ->label('Fecha hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['codigo'],
                                fn($q, $codigo) =>
                                $q->whereHas(
                                    'alimento',
                                    fn($a) =>
                                    $a->where('codigo', 'like', "%{$codigo}%")
                                )
                            )
                            ->when(
                                $data['nombre'],
                                fn($q, $nombre) =>
                                $q->whereHas(
                                    'alimento',
                                    fn($a) =>
                                    $a->where('nombre_del_alimento', 'like', "%{$nombre}%")
                                )
                            )
                            ->when(
                                $data['desde'],
                                fn($q, $desde) =>
                                $q->whereDate('created_at', '>=', $desde)
                            )
                            ->when(
                                $data['hasta'],
                                fn($q, $hasta) =>
                                $q->whereDate('created_at', '<=', $hasta)
                            );
                    }),
            ])

            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Action::make('ver_costos')
                        ->label('Histórico')
                        ->icon('heroicon-o-document-text')
                        ->modalHeading(
                            fn($record) =>
                            'Costos del alimento: ' . strtoupper($record->alimento->nombre_del_alimento)
                        )
                        ->modalWidth('6xl')
                        ->modalContent(
                            fn($record) =>
                            view('livewire.costos-alimento-modal', [
                                'alimento_id' => $record->alimento_id,
                            ])
                        ),
                ])->icon('heroicon-m-plus-circle'),
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
            'index' => Pages\ListCostos::route('/'),
            'create' => Pages\CreateCosto::route('/create'),
            'edit' => Pages\EditCosto::route('/{record}/edit'),
        ];
    }
}
