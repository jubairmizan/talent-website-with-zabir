<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TalentCategory;
use Illuminate\Support\Str;

class TalentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Graphic Design',
                'description' => 'Visual communication through typography, imagery, color and form. Includes logo design, branding, print design, and digital graphics.',
                'icon' => 'fas fa-palette',
                'sort_order' => 1,
            ],
            [
                'name' => 'Web Development',
                'description' => 'Building and maintaining websites and web applications using various programming languages and frameworks.',
                'icon' => 'fas fa-code',
                'sort_order' => 2,
            ],
            [
                'name' => 'Video Production',
                'description' => 'Creating video content including filming, editing, motion graphics, and post-production services.',
                'icon' => 'fas fa-video',
                'sort_order' => 3,
            ],
            [
                'name' => 'Photography',
                'description' => 'Professional photography services including portraits, events, products, and commercial photography.',
                'icon' => 'fas fa-camera',
                'sort_order' => 4,
            ],
            [
                'name' => 'Writing & Content',
                'description' => 'Content creation including copywriting, blog posts, articles, technical writing, and creative writing.',
                'icon' => 'fas fa-pen',
                'sort_order' => 5,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Online marketing strategies including SEO, social media marketing, email campaigns, and digital advertising.',
                'icon' => 'fas fa-bullhorn',
                'sort_order' => 6,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'User interface and user experience design for websites, mobile apps, and digital products.',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 7,
            ],
            [
                'name' => 'Animation',
                'description' => '2D and 3D animation, motion graphics, character animation, and visual effects.',
                'icon' => 'fas fa-play-circle',
                'sort_order' => 8,
            ],
            [
                'name' => 'Music & Audio',
                'description' => 'Music production, audio editing, sound design, voiceovers, and podcast production.',
                'icon' => 'fas fa-music',
                'sort_order' => 9,
            ],
            [
                'name' => 'Illustration',
                'description' => 'Digital and traditional illustration including character design, book illustrations, and concept art.',
                'icon' => 'fas fa-paint-brush',
                'sort_order' => 10,
            ],
            [
                'name' => 'Translation',
                'description' => 'Language translation services for documents, websites, and multimedia content.',
                'icon' => 'fas fa-language',
                'sort_order' => 11,
            ],
            [
                'name' => 'Voice Acting',
                'description' => 'Professional voice-over services for commercials, animations, audiobooks, and presentations.',
                'icon' => 'fas fa-microphone',
                'sort_order' => 12,
            ],
            [
                'name' => 'Data Analysis',
                'description' => 'Data visualization, statistical analysis, business intelligence, and data science services.',
                'icon' => 'fas fa-chart-bar',
                'sort_order' => 13,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'iOS and Android app development, cross-platform solutions, and mobile app design.',
                'icon' => 'fas fa-mobile',
                'sort_order' => 14,
            ],
            [
                'name' => 'Social Media Management',
                'description' => 'Social media strategy, content creation, community management, and social media advertising.',
                'icon' => 'fas fa-share-alt',
                'sort_order' => 15,
            ],
        ];

        foreach ($categories as $category) {
            TalentCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Talent categories seeded successfully!');
    }
}