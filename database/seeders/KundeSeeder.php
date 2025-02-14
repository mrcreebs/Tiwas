<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class KundeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory()->withPersonalTeam()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Seed Kunden
        \App\Models\Kunde::factory(200)->create();

        // Seed Artikel
        \App\Models\Artikel::factory(100)->create();

        // Seed Ansprechpartner
        \App\Models\Ansprechpartner::factory(100)->create();

    }
}
