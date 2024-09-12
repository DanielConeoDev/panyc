<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoResource\Pages;
use App\Filament\Resources\TipoResource\RelationManagers;
use App\Models\Tipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\IconPosition;

class TipoResource extends Resource
{
    protected static ?string $model = Tipo::class;

    protected static ?string $navigationIcon = 'gmdi-science-tt';

    protected static ?string $navigationLabel = 'Tipo Análisis';

    protected static ?string $navigationGroup = 'Parametros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Tipo De Analisis')
                    ->icon('gmdi-science-tt')
                    ->schema([
                        TextInput::make('tipo')
                        ->afterStateUpdated(fn($state, callable $set) => $set('tipo', strtoupper($state)))
                            ->label('Tipo De Analisis')
                            ->required(),
                        RichEditor::make('descripcion')
                            ->label('Descripcion')
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipo')
                    ->label('Tipo De Analisis')
                    ->searchable(),
                TextColumn::make('descripcion')
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
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTipos::route('/'),
            'create' => Pages\CreateTipo::route('/create'),
            'edit' => Pages\EditTipo::route('/{record}/edit'),
        ];
    }
}
