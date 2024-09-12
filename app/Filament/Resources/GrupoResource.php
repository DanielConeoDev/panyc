<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrupoResource\Pages;
use App\Filament\Resources\GrupoResource\RelationManagers;
use App\Models\Grupo;
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

class GrupoResource extends Resource
{
    protected static ?string $model = Grupo::class;

    protected static ?string $navigationIcon = 'gmdi-group-work-tt';

    protected static ?string $navigationGroup = 'Información';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Fuente')
                    ->icon('gmdi-source-tt')
                    ->schema([
                        Select::make('fuente_id')
                            ->relationship(name: 'fuente', titleAttribute: 'fuente')
                            ->required()
                            ->searchable()
                            ->preload()
                    ]),
                Section::make('Grupo')
                    ->icon('gmdi-group-work-tt')
                    ->schema([
                        TextInput::make('grupo')
                            ->afterStateUpdated(fn($state, callable $set) => $set('grupo', strtoupper($state)))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Grupo')
                            ->maxLength(255),
                        RichEditor::make('descripcion')
                            ->label('Descripción')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grupo')
                    ->label('Grupo')
                    ->searchable(),
                TextColumn::make('fuente.fuente')
                    ->label('Fuente')
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->markdown()
                    ->limit(50)
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
                SelectFilter::make('fuente')
                    ->relationship('fuente', 'fuente')
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
            'index' => Pages\ListGrupos::route('/'),
            'create' => Pages\CreateGrupo::route('/create'),
            'edit' => Pages\EditGrupo::route('/{record}/edit'),
        ];
    }
}
