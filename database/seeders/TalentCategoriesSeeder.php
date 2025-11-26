<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TalentCategory;
use Illuminate\Support\Str;

class TalentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing talent categories
        TalentCategory::query()->delete();

        // New talent categories provided by user
        $categories = [
            'Singer',
            'Songwriter',
            'Komedia',
            'Drama',
            'Cinematographer',
            'Director',
            'Dance group',
            'Drummer',
            'Designer',
            'Actor',
            'Dj',
            'Editor',
            'Influencer',
            'Dancer',
            'Pianist',
            'Content creator',
            'Diseñado di moda',
            'Model',
            'Tattoo artist',
            'Digital creator',
            'Comedian',
            'Rapper',
            'Producer',
            'Radio Host',
            'Ambassador',
            'MC',
            'Marketing Agency',
            'Dance Teacher',
            'Gospel Singer',
            'Barber',
            'Bartender',
            'Musician',
            'Film Producer',
            'Scriptwriter',
            'Teacher',
            'TV/Radio Host',
            'Hair Stylist',
            'Drone Pilot',
            'Kanta i entretene',
            'Worshiper',
            'Coach',
            'Circus',
            'Writer',
            'Poet'
        ];

        $createdCategories = [];
        foreach ($categories as $index => $categoryName) {
            $category = TalentCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => $this->getCategoryDescription($categoryName),
                'icon' => $this->getCategoryIcon($categoryName),
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);

            $createdCategories[] = $category;
            $this->command->info("Created talent category: {$category->name}");
        }

        $this->command->info('Talent categories seeder completed successfully!');
        $this->command->info('Total categories created: ' . count($createdCategories));
    }

    private function getCategoryDescription(string $categoryName): string
    {
        $descriptions = [
            'Singer' => 'Professional vocal artists and performers',
            'Songwriter' => 'Creative writers and composers of music',
            'Komedia' => 'Comedy performers and entertainers',
            'Drama' => 'Theatrical and dramatic performers',
            'Cinematographer' => 'Film and video camera operators',
            'Director' => 'Film and video production directors',
            'Dance group' => 'Collective dance performers and troupes',
            'Drummer' => 'Percussionists and rhythm specialists',
            'Designer' => 'Creative designers across various mediums',
            'Actor' => 'Professional acting and performance artists',
            'Dj' => 'Disc jockeys and music selectors',
            'Editor' => 'Video, film, and content editors',
            'Influencer' => 'Social media content creators and influencers',
            'Dancer' => 'Professional dancers and choreographers',
            'Pianist' => 'Piano players and keyboard musicians',
            'Content creator' => 'Digital content producers and creators',
            'Diseñado di moda' => 'Fashion designers and stylists',
            'Model' => 'Professional models and fashion models',
            'Tattoo artist' => 'Body art and tattoo designers',
            'Digital creator' => 'Digital art and content creators',
            'Comedian' => 'Stand-up and comedy performers',
            'Rapper' => 'Rap and hip-hop artists',
            'Producer' => 'Music and content producers',
            'Radio Host' => 'Radio show hosts and presenters',
            'Ambassador' => 'Brand ambassadors and representatives',
            'MC' => 'Master of ceremonies and event hosts',
            'Marketing Agency' => 'Marketing and advertising agencies',
            'Dance Teacher' => 'Dance instructors and educators',
            'Gospel Singer' => 'Gospel and religious music performers',
            'Barber' => 'Hair cutting and styling professionals',
            'Bartender' => 'Mixologists and beverage specialists',
            'Musician' => 'Instrumental musicians and performers',
            'Film Producer' => 'Film and video production executives',
            'Scriptwriter' => 'Screenplay and script writers',
            'Teacher' => 'Educators and instructors',
            'TV/Radio Host' => 'Television and radio presenters',
            'Hair Stylist' => 'Hair styling and beauty professionals',
            'Drone Pilot' => 'Drone operators and aerial photographers',
            'Kanta i entretene' => 'Local entertainment and performance artists',
            'Worshiper' => 'Religious and worship music performers',
            'Coach' => 'Personal coaches and mentors',
            'Circus' => 'Circus performers and entertainers',
            'Writer' => 'Authors and written content creators',
            'Poet' => 'Poets and spoken word artists',
        ];

        return $descriptions[$categoryName] ?? 'Creative professional in the entertainment industry';
    }

    private function getCategoryIcon(string $categoryName): string
    {
        $icons = [
            'Singer' => 'mic',
            'Songwriter' => 'music',
            'Komedia' => 'smile',
            'Drama' => 'theater',
            'Cinematographer' => 'camera',
            'Director' => 'film',
            'Dance group' => 'users',
            'Drummer' => 'drumstick',
            'Designer' => 'palette',
            'Actor' => 'user',
            'Dj' => 'headphones',
            'Editor' => 'edit',
            'Influencer' => 'instagram',
            'Dancer' => 'dance',
            'Pianist' => 'piano',
            'Content creator' => 'video',
            'Diseñado di moda' => 'shirt',
            'Model' => 'user-check',
            'Tattoo artist' => 'pen-tool',
            'Digital creator' => 'monitor',
            'Comedian' => 'laugh',
            'Rapper' => 'mic2',
            'Producer' => 'settings',
            'Radio Host' => 'radio',
            'Ambassador' => 'star',
            'MC' => 'mic',
            'Marketing Agency' => 'briefcase',
            'Dance Teacher' => 'graduation-cap',
            'Gospel Singer' => 'heart',
            'Barber' => 'scissors',
            'Bartender' => 'cocktail',
            'Musician' => 'music',
            'Film Producer' => 'film',
            'Scriptwriter' => 'file-text',
            'Teacher' => 'book-open',
            'TV/Radio Host' => 'tv',
            'Hair Stylist' => 'scissors',
            'Drone Pilot' => 'drone',
            'Kanta i entretene' => 'music',
            'Worshiper' => 'heart',
            'Coach' => 'target',
            'Circus' => 'circus',
            'Writer' => 'pen',
            'Poet' => 'book',
        ];

        return $icons[$categoryName] ?? 'user';
    }
}
