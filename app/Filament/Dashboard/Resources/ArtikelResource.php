<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\ArtikelResource\Pages;
use App\Models\Artikel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class ArtikelResource extends Resource
{
    protected static ?string $model = Artikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Artikel';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('artikelnummer')
                    ->required()
                    ->label('Artikelnummer')
                    ->maxLength(255),
                Forms\Components\Toggle::make('aktiv')
                    ->required()
                    ->label('Aktiv'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Name'),
                Forms\Components\TextInput::make('disc')
                    ->nullable()
                    ->maxLength(255)
                    ->label('Beschreibung'),
                Forms\Components\FileUpload::make('image')
                    ->label('Bild')
                    ->image()
                    ->disk('public')
                    ->directory('artikel/')
                    ->moveFiles()
                    ->previewable(true)
                    ->visibility('public'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Euro')
                    ->label('Preis'),
                Forms\Components\TextInput::make('anzahl')
                    ->required()
                    ->numeric()
                    ->label('Anzahl'),
                Forms\Components\Select::make('kategorie')
                    ->required()
                    ->label('Kategorie')
                    ->options([
                        'service' => 'Service',
                        'physikal' => 'Physikalisch',
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('artikelnummer')
                    ->searchable()
                    ->label('Artikelnummer'),
                Tables\Columns\IconColumn::make('aktiv')
                    ->boolean()
                    ->label('Aktiv'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Name'),
                Tables\Columns\TextColumn::make('disc')
                    ->searchable()
                    ->label('Beschreibung'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Bild'),
                Tables\Columns\TextColumn::make('price')
                    ->money('EUR', true)
                    ->sortable()
                    ->label('Preis'),
                Tables\Columns\TextColumn::make('anzahl')
                    ->sortable()
                    ->label('Anzahl'),
                Tables\Columns\TextColumn::make('kategorie')
                    ->label('Kategorie'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Erstellt am')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Aktualisiert am')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Gelöscht am')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(), // Filter für Soft Deletes
                Tables\Filters\SelectFilter::make('aktiv')
                    ->label('Aktiv')
                    ->options([
                        1 => 'Aktiv',
                        0 => 'Inaktiv',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListArtikels::route('/'),
            'create' => Pages\CreateArtikel::route('/create'),
            'edit' => Pages\EditArtikel::route('/{record}/edit'),
        ];
    }
}
