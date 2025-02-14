<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AngebotResource\Pages;
use App\Filament\Dashboard\Resources\AngebotResource\RelationManagers;
use App\Models\Angebot;
use App\Models\AngebotsArtikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AngebotResource extends Resource
{
    protected static ?string $model = Angebot::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Kunde auswählen
            Forms\Components\Select::make('kunde_id')
                ->label('Kunde')
                ->options(\App\Models\Kunde::all()->pluck('full_name', 'id'))
                ->searchable()
                ->required(),

            // Repeater für Positionen (äußere Ebene)
            Forms\Components\Repeater::make('positionen')
                ->relationship('positionen')
                ->schema([
                    Forms\Components\Grid::make(1)
                                ->schema([
                                // Position Felder
                                Forms\Components\Placeholder::make('position')
                                    ->label('Position')
                                    ->content(fn ($get) => $get('position')),

                                Forms\Components\TextArea::make('kopftext')
                                    ->nullable()
                                    ->label('Kopftext'),
                                ]),

                                // Innerer Repeater für Artikel
                                Forms\Components\Repeater::make('angebotsArtikel')
                                    ->relationship('angebotsArtikel')
                                    ->schema([
                                        
                                        // Menge, Einzelpreis und Gesamtpreis
                                        Forms\Components\Grid::make(7)
                                            ->schema([
                                                // Artikel auswählen
                                                Forms\Components\Select::make('artikel_id')
                                                    ->label('Artikel')
                                                    ->relationship('artikel', 'name')
                                                    ->required()
                                                    ->reactive()
                                                    ->searchable(fn ($get) => \App\Models\Artikel::where('name', 'like', '%' . $get('artikel') . '%')->get())
                                                    ->afterStateUpdated(function ($state, callable $set) {
                                                        $artikel = \App\Models\Artikel::find($state);
                                                        $set('artikelbeschreibung', $artikel ? $artikel->disc : '');
                                                        $set('einzelpreis', $artikel ? $artikel->price : null);
                                                        $set('kategorie', $artikel ? $artikel->kategorie : '');
                                                        $set('aktiv', $artikel ? $artikel->aktiv : false);
                                                        $set('image', $artikel ? $artikel->image : '');
                                                    }),
                                                
                                                // Artikelbeschreibung anzeigen
                                                Forms\Components\TextInput::make('artikelbeschreibung')
                                                    ->label('Artikelbeschreibung'),
                                                
                                                Forms\Components\Toggle::make('aktiv')
                                                    ->label('Aktiv')
                                                    ->default(false),


                                                Forms\Components\FileUpload::make('image')
                                                    ->label('Bild')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('angebots-artikel/')
                                                    ->moveFiles()
                                                    ->previewable(true)
                                                    ->visibility('public'),

                                                Forms\Components\TextInput::make('menge')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Menge')
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                        $set('gesamtpreis', $get('menge') * $get('einzelpreis'));
                                                    }),

                                                Forms\Components\TextInput::make('einzelpreis')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Einzelpreis (€)')
                                                    ->reactive()
                                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                        $set('gesamtpreis', $get('menge') * $get('einzelpreis'));
                                                    }),

                                                Forms\Components\TextInput::make('gesamtpreis')
                                                    ->numeric()
                                                    ->required()
                                                    ->label('Gesamtpreis (€)'),
                                            ]),
                                    ])
                                    ->reorderable()
                                    ->reorderableWithButtons()
                                    ->defaultItems(1)
                                    ->itemLabel(fn (array $state): ?string => $state['artikelbeschreibung'] ?? 'Neuer Artikel')
                                    ->collapsible()
                                    ->itemLabel('Artikel')
                                    ->cloneable(),

                                    Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextArea::make('fusstext')
                                            ->nullable()
                                            ->label('Fußtext'),

                                    Forms\Components\TextInput::make('rabatt')
                                            ->numeric()
                                            ->nullable()
                                            ->label('Rabatt (%)'),
                                                
                                    ]),

                            ])
                            ->reorderable(true)
                            ->reorderableWithButtons(true)
                            ->cloneable()
                            ->orderColumn('position') // Die Spalte 'position' wird für die Reihenfolge verwendet
                            ->defaultItems(1)
                            ->collapsible(),
                ])
                ->columns(1);
           
}


    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('id')
                ->label('Angebotsnummer')
                ->sortable()
                ->searchable(),

            TextColumn::make('kunde.full_name')
                ->label('Kunde')
                ->sortable()
                ->searchable(),

            TextColumn::make('gesamtbetrag')
                ->label('Gesamtbetrag (€)')
                ->sortable()
                ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.') . ' €'),

            TextColumn::make('created_at')
                ->label('Erstellt am')
                ->dateTime('d.m.Y H:i')
                ->sortable(),

            TextColumn::make('updated_at')
                ->label('Aktualisiert am')
                ->dateTime('d.m.Y H:i')
                ->sortable(),
        ])
        ->filters([
            Filter::make('kunde')
                ->form([
                    Forms\Components\Select::make('kunde_id')
                        ->label('Kunde')
                        ->options(\App\Models\Kunde::all()->pluck('full_name', 'id'))
                        ->searchable(),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query->when(
                        $data['kunde_id'] ?? null,
                        fn (Builder $query, $kundeId) => $query->where('kunde_id', $kundeId)
                    );
                }),

            Filter::make('datum')
                ->form([
                    Forms\Components\DatePicker::make('created_from')
                        ->label('Erstellt ab'),
                    Forms\Components\DatePicker::make('created_until')
                        ->label('Erstellt bis'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when($data['created_from'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
                        ->when($data['created_until'] ?? null, fn ($query, $date) => $query->whereDate('created_at', '<=', $date));
                }),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAngebots::route('/'),
            'create' => Pages\CreateAngebot::route('/create'),
            'edit' => Pages\EditAngebot::route('/{record}/edit'),
        ];
    }
}
