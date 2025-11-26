<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HomepageSettings;
use App\Models\HomepageSlide;

class HomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create homepage settings
        HomepageSettings::create([
            'hero_title' => 'ONTDEK CREATORS OP CURAÇAO',
            'hero_subtitle' => 'Jouw brug naar lokaal talent',
            'hero_video_url' => 'https://brugkreativo.com/images/home-video.mp4',
            'search_placeholder_text' => 'Zoek hier naar creators...',
            'is_active' => true,
        ]);

        // Create background slides with the current images from home.blade.php
        $slides = [
            [
                'image_path' => 'images/1.jpeg', // Local image
                'order' => 1,
                'is_active' => true,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=1920&h=1080&fit=crop',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=1920&h=1080&fit=crop',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'image_path' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=1920&h=1080&fit=crop',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            HomepageSlide::create($slide);
        }
    }
}
