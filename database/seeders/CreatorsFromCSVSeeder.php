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
use Carbon\Carbon;

class CreatorsFromCSVSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting CSV creators import...');

        // Read CSV file
        $csvPath = storage_path('app/creators.csv');
        if (!file_exists($csvPath)) {
            $this->command->error('CSV file not found at: ' . $csvPath);
            return;
        }

        // Create creator avatars directory
        if (!Storage::disk('public')->exists('creator-avatars')) {
            Storage::disk('public')->makeDirectory('creator-avatars');
        }

        $handle = fopen($csvPath, 'r');
        if (!$handle) {
            $this->command->error('Could not open CSV file');
            return;
        }

        // Skip header row
        fgetcsv($handle);

        $createdCount = 0;
        $skippedCount = 0;

        while (($data = fgetcsv($handle)) !== false) {
            try {
                if (empty($data[1])) { // Skip rows without name
                    continue;
                }

                $result = $this->createCreatorFromCSVRow($data);
                if ($result) {
                    $createdCount++;
                    $this->command->info("Created creator: {$data[1]}");
                } else {
                    $skippedCount++;
                }

                // Prevent overwhelming the system
                if ($createdCount % 10 == 0) {
                    usleep(500000); // 0.5 second delay every 10 creators
                }
            } catch (\Exception $e) {
                $this->command->warn("Error creating creator {$data[1]}: " . $e->getMessage());
                $skippedCount++;
            }
        }

        fclose($handle);

        $this->command->info("CSV import completed!");
        $this->command->info("Created: {$createdCount} creators");
        $this->command->info("Skipped: {$skippedCount} rows");
    }

    private function createCreatorFromCSVRow(array $data): bool
    {
        // CSV structure: ,Name,Artist name/Organisation,Art Style,Insta,Facebook,Phone NR,Bio,Photo
        $name = trim($data[1]);
        $artistName = trim($data[2]) ?: $name;
        $artStyle = trim($data[3]);
        $instagram = trim($data[4]);
        $facebook = trim($data[5]);
        $phone = trim($data[6]);
        $bio = trim($data[7]);
        $photoUrl = trim($data[8]);

        if (empty($name)) {
            return false;
        }

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
            'password' => Hash::make('password123'), // Default password
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
            'about_me' => $bio ?: $this->generateAboutMe($name, $artStyle),
            'banner_image' => $avatarPath, // Using same image for banner for now
            'website_url' => null,
            'facebook_url' => $facebook ? $this->normalizeUrl($facebook) : null,
            'instagram_url' => $instagram ? $this->normalizeInstagramUrl($instagram) : null,
            'twitter_url' => null,
            'linkedin_url' => null,
            'youtube_url' => null,
            'tiktok_url' => null,
            'is_featured' => rand(1, 10) == 1, // 10% chance of being featured
            'profile_views' => rand(50, 500),
            'total_likes' => rand(10, 100),
            'is_active' => true,
        ]);

        // Update user avatar
        $user->update(['avatar' => $avatarPath]);

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
            $imageUrl = $this->getUnsplashImageUrl($artStyle, $name);

            $response = Http::timeout(30)->get($imageUrl);

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

    private function getUnsplashImageUrl(string $artStyle, string $name): string
    {
        // Map art styles to appropriate image search terms
        $searchTerms = [
            'Singer' => 'singer musician microphone',
            'Songwriter' => 'songwriter music composer',
            'Komedia' => 'comedian performer stage',
            'Drama' => 'actor theatre drama',
            'Cinematographer' => 'cinematographer camera film',
            'Director' => 'film director movie',
            'Dance group' => 'dance group performers',
            'Drummer' => 'drummer percussion music',
            'Designer' => 'designer creative artist',
            'Actor' => 'actor performer theatre',
            'Dj' => 'dj music mixing turntables',
            'Editor' => 'video editor filmmaker',
            'Influencer' => 'influencer content creator',
            'Dancer' => 'dancer performance art',
            'Pianist' => 'pianist piano musician',
            'Content creator' => 'content creator digital media',
            'Diseñado di moda' => 'fashion designer style',
            'Model' => 'model fashion portrait',
            'Tattoo artist' => 'tattoo artist ink art',
            'Digital creator' => 'digital artist creative',
            'Comedian' => 'comedian stand up performer',
            'Rapper' => 'rapper hip hop artist',
            'Producer' => 'music producer studio',
            'Radio Host' => 'radio host broadcaster',
            'Ambassador' => 'brand ambassador professional',
            'MC' => 'mc host entertainer',
            'Marketing Agency' => 'marketing professional business',
            'Dance Teacher' => 'dance teacher instructor',
            'Gospel Singer' => 'gospel singer choir music',
            'Barber' => 'barber hairstylist grooming',
            'Bartender' => 'bartender mixologist bar',
            'Musician' => 'musician instrument performer',
            'Film Producer' => 'film producer cinema',
            'Scriptwriter' => 'writer screenwriter creative',
            'Teacher' => 'teacher educator instructor',
            'TV/Radio Host' => 'tv host presenter broadcaster',
            'Hair Stylist' => 'hair stylist beauty salon',
            'Drone Pilot' => 'drone pilot aerial photographer',
            'Kanta i entretene' => 'entertainer performer artist',
            'Worshiper' => 'worship singer spiritual music',
            'Coach' => 'coach mentor trainer',
            'Circus' => 'circus performer acrobat',
            'Writer' => 'writer author creative',
            'Poet' => 'poet writer literary'
        ];

        // Extract primary art style
        $primaryStyle = explode(',', $artStyle)[0];
        $primaryStyle = trim($primaryStyle);

        $searchTerm = $searchTerms[$primaryStyle] ?? 'creative professional artist';

        // Use Unsplash Source for random professional images
        $width = 400;
        $height = 400;

        return "https://source.unsplash.com/{$width}x{$height}/?{$searchTerm}";
    }

    private function generateShortBio(string $bio, string $artStyle): string
    {
        if (!empty($bio)) {
            // Extract first sentence or first 100 characters
            $shortBio = explode('.', $bio)[0];
            if (strlen($shortBio) > 150) {
                $shortBio = substr($shortBio, 0, 150);
            }
            return $shortBio . '.';
        }

        // Generate based on art style
        $styles = explode(',', $artStyle);
        $primaryStyle = trim($styles[0]);

        $templates = [
            'Singer' => 'Professional singer bringing soulful melodies to life.',
            'Songwriter' => 'Creative songwriter crafting meaningful musical stories.',
            'Komedia' => 'Comedian spreading joy through laughter and entertainment.',
            'Drama' => 'Dramatic performer with passion for theatrical arts.',
            'Cinematographer' => 'Visual storyteller capturing moments through the lens.',
            'Director' => 'Creative director bringing visions to the screen.',
            'Dance group' => 'Dynamic dance collective expressing through movement.',
            'Drummer' => 'Rhythmic heartbeat behind every great performance.',
            'Designer' => 'Creative designer transforming ideas into visual reality.',
            'Actor' => 'Versatile performer bringing characters to life.',
            'Dj' => 'Music curator creating unforgettable sonic experiences.',
            'Editor' => 'Storytelling architect crafting compelling narratives.',
            'Influencer' => 'Digital storyteller connecting with audiences worldwide.',
            'Dancer' => 'Expressive dancer communicating through movement.',
            'Pianist' => 'Melodic virtuoso painting emotions with keys.',
            'Content creator' => 'Digital creative producing engaging multimedia content.',
            'Diseñado di moda' => 'Fashion visionary creating wearable art.',
            'Model' => 'Professional model bringing fashion to life.',
            'Tattoo artist' => 'Ink artist creating permanent masterpieces.',
            'Digital creator' => 'Digital innovator crafting online experiences.',
            'Comedian' => 'Stand-up performer brightening lives with humor.',
            'Rapper' => 'Lyrical artist expressing truth through rhythm.',
            'Producer' => 'Behind-the-scenes creator bringing projects to life.',
            'Radio Host' => 'Voice connecting communities through airwaves.',
            'Ambassador' => 'Brand representative building meaningful connections.',
            'MC' => 'Master of ceremonies energizing every event.',
            'Marketing Agency' => 'Strategic creative driving brand success.',
            'Dance Teacher' => 'Movement educator inspiring the next generation.',
            'Gospel Singer' => 'Spiritual vocalist uplifting hearts through song.',
            'Barber' => 'Grooming artist perfecting style and confidence.',
            'Bartender' => 'Mixology expert crafting liquid experiences.',
            'Musician' => 'Multi-talented musician creating sonic magic.',
            'Film Producer' => 'Cinema visionary bringing stories to screens.',
            'Scriptwriter' => 'Narrative craftsman weaving compelling stories.',
            'Teacher' => 'Dedicated educator shaping future generations.',
            'TV/Radio Host' => 'Media personality entertaining and informing audiences.',
            'Hair Stylist' => 'Beauty artist transforming looks and confidence.',
            'Drone Pilot' => 'Aerial photographer capturing unique perspectives.',
            'Kanta i entretene' => 'Local entertainer celebrating island culture.',
            'Worshiper' => 'Worship leader guiding spiritual musical journeys.',
            'Coach' => 'Personal development guide empowering others.',
            'Circus' => 'Circus performer amazingaudiences with artistry.',
            'Writer' => 'Literary creator crafting words into worlds.',
            'Poet' => 'Verse artist painting emotions with language.'
        ];

        return $templates[$primaryStyle] ?? 'Creative professional passionate about artistic expression.';
    }

    private function generateAboutMe(string $name, string $artStyle): string
    {
        $styles = explode(',', $artStyle);
        $styleList = implode(', ', array_map('trim', $styles));

        return "Meet {$name}, a talented creative professional specializing in {$styleList}. With a passion for artistic expression and a dedication to their craft, {$name} brings unique energy and creativity to every project. Based in Curaçao, they are committed to contributing to the local creative scene and collaborating with fellow artists to create meaningful and inspiring work.";
    }

    private function normalizeUrl(string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Add https:// if no protocol specified
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        return $url;
    }

    private function normalizeInstagramUrl(string $handle): ?string
    {
        if (empty($handle)) {
            return null;
        }

        // Remove @ if present
        $handle = ltrim($handle, '@');

        // If it's already a full URL, return as is
        if (strpos($handle, 'instagram.com') !== false) {
            return $this->normalizeUrl($handle);
        }

        // Create Instagram URL
        return 'https://instagram.com/' . $handle;
    }

    private function assignTalentCategories(CreatorProfile $creatorProfile, string $artStyle): void
    {
        if (empty($artStyle)) {
            return;
        }

        // Parse multiple categories
        $styles = explode(',', $artStyle);
        $categoryIds = [];

        foreach ($styles as $style) {
            $style = trim($style);
            if (empty($style)) {
                continue;
            }

            // Map CSV art styles to database categories
            $categoryMapping = [
                'Singer' => 'Singer',
                'Songwriter' => 'Songwriter',
                'Komedia' => 'Komedia',
                'Drama' => 'Drama',
                'Cinematographer' => 'Cinematographer',
                'Director' => 'Director',
                'Dance group' => 'Dance group',
                'Drummer' => 'Drummer',
                'Designer' => 'Designer',
                'Desigener' => 'Designer', // Handle typo
                'Actor' => 'Actor',
                'Dj' => 'Dj',
                'DJ' => 'Dj',
                'Editor' => 'Editor',
                'Influencer' => 'Influencer',
                'Influincer' => 'Influencer', // Handle typo
                'Dancer' => 'Dancer',
                'Pianist' => 'Pianist',
                'Content creator' => 'Content creator',
                'Diseñado di moda' => 'Diseñado di moda',
                'Deseñado di moda' => 'Diseñado di moda', // Handle variation
                'Model' => 'Model',
                'Tattoo artist' => 'Tattoo artist',
                'Digital creator' => 'Digital creator',
                'Comedian' => 'Comedian',
                'Rapper' => 'Rapper',
                'Producer' => 'Producer',
                'Radio Host' => 'Radio Host',
                'Ambassador' => 'Ambassador',
                'MC' => 'MC',
                'Marketing Agency' => 'Marketing Agency',
                'Dance Teacher' => 'Dance Teacher',
                'Gospel Singer' => 'Gospel Singer',
                'Barber' => 'Barber',
                'Bartender' => 'Bartender',
                'Musician' => 'Musician',
                'Film Producer' => 'Film Producer',
                'Scriptwriter' => 'Scriptwriter',
                'Teacher' => 'Teacher',
                'TV/Radio Host' => 'TV/Radio Host',
                'Hair Stylist' => 'Hair Stylist',
                'Drone Pilot' => 'Drone Pilot',
                'Kanta i entretene' => 'Kanta i entretene',
                'Worshiper' => 'Worshiper',
                'Coach' => 'Coach',
                'Circus' => 'Circus',
                'Writer' => 'Writer',
                'Poet' => 'Poet'
            ];

            $categoryName = $categoryMapping[$style] ?? null;
            if ($categoryName) {
                $category = TalentCategory::where('name', $categoryName)->first();
                if ($category) {
                    $categoryIds[] = $category->id;
                }
            }
        }

        // Attach categories to creator
        if (!empty($categoryIds)) {
            $creatorProfile->talentCategories()->attach(array_unique($categoryIds));
        }
    }
}
