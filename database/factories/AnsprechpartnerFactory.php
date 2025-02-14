<?php

namespace Database\Factories;

use App\Models\Ansprechpartner;
use App\Models\Kunde;
use App\Models\Title;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnsprechpartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ansprechpartner::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = Title::inRandomOrder()->first();
        $kunde = Kunde::inRandomOrder()->first();
        $position = $this->faker->randomElement(['Manager', 'Leiter', 'Mitarbeiter', 'Assistent']);
        $vorname = $this->faker->firstName();
        $nachname = $this->faker->lastName();
        $email = $this->faker->unique()->safeEmail();
        $ort = $this->faker->city();
        $street = $this->faker->streetAddress();
        $zip = $this->faker->postcode();
        $mobil = $this->faker->phoneNumber();
        $tel = $this->faker->phoneNumber();

        return [
            'kunde_id' => $kunde->id,
            'position' => $position,
            'title_id' => $title ? $title->id : null, // Setzt den Fremdschlüssel für den Titel
            'vorname' => $vorname,
            'nachname' => $nachname,
            'email' => $email,
            'ort' => $ort,
            'street' => $street,
            'zip' => $zip,
            'mobil' => $mobil,
            'tel' => $tel,
        ];
    }
}