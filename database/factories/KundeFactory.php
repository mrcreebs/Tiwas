<?php

namespace Database\Factories;

use App\Models\Kunde;
use App\Models\Title; // Importiere das Title Model
use Illuminate\Database\Eloquent\Factories\Factory;

class KundeFactory extends Factory
{
    protected $model = Kunde::class;

    public function definition(): array
    {
        $isBusiness = $this->faker->boolean();
        
        // Wähle einen zufälligen Titel aus der titles-Tabelle
        $title = Title::inRandomOrder()->first();

        $vorname = $this->faker->firstName();
        $nachname = $this->faker->lastName();
        $bname = $isBusiness ? $this->faker->unique()->company() : null; // Firmenname nur für Geschäftskunden, und unique
        $email = $this->faker->unique()->safeEmail();
        $ort = $this->faker->city();
        $street = $this->faker->streetAddress();
        $zip = $this->faker->postcode();
        $www = $isBusiness ? $this->faker->domainName() : null;
        $bank = $this->faker->randomElement(['Sparkasse', 'Volksbank', 'Deutsche Bank', 'Commerzbank']);
        $iban = $this->faker->iban();
        $bic = $this->faker->swiftBicNumber();
        $disc = $this->faker->optional()->text(200);

        return [
            'is_business' => $isBusiness,
            'title_id' => $title ? $title->id : null, // Setzt den Fremdschlüssel für den Titel
            'vorname' => $vorname,
            'nachname' => $nachname,
            'bname' => $bname,
            'tel' => substr($this->faker->phoneNumber(), 0, 20),
            'mobil' => substr($this->faker->phoneNumber(), 0, 20),
            'email' => $email,
            'ort' => $ort,
            'street' => $street,
            'zip' => $zip,
            'www' => $www,
            'bank' => $bank,
            'iban' => $iban,
            'bic' => $bic,
            'disc' => $disc,
        ];
    }
}
