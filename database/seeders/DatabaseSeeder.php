<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test1'),
        ]);

        User::factory()->create([
            'name' => 'Test User2',
            'email' => 'test2@example.com',
            'password' => bcrypt('test2'),
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
            'is_admin' => true,
        ]);

        User::factory(10)->create();

        Film::factory(10)->create();
        Location::factory(10)->create();

        // Données de test pour la commande DeleteOldLocations
        $user = User::first();
        $film = Film::first();

        // Plus d'un mois + 4 upvotes => NE doit PAS être supprimée
        Location::factory()->create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'name' => 'Vieux lieu populaire',
            'upvotes_count' => 4,
            'created_at' => now()->subDays(40),
            'updated_at' => now()->subDays(40),
        ]);

        // Plus d'un mois + 1 upvote => DOIT être supprimée
        Location::factory()->create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'name' => 'Vieux lieu impopulaire',
            'upvotes_count' => 1,
            'created_at' => now()->subDays(40),
            'updated_at' => now()->subDays(40),
        ]);
    }
}
