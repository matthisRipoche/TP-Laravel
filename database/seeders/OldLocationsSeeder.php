<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class OldLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $film = Film::first();

        // Location de plus d'un mois avec 4 upvotes => NE doit PAS être supprimée
        Location::factory()->create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'name' => 'Vieux lieu populaire',
            'upvotes_count' => 4,
            'created_at' => now()->subDays(40),
            'updated_at' => now()->subDays(40),
        ]);

        // Location de plus d'un mois avec 1 upvote => DOIT être supprimée
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
