<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

         // Den Artisan-Befehl 'permissions:sync' mit Argument 'COPY' ausführen
         Artisan::call('permissions:sync -COPY');

         // Ausgabe in der Konsole anzeigen
         $this->command->info('Permissions sync command executed with COPY flag.');

        // Create permissions
        $permissions = Permission::all()->pluck('name')->toArray();

        // Create roles and assign existing permissions
        $role1 = Role::create(['name' => 'User']);
        $role1->syncPermissions($permissions);

        $role2 = Role::create(['name' => 'admin']);
        $role2->syncPermissions($permissions);

        $role3 = Role::create(['name' => 'Super-Admin']);
        $role3->syncPermissions($permissions);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // Create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'), // Hash the password
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), // Hash the password
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('12345678'), // Hash the password
        ]);
        $user->assignRole($role3);
    }
}

