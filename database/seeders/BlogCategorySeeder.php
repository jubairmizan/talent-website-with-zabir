<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Design Trends',
                'description' => 'Latest trends and innovations in graphic design, web design, and visual arts.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Technology',
                'description' => 'Updates on web development, programming languages, frameworks, and tech industry news.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Creative Process',
                'description' => 'Insights into the creative workflow, inspiration, and artistic methodologies.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Business Tips',
                'description' => 'Entrepreneurship advice, freelancing tips, and business strategies for creatives.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Tutorials',
                'description' => 'Step-by-step guides and how-to articles for various creative skills and tools.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Industry News',
                'description' => 'Latest news and updates from the creative and technology industries.',
                'sort_order' => 6,
            ],
            [
                'name' => 'Portfolio Showcase',
                'description' => 'Featured work and case studies from talented creators and designers.',
                'sort_order' => 7,
            ],
            [
                'name' => 'Tools & Resources',
                'description' => 'Reviews and recommendations for design tools, software, and creative resources.',
                'sort_order' => 8,
            ],
            [
                'name' => 'Career Development',
                'description' => 'Professional growth, skill development, and career advice for creatives.',
                'sort_order' => 9,
            ],
            [
                'name' => 'Client Relations',
                'description' => 'Tips for managing client relationships, communication, and project management.',
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Blog categories seeded successfully!');
    }
}