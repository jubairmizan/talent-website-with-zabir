<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CreatorTalentCategory;
use App\Models\CreatorProfile;
use App\Models\TalentCategory;

class CreatorTalentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all creator profiles and talent categories
        $creatorProfiles = CreatorProfile::all();
        $talentCategories = TalentCategory::all();

        if ($creatorProfiles->isEmpty() || $talentCategories->isEmpty()) {
            $this->command->warn('No creator profiles or talent categories found. Please run CreatorProfileSeeder and TalentCategorySeeder first.');
            return;
        }

        // Define specific talent assignments for each creator based on their profile
        $creatorTalentAssignments = [
            // John Designer - Graphic Designer
            0 => ['Graphic Design', 'Logo Design', 'Brand Identity', 'Print Design'],
            // Sarah Developer - Full-stack Developer
            1 => ['Web Development', 'UI/UX Design', 'Mobile App Development', 'Frontend Development'],
            // Mike Photographer - Photographer
            2 => ['Photography', 'Photo Editing', 'Portrait Photography'],
            // Emma Video Producer - Video Producer
            3 => ['Video Production', 'Video Editing', 'Motion Graphics', 'Animation'],
            // Alex Writer - Content Writer
            4 => ['Content Writing', 'Copywriting', 'Blog Writing'],
        ];

        $relationshipsData = [];

        foreach ($creatorProfiles as $index => $creatorProfile) {
            if (isset($creatorTalentAssignments[$index])) {
                // Assign specific talents to this creator
                $assignedTalents = $creatorTalentAssignments[$index];
                
                foreach ($assignedTalents as $talentName) {
                    $talentCategory = $talentCategories->where('name', $talentName)->first();
                    
                    if ($talentCategory) {
                        $relationshipsData[] = [
                            'creator_profile_id' => $creatorProfile->id,
                            'talent_category_id' => $talentCategory->id,
                            'created_at' => now(),
                        ];
                    }
                }
            } else {
                // For any additional creators, assign random talents
                $numberOfTalents = rand(2, 4); // Each creator gets 2-4 random talents
                $randomTalents = $talentCategories->random(min($numberOfTalents, $talentCategories->count()));
                
                foreach ($randomTalents as $talentCategory) {
                    $relationshipsData[] = [
                        'creator_profile_id' => $creatorProfile->id,
                        'talent_category_id' => $talentCategory->id,
                        'created_at' => now(),
                    ];
                }
            }
        }

        // Remove duplicates (in case random selection picked same talent twice for a creator)
        $uniqueRelationships = collect($relationshipsData)->unique(function ($item) {
            return $item['creator_profile_id'] . '-' . $item['talent_category_id'];
        })->values()->all();

        // Insert relationships in batches for better performance
        $chunks = array_chunk($uniqueRelationships, 100);
        foreach ($chunks as $chunk) {
            CreatorTalentCategory::insert($chunk);
        }

        $this->command->info('Creator talent category relationships seeded successfully! Total relationships created: ' . count($uniqueRelationships));
    }
}