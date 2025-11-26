<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // Base data seeders (should run first)
            TalentCategorySeeder::class,
            BlogCategorySeeder::class,

            // User and profile seeders
            CreatorProfileSeeder::class,
            MemberProfileSeeder::class,

            // Content seeders
            PortfolioItemsSeeder::class,
            BlogPostSeeder::class,

            // Relationship seeders (should run after profiles exist)
            CreatorTalentCategorySeeder::class,
            CreatorLikeSeeder::class,
            FavoriteSeeder::class,

            // Other data seeders
            ContactSubmissionSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
