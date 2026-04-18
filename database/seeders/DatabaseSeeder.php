<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Administrateur principal
        User::factory()->create([
            'name' => 'Admin RAOSC',
            'email' => 'admin@raosc.org',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Création de 5 utilisateurs standards
        User::factory(5)->create();

        $this->call([
            OrganizationCategorySeeder::class,
            OrganizationSeeder::class,
            ProjectSeeder::class,
            PostSeeder::class,
        ]);
    }
}
