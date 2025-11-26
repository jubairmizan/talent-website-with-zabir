<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CreatorLike;
use App\Models\CreatorProfile;
use App\Models\User;

class CreatorLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all creator profiles and users
        $creatorProfiles = CreatorProfile::all();
        $users = User::all();

        if ($creatorProfiles->isEmpty() || $users->isEmpty()) {
            $this->command->warn('No creator profiles or users found. Please run CreatorProfileSeeder and UserSeeder first.');
            return;
        }

        // Create some sample likes
        $likesData = [];
        
        foreach ($creatorProfiles as $creatorProfile) {
            // Each creator profile gets likes from random users
            $numberOfLikes = rand(5, 15); // Random number of likes per creator
            $randomUsers = $users->random(min($numberOfLikes, $users->count()));
            
            foreach ($randomUsers as $user) {
                // Avoid self-likes (if the user is the creator themselves)
                if ($user->id !== $creatorProfile->user_id) {
                    $likesData[] = [
                        'creator_profile_id' => $creatorProfile->id,
                        'user_id' => $user->id,
                        'created_at' => now()->subDays(rand(0, 30)), // Random dates within last 30 days
                    ];
                }
            }
        }

        // Remove duplicates (in case random selection picked same user twice)
        $uniqueLikes = collect($likesData)->unique(function ($item) {
            return $item['creator_profile_id'] . '-' . $item['user_id'];
        })->values()->all();

        // Insert likes in batches for better performance
        $chunks = array_chunk($uniqueLikes, 100);
        foreach ($chunks as $chunk) {
            CreatorLike::insert($chunk);
        }

        // Update creator profiles with total likes count
        foreach ($creatorProfiles as $creatorProfile) {
            $likesCount = CreatorLike::where('creator_profile_id', $creatorProfile->id)->count();
            $creatorProfile->update(['total_likes' => $likesCount]);
        }

        $this->command->info('Creator likes seeded successfully! Total likes created: ' . count($uniqueLikes));
    }
}