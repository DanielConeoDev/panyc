<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComponenteResource\Pages;
use App\Filament\Resources\ComponenteResource\RelationManagers;
use App\Models\Componente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\IconPosition;

class ComponenteResource extends Resource
{
    protected static ?string $model = Componente::class;

    protected static ?string $navigationIcon = 'gmdi-hive-tt';

    protected static ?string $navigationGroup = 'Parametros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipo De Analisis')
                    ->icon('gmdi-science-tt')
                    ->schema([
                        Select::make('tipo_id')
                            ->label('Tipo De Analisis')
                            ->relationship(name: 'tipo', titleAttribute: 'tipo')
                            ->searchable()
                            ->required()
                            ->preload()
                    ]),
                Section::make('Componentes')
                    ->icon('gmdi-hive-tt')
                    ->schema([
                        TextInput::make('componente')
                            ->label('Componente')
                            ->required()
                            ->afterStateUpdated(fn($state, callable $set) => $set('componente', strtoupper($state))),
                        RichEditor::make('descripcion')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('componente')
                    ->label('Componente')
                    ->searchable(),
                TextColumn::make('tipo.tipo')
                    ->label('Tipo de Analisis')
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->markdown()
                    ->limit(50)
                    ->label('Descripción')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('No description.'),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tipos')
                    ->relationship('tipo', 'tipo')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->color('warning')
                    ->icon('gmdi-mode-edit-tt')
                    ->iconButton()
                    ->button()
                    ->outlined()
                    ->tooltip('Editar')
                    ->label('Editar')
                    ->iconPosition(IconPosition::After),
                Tables\Actions\DeleteAction::make()
                    ->icon('gmdi-delete-tt')
                    ->iconButton()
                    ->button()
                    ->outlined()
                    ->tooltip('Eliminar')
                    ->label('Eliminar')
                    ->iconPosition(IconPosition::After),
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
            'index' => Pages\ListComponentes::route('/'),
            'create' => Pages\CreateComponente::route('/create'),
            'edit' => Pages\EditComponente::route('/{record}/edit'),
        ];
    }
}
