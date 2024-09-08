<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FuenteResource\Pages;
use App\Filament\Resources\FuenteResource\RelationManagers;
use App\Models\Fuente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class FuenteResource extends Resource
{
    protected static ?string $model = Fuente::class;

    protected static ?string $navigationIcon = 'gmdi-source-tt';

    protected static ?string $navigationGroup = 'Información';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([  
                Split::make([
                    Section::make([
                        TextInput::make('fuente')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Fuente de información')
                            ->maxLength(255),
                        TextInput::make('url')
                            ->label('Url')
                            ->maxLength(255),
                        RichEditor::make('descripcion'),
                    ]),
                    Section::make([
                        TextInput::make('año')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y'))
                            ->minLength(4)
                            ->maxLength(4)
                            ->label('Año'),
                        Select::make('pais_id')
                            ->relationship(name: 'pais', titleAttribute: 'pais')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])->grow(false),
                ])->from('md')->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fuente')
                    ->label('Fuente')
                    ->searchable(),
                TextColumn::make('url')
                    ->label('URL'),
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('No description.'),
                TextColumn::make('año')
                    ->label('Año')
                    ->sortable(),
                TextColumn::make('pais.pais')
                    ->label('País')
                    ->searchable(),
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
                SelectFilter::make('pais')
                    ->relationship('pais', 'pais')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFuentes::route('/'),
            'create' => Pages\CreateFuente::route('/create'),
            'edit' => Pages\EditFuente::route('/{record}/edit'),
        ];
    }
}
