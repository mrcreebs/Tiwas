<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Title; // Stelle sicher, dass dies korrekt importiert ist
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Rufe den PermissionsDemoSeeder auf
        $this->call([
            PermissionsDemoSeeder::class,
            // Hier kannst du weitere Seeder hinzufügen
        ]);

        // Hol die Rolle 'User' aus der Datenbank
        $role1 = Role::where('name', 'User')->first();

        // Erstelle 10 Benutzer und weise ihnen die Rolle 'User' zu
        User::factory(10)->create()->each(function ($user) use ($role1) {
            $user->assignRole($role1);
        });

        $titles = ['Herr', 'Frau', 'Dr', 'Prof', 'Dipl', 'Ing', 'Mgr', 'MSc', 'PhD'];

        foreach ($titles as $title) {
            Title::create(['name' => $title]);
        }

    }
}
