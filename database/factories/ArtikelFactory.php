<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtikelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Artikel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
{
    $name = $this->faker->sentence(3);
    $description = $this->faker->text(200); // Adjust the length as needed
    $price = $this->faker->randomFloat(2, 1, 1000);
    $kategorie = $this->faker->randomElement(['service', 'physikal']);

    return [
        'artikelnummer' => $this->faker->randomNumber(5),
        'aktiv' => $this->faker->boolean(),
        'name' => $name,
        'disc' => $description,
        'image' => null,
        'price' => $price,
        'anzahl' => $this->faker->numberBetween(1, 100),
        'kategorie' => $kategorie,
    ];
}
}