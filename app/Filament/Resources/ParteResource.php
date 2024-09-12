<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParteResource\Pages;
use App\Filament\Resources\ParteResource\RelationManagers;
use App\Models\Parte;
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

class ParteResource extends Resource
{
    protected static ?string $model = Parte::class;

    protected static ?string $navigationIcon = 'gmdi-bubble-chart-tt';

    protected static ?string $navigationLabel = 'Parte Analizada';

    protected static ?string $navigationGroup = 'Parametros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Parte Analizada')
                    ->icon('gmdi-bubble-chart-tt')
                    ->schema([
                        TextInput::make('parte')
                            ->label('Parte Analizada')
                            ->afterStateUpdated(fn($state, callable $set) => $set('parte', strtoupper($state)))
                            ->required(),
                        RichEditor::make('descripcion')
                            ->label('Descripción')
                    ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parte')
                    ->label('Parte Analizada')
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->markdown()
                    //->limit(50)
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
            'index' => Pages\ListPartes::route('/'),
            'create' => Pages\CreateParte::route('/create'),
            'edit' => Pages\EditParte::route('/{record}/edit'),
        ];
    }
}
