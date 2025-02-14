<?php

namespace App\Filament\Dashboard\Resources\KundeResource\Pages;

use App\Filament\Dashboard\Resources\KundeResource;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\ViewRecord;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

class ViewKunde extends ViewRecord
{
    protected static string $resource = KundeResource::class;


    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Kontaktdaten')
            ->schema([
            Tabs::make('Kunde Informationen')
                ->tabs([
                    Tab::make('Kundendetails')
                        ->schema([
                        Toggle::make('is_business')
                            ->label('Geschäftskunde')
                            ->disabled(), // Schaltet das Feld auf disabled
                        Placeholder::make('title')
                            ->label('Titel')
                            ->content(fn ($record) => $record->title ? $record->title->name : 'Kein Titel')
                            ->disabled(),
                        TextInput::make('vorname')
                            ->label('Vorname')
                            ->maxLength(255)
                            ->disabled(), // Schaltet das Feld auf disabled
                        TextInput::make('nachname')
                            ->label('Nachname')
                            ->maxLength(255)
                            ->disabled(), // Schaltet das Feld auf disabled
                        TextInput::make('bname')
                            ->label('Firmenname')
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('is_business'))
                            ->disabled(), // Schaltet das Feld auf disabled
                        Fieldset::make('Kontaktinformationen')
                            ->schema([
                                TextInput::make('tel')
                                    ->label('Telefon')
                                    ->tel()
                                    ->maxLength(20)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('mobil')
                                    ->label('Mobil')
                                    ->tel()
                                    ->maxLength(20)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('email')
                                    ->label('E-Mail')
                                    ->email()
                                    ->maxLength(255)
                                    ->disabled(), // Schaltet das Feld auf disabled
                            ]),
                        Fieldset::make('Adresse')
                            ->schema([
                                TextInput::make('street')
                                    ->label('Straße')
                                    ->maxLength(255)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('ort')
                                    ->label('Ort')
                                    ->maxLength(255)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('zip')
                                    ->label('Postleitzahl')
                                    ->maxLength(10)
                                    ->disabled(), // Schaltet das Feld auf disabled
                            ]),
                        Fieldset::make('Bankverbindung')
                            ->schema([
                                TextInput::make('bank')
                                    ->label('Bankname')
                                    ->maxLength(255)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('iban')
                                    ->label('IBAN')
                                    ->maxLength(34)
                                    ->disabled(), // Schaltet das Feld auf disabled
                                TextInput::make('bic')
                                    ->label('BIC')
                                    ->maxLength(11)
                                    ->disabled(), // Schaltet das Feld auf disabled
                            ]),
                        TextInput::make('www')
                            ->label('Webseite')
                            ->maxLength(255)
                            ->disabled(), // Schaltet das Feld auf disabled
                        Textarea::make('disc')
                            ->label('Notiz')
                            ->maxLength(255)
                            ->disabled(), // Schaltet das Feld auf disabled
                        ]),
                    Tab::make('Ansprechpartner')
                        ->schema([
                            Grid::make([
                                'default' => 1,
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                            ])
                            ->schema($this->getAnsprechpartnerFields()), // Ansprechpartner-Felder laden
                        ]),
                ])
            ])->columns(1)    
        ]);
    }

    public function getActions(): array
    {
        return [
            EditAction::make('edit')
                ->label('Bearbeiten')
                ->icon('heroicon-o-pencil')
                ->color('success'),
        ];
    }

    /**
     * Returns a schema for Ansprechpartner fields.
     */
    public function getAnsprechpartnerFields(): array
    {
        // Ansprechpartner laden, inklusive Soft-Deleted Datensätze
        $ansprechpartner = $this->record->ansprechpartner()->get();

        // Falls keine Ansprechpartner vorhanden sind, zeige eine Nachricht an
        if ($ansprechpartner->isEmpty()) {
            return [
                Placeholder::make('message')
                    ->label('Ansprechpartner')
                    ->content('Keine Ansprechpartner vorhanden'),
            ];
        }

        return $ansprechpartner->map(function ($ansprechpartner) {
            return Placeholder::make('ansprechpartner_' . $ansprechpartner->id)
                ->view('components.ansprechpartner-card', [
                    'titel' => $ansprechpartner->title ? $ansprechpartner->title->name : '', // Abrufen des Titels über die Beziehung
                    'vorname' => $ansprechpartner->vorname,
                    'nachname' => $ansprechpartner->nachname,
                    'email' => $ansprechpartner->email,
                    'tel' => $ansprechpartner->tel,
                    'mobil' => $ansprechpartner->mobil,
                    'position' => $ansprechpartner->position,
                    'deleted' => $ansprechpartner->trashed() ? 'Ja' : 'Nein',
                ]);
        })->toArray();
        
    }
}
