<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\CreatorProfile;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and creator profiles
        $users = User::all();
        $creatorProfiles = CreatorProfile::all();

        if ($users->isEmpty() || $creatorProfiles->isEmpty()) {
            $this->command->warn('No users or creator profiles found. Please run UserSeeder and CreatorProfileSeeder first.');
            return;
        }

        $favoritesData = [];

        foreach ($users as $user) {
            // Each user favorites 2-5 random creators
            $numberOfFavorites = rand(2, 5);
            $randomCreators = $creatorProfiles->random(min($numberOfFavorites, $creatorProfiles->count()));
            
            foreach ($randomCreators as $creatorProfile) {
                // Users cannot favorite their own profile
                if ($user->id !== $creatorProfile->user_id) {
                    $favoritesData[] = [
                        'user_id' => $user->id,
                        'creator_profile_id' => $creatorProfile->id,
                        'created_at' => now()->subDays(rand(0, 60)), // Random dates within last 60 days
                    ];
                }
            }
        }

        // Remove duplicates (in case random selection picked same creator twice for a user)
        $uniqueFavorites = collect($favoritesData)->unique(function ($item) {
            return $item['user_id'] . '-' . $item['creator_profile_id'];
        })->values()->all();

        // Insert favorites in batches for better performance
        $chunks = array_chunk($uniqueFavorites, 100);
        foreach ($chunks as $chunk) {
            Favorite::insert($chunk);
        }

        $this->command->info('Favorites seeded successfully! Total favorites created: ' . count($uniqueFavorites));
    }
}