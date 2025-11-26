<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CreatorProfile;
use App\Models\TalentCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestCreatorsSeeder extends Seeder
{
    /**
     * Run the database seeds - Test version with first 5 creators
     */
    public function run(): void
    {
        $this->command->info('Starting test CSV creators import (first 5 creators)...');

        // Test data from the CSV
        $testCreators = [
            [
                'name' => 'Tamara Nivillac',
                'artistName' => 'Tamara Nivillac',
                'artStyle' => 'Singer, Songwriter',
                'instagram' => 'Tamara Nivillac',
                'facebook' => 'Tamara Nivillac',
                'bio' => "From soul to Afro-Caribbean rhythms, Tamara's music carries the heart of her island and the power of personal freedom. Through lyrics in Papiamentu and English, she tells stories of identity, strength, and connection."
            ],
            [
                'name' => 'Désirée Merien',
                'artistName' => 'Stichting Eligio Melfor',
                'artStyle' => 'Komedia, Drama',
                'instagram' => '',
                'facebook' => '',
                'bio' => "🎭 We are Grupo Eligio Melfor 🎭 Founded by the unforgettable Eligio Melfor, our stage has always been a home for laughter, culture, and reflection. From comedies that make you smile to stories that make you think, we bring theater to everyone, everywhere."
            ],
            [
                'name' => 'Rushendel rosaleña',
                'artistName' => 'Ruro entertainment',
                'artStyle' => 'Cinematographer, Director',
                'instagram' => 'Ruroenetertainement',
                'facebook' => 'Ruro entertainment',
                'bio' => "Ruro Entertainment is a creative powerhouse specializing in cinematography and directing, known for producing visually striking and emotionally compelling work. With a strong presence in the Caribbean film scene, Ruro brings stories to life through the lens, blending cinematic technique with cultural authenticity."
            ],
            [
                'name' => 'Aj',
                'artistName' => 'Shots by Aj',
                'artStyle' => 'Cinematographer',
                'instagram' => '_shotsbya',
                'facebook' => '',
                'bio' => "AJ, known professionally as Shots by AJ, is a talented cinematographer with a sharp eye for detail and visual storytelling. From music videos to short films, AJ captures moments with depth, creativity, and precision."
            ],
            [
                'name' => 'Explosion Dancer',
                'artistName' => 'Explosion Dancer',
                'artStyle' => 'Dance group',
                'instagram' => 'Explosion Dancer',
                'facebook' => '',
                'bio' => "Explosion Dancer is one of the largest and most dynamic dance groups in Curaçao. Known for their explosive energy and powerful choreography, the group blends urban styles with cultural flair to create unforgettable performances."
            ]
        ];

        // Create creator avatars directory
        if (!Storage::disk('public')->exists('creator-avatars')) {
            Storage::disk('public')->makeDirectory('creator-avatars');
        }

        $createdCount = 0;

        foreach ($testCreators as $creatorData) {
            try {
                $result = $this->createTestCreator($creatorData);
                if ($result) {
                    $createdCount++;
                    $this->command->info("Created creator: {$creatorData['name']}");
                }

                // Small delay between creators
                usleep(250000); // 0.25 second delay

            } catch (\Exception $e) {
                $this->command->warn("Error creating creator {$creatorData['name']}: " . $e->getMessage());
            }
        }

        $this->command->info("Test import completed!");
        $this->command->info("Created: {$createdCount} test creators");
    }

    private function createTestCreator(array $data): bool
    {
        $name = $data['name'];
        $artStyle = $data['artStyle'];
        $instagram = $data['instagram'];
        $facebook = $data['facebook'];
        $bio = $data['bio'];

        // Check if user already exists
        $email = $this->generateUniqueEmail($name);
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->command->warn("User already exists: {$email}");
            return false;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password123'),
            'role' => 'creator',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Download and store avatar image
        $avatarPath = $this->downloadCreatorImage($name, $artStyle);

        // Create creator profile
        $creatorProfile = CreatorProfile::create([
            'user_id' => $user->id,
            'short_bio' => $this->generateShortBio($bio, $artStyle),
            'about_me' => $bio,
            'banner_image' => $avatarPath,
            'facebook_url' => $facebook ? $this->normalizeUrl($facebook) : null,
            'instagram_url' => $instagram ? $this->normalizeInstagramUrl($instagram) : null,
            'is_featured' => rand(1, 3) == 1,
            'profile_views' => rand(50, 200),
            'total_likes' => rand(10, 50),
            'is_active' => true,
        ]);

        // Update user avatar
        if ($avatarPath) {
            $user->update(['avatar' => $avatarPath]);
        }

        // Assign talent categories
        $this->assignTalentCategories($creatorProfile, $artStyle);

        return true;
    }

    private function generateUniqueEmail(string $name): string
    {
        $baseEmail = Str::slug($name) . '@curacao-talents.com';
        $email = $baseEmail;
        $counter = 1;

        while (User::where('email', $email)->exists()) {
            $email = Str::slug($name) . $counter . '@curacao-talents.com';
            $counter++;
        }

        return $email;
    }

    private function downloadCreatorImage(string $name, string $artStyle): ?string
    {
        try {
            // Get image based on profession/art style
            $imageUrl = $this->getUnsplashImageUrl($artStyle);

            $response = Http::timeout(15)->get($imageUrl);

            if ($response->successful()) {
                $fileName = 'creator-' . Str::slug($name) . '-' . time() . '.jpg';
                $imagePath = 'creator-avatars/' . $fileName;

                Storage::disk('public')->put($imagePath, $response->body());

                $this->command->info("Downloaded image for: {$name}");
                return $imagePath;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download image for {$name}: " . $e->getMessage());
        }

        return null;
    }

    private function getUnsplashImageUrl(string $artStyle): string
    {
        // Map art styles to search terms
        $searchTerms = [
            'Singer' => 'singer-musician',
            'Songwriter' => 'songwriter-music',
            'Komedia' => 'comedian-performer',
            'Drama' => 'actor-theatre',
            'Cinematographer' => 'cinematographer-camera',
            'Director' => 'film-director',
            'Dance group' => 'dance-group',
            'Drummer' => 'drummer-music',
            'Designer' => 'designer-creative',
            'Actor' => 'actor-performer',
            'Dj' => 'dj-music',
            'Editor' => 'video-editor',
            'Influencer' => 'influencer-content',
            'Dancer' => 'dancer-performance',
            'Pianist' => 'pianist-music',
            'Content creator' => 'content-creator'
        ];

        // Extract primary art style
        $primaryStyle = explode(',', $artStyle)[0];
        $primaryStyle = trim($primaryStyle);

        $searchKey = $searchTerms[$primaryStyle] ?? 'creative-professional';

        // Use Unsplash Source API with specific search
        return "https://source.unsplash.com/400x400/?{$searchKey}";
    }

    private function generateShortBio(string $bio, string $artStyle): string
    {
        if (!empty($bio)) {
            // Extract first sentence or first 120 characters
            $shortBio = explode('.', $bio)[0];
            if (strlen($shortBio) > 120) {
                $shortBio = substr($shortBio, 0, 120);
            }
            return $shortBio . '.';
        }

        return 'Creative professional passionate about artistic expression.';
    }

    private function normalizeUrl(string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://facebook.com/' . $url;
        }

        return $url;
    }

    private function normalizeInstagramUrl(string $handle): ?string
    {
        if (empty($handle)) {
            return null;
        }

        $handle = ltrim($handle, '@');

        if (strpos($handle, 'instagram.com') !== false) {
            return $this->normalizeUrl($handle);
        }

        return 'https://instagram.com/' . $handle;
    }

    private function assignTalentCategories(CreatorProfile $creatorProfile, string $artStyle): void
    {
        if (empty($artStyle)) {
            return;
        }

        $styles = explode(',', $artStyle);
        $categoryIds = [];

        foreach ($styles as $style) {
            $style = trim($style);
            if (empty($style)) {
                continue;
            }

            $category = TalentCategory::where('name', $style)->first();
            if ($category) {
                $categoryIds[] = $category->id;
            }
        }

        if (!empty($categoryIds)) {
            $creatorProfile->talentCategories()->attach(array_unique($categoryIds));
            $this->command->info("Assigned " . count($categoryIds) . " categories to {$creatorProfile->user->name}");
        }
    }
}
