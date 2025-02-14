<?php

namespace App\Filament\Dashboard\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kunde;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Facades\Blade;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Dashboard\Resources\KundeResource\Pages;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Filters\TrashedFilter;

class KundeResource extends Resource
{
    protected static ?string $model = Kunde::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $recordTitleAttribute = 'bname';

    protected static ?string $navigationGroup = 'Kunden';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kontaktdaten')
                    ->schema([
                        
                    
                Wizard::make([
                    Step::make('Kunde Information')
                        ->description('Details about the customer')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Toggle::make('is_business')
                                ->label('Geschäftskunde')
                                ->reactive()
                                ->required(),
                            Forms\Components\Select::make('title_id')
                                ->label('Titel')
                                ->relationship('title', 'name') // Beziehung zu Title, Anzeige des 'name'
                                ->required(fn ($get) => $get('is_business') == false)
                                ->reactive(),
                            Forms\Components\TextInput::make('vorname')
                                ->label('Vorname')
                                ->maxLength(255)
                                ->required(fn ($get) => $get('is_business') == false)
                                ->reactive(),
                            Forms\Components\TextInput::make('nachname')
                                ->label('Nachname')
                                ->maxLength(255)
                                ->required(fn ($get) => $get('is_business') == false)
                                ->reactive(),
                            Forms\Components\TextInput::make('bname')
                                ->label('Firmenname')
                                ->maxLength(255)
                                ->visible(fn ($get) => $get('is_business'))
                                ->required(fn ($get) => $get('is_business'))
                                ->reactive(),
                            Forms\Components\Fieldset::make('Kontaktinformationen')
                                ->schema([
                                    Forms\Components\TextInput::make('tel')
                                        ->label('Telefon')
                                        ->tel()
                                        ->maxLength(20),
                                    Forms\Components\TextInput::make('mobil')
                                        ->label('Mobil')
                                        ->tel()
                                        ->maxLength(20),
                                    Forms\Components\TextInput::make('email')
                                        ->label('E-Mail')
                                        ->email()
                                        ->maxLength(255)
                                        ->unique(table: 'kundes', column: 'email', ignoreRecord: true),
                                ]),
                            Forms\Components\Fieldset::make('Adresse')
                                ->schema([
                                    Forms\Components\TextInput::make('street')
                                        ->label('Straße')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('ort')
                                        ->label('Ort')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('zip')
                                        ->label('Postleitzahl')
                                        ->maxLength(10),
                                ]),
                            Forms\Components\Fieldset::make('Bankverbindung')
                                ->schema([
                                    Forms\Components\TextInput::make('bank')
                                        ->label('Bankname')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('iban')
                                        ->label('IBAN')
                                        ->maxLength(34),
                                    Forms\Components\TextInput::make('bic')
                                        ->label('BIC')
                                        ->maxLength(11),
                                ]),
                            Forms\Components\TextInput::make('www')
                                ->label('Webseite')
                                ->maxLength(255),
                            Forms\Components\TextArea::make('disc')
                                ->label('Notiz')
                                ->maxLength(255),
                        ]),
                        Step::make('Ansprechpartner Information')
                        ->description('Details about the contact person')
                        ->icon('heroicon-o-phone')
                        ->schema([
                            Forms\Components\Repeater::make('ansprechpartner')
                                ->label('Ansprechpartner')
                                ->relationship('ansprechpartner') // Definiert die Beziehung
                                ->schema([
                                    Forms\Components\Select::make('title_id')
                                        ->label('Titel')
                                        ->relationship('title', 'name') // Beziehung zu Title, Anzeige des 'name'
                                        ->required(),
                                    Forms\Components\Select::make('position')
                                        ->label('Position')
                                        ->options([
                                            'Manager' => 'Manager',
                                            'Leiter' => 'Leiter',
                                            'Mitarbeiter' => 'Mitarbeiter',
                                            'Assistent' => 'Assistent',
                                        ])
                                        ->required(),
                                    Forms\Components\TextInput::make('vorname')
                                        ->label('Vorname')
                                        ->maxLength(255)
                                        ->required(),
                                    Forms\Components\TextInput::make('nachname')
                                        ->label('Nachname')
                                        ->maxLength(255)
                                        ->required(),
                                    Forms\Components\TextInput::make('email')
                                        ->label('E-Mail')
                                        ->email()
                                        ->maxLength(255)
                                        ->unique(table: 'ansprechpartners', column: 'email', ignoreRecord: true),
                                    Forms\Components\TextInput::make('tel')
                                        ->label('Telefon')
                                        ->tel()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('mobil')
                                        ->label('Mobil')
                                        ->tel()
                                        ->maxLength(255),
                                           ])
                        ]),

                    // Submit Button
                ])
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm"
                    >
                        Submit
                    </x-filament::button>
    BLADE)))
    ])->columns(1)     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Allgemeine Informationen
                Tables\Columns\IconColumn::make('is_business')
                    ->label('Geschäftskunde')
                    ->boolean(),

                Tables\Columns\TextColumn::make('title.name')
                    ->label('Titel')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('vorname')
                    ->label('Vorname')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nachname')
                    ->label('Nachname')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bname')
                    ->label('Firmenname')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                // Kontaktinformationen
                Tables\Columns\TextColumn::make('tel')
                    ->label('Telefon')
                    ->searchable(),

                Tables\Columns\TextColumn::make('mobil')
                    ->label('Mobil')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                Tables\Columns\TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable(),

                // Adressdaten
                Tables\Columns\TextColumn::make('street')
                    ->label('Straße')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                Tables\Columns\TextColumn::make('ort')
                    ->label('Ort')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                Tables\Columns\TextColumn::make('zip')
                    ->label('Postleitzahl')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                // Bankverbindung
                Tables\Columns\TextColumn::make('bank')
                    ->label('Bankname')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Standardmäßig ausgeblendet

                Tables\Columns\TextColumn::make('iban')
                    ->label('IBAN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Standardmäßig ausgeblendet

                Tables\Columns\TextColumn::make('bic')
                    ->label('BIC')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Standardmäßig ausgeblendet

                // Weitere Informationen
                Tables\Columns\TextColumn::make('www')
                    ->label('Webseite')
                    ->searchable()
                    ->toggleable(), // Optional ein- und ausblendbar

                Tables\Columns\TextColumn::make('disc')
                    ->label('Notiz')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Metadaten
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Erstellt am')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), 

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Zuletzt bearbeitet')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), 

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Gelöscht am')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('secondary')
                    ->icon('heroicon-o-eye')
                    ->label('')
                    ->disabled(fn ($record) => $record->trashed()), // Prüft, ob der Datensatz im Trash ist
                Tables\Actions\EditAction::make()
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->label('')
                    ->disabled(fn ($record) => $record->trashed()), // Prüft, ob der Datensatz im Trash ist
                Tables\Actions\DeleteAction::make()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->label('')
                    ->disabled(fn ($record) => $record->trashed()), // Prüft, ob der Datensatz bereits gelöscht ist
                Tables\Actions\RestoreAction::make()
                    ->label('Wiederherstellen')
                    ->color('warning')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn ($record) => $record->trashed()), // Zeigt die Wiederherstellen-Aktion nur für gelöschte Datensätze an
                Tables\Actions\ForceDeleteAction::make()
                    ->label('Endgültig löschen')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->trashed()), // Zeigt die endgültige Löschaktion nur für gelöschte Datensätze an
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(), // Für das Wiederherstellen mehrerer Datensätze
                Tables\Actions\ForceDeleteBulkAction::make(), // Für das endgültige Löschen mehrerer Datensätze
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //KundeRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKundes::route('/'),
            'create' => Pages\CreateKunde::route('/create'),
            'edit' => Pages\EditKunde::route('/{record}/edit'),
            'view' => Pages\ViewKunde::route('/{record}'),
        ];
    }
}