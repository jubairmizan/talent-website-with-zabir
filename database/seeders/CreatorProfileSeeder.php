<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CreatorProfile;
use App\Models\User;

class CreatorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some creator users if they don't exist
        $this->createCreatorUsersIfNeeded();

        $creatorUsers = User::where('role', 'creator')->get();

        if ($creatorUsers->isEmpty()) {
            $this->command->warn('No creator users found. Creating sample creator users.');
            return;
        }

        $creatorProfiles = [
            [
                'short_bio' => 'Award-winning graphic designer with 8+ years of experience in branding and visual identity.',
                'about_me' => 'I am a passionate graphic designer who specializes in creating memorable brand identities and visual experiences. With over 8 years in the industry, I have worked with startups, Fortune 500 companies, and everything in between. My approach combines strategic thinking with creative execution to deliver designs that not only look great but also drive business results. I believe that great design should tell a story and connect with people on an emotional level.',
                'banner_image' => 'banners/creator-banner-1.jpg',
                'resume_cv' => 'resumes/john-designer-cv.pdf',
                'website_url' => 'https://johndesigner.com',
                'facebook_url' => 'https://facebook.com/johndesigner',
                'instagram_url' => 'https://instagram.com/johndesigner',
                'twitter_url' => 'https://twitter.com/johndesigner',
                'linkedin_url' => 'https://linkedin.com/in/johndesigner',
                'youtube_url' => null,
                'tiktok_url' => null,
                'is_featured' => true,
                'profile_views' => rand(1000, 5000),
                'total_likes' => rand(200, 800),
            ],
            [
                'short_bio' => 'Full-stack developer and UI/UX designer creating beautiful, functional web applications.',
                'about_me' => 'I am a versatile full-stack developer with a strong eye for design. I love building web applications that are not only technically sound but also provide exceptional user experiences. My expertise spans from front-end technologies like React and Vue.js to back-end development with Node.js and Python. I also have a passion for UI/UX design, which allows me to create cohesive digital products from concept to deployment.',
                'banner_image' => 'banners/creator-banner-2.jpg',
                'resume_cv' => 'resumes/sarah-developer-cv.pdf',
                'website_url' => 'https://sarahcodes.dev',
                'facebook_url' => null,
                'instagram_url' => 'https://instagram.com/sarahcodes',
                'twitter_url' => 'https://twitter.com/sarahcodes',
                'linkedin_url' => 'https://linkedin.com/in/sarahcodes',
                'youtube_url' => 'https://youtube.com/c/sarahcodes',
                'tiktok_url' => null,
                'is_featured' => true,
                'profile_views' => rand(800, 3000),
                'total_likes' => rand(150, 600),
            ],
            [
                'short_bio' => 'Professional photographer specializing in portraits, events, and commercial photography.',
                'about_me' => 'Photography has been my passion for over 10 years. I specialize in capturing authentic moments and creating stunning visual narratives. Whether it\'s a corporate headshot, a wedding celebration, or a product shoot, I bring creativity and professionalism to every project. My goal is to tell your story through compelling imagery that resonates with your audience and stands the test of time.',
                'banner_image' => 'banners/creator-banner-3.jpg',
                'resume_cv' => 'resumes/mike-photographer-cv.pdf',
                'website_url' => 'https://mikephotography.com',
                'facebook_url' => 'https://facebook.com/mikephotography',
                'instagram_url' => 'https://instagram.com/mikephotography',
                'twitter_url' => null,
                'linkedin_url' => 'https://linkedin.com/in/mikephotographer',
                'youtube_url' => null,
                'tiktok_url' => 'https://tiktok.com/@mikephotography',
                'is_featured' => false,
                'profile_views' => rand(500, 2000),
                'total_likes' => rand(100, 400),
            ],
            [
                'short_bio' => 'Creative video producer and motion graphics artist with expertise in storytelling.',
                'about_me' => 'I am a creative video producer who believes in the power of visual storytelling. With expertise in cinematography, editing, and motion graphics, I create compelling video content that engages audiences and drives action. From corporate videos to social media content, I work closely with clients to bring their vision to life through dynamic and impactful video production.',
                'banner_image' => 'banners/creator-banner-4.jpg',
                'resume_cv' => 'resumes/emma-video-cv.pdf',
                'website_url' => 'https://emmavideo.com',
                'facebook_url' => null,
                'instagram_url' => 'https://instagram.com/emmavideo',
                'twitter_url' => 'https://twitter.com/emmavideo',
                'linkedin_url' => 'https://linkedin.com/in/emmavideo',
                'youtube_url' => 'https://youtube.com/c/emmavideo',
                'tiktok_url' => 'https://tiktok.com/@emmavideo',
                'is_featured' => true,
                'profile_views' => rand(1200, 4000),
                'total_likes' => rand(250, 700),
            ],
            [
                'short_bio' => 'Freelance writer and content strategist helping brands tell their stories effectively.',
                'about_me' => 'Words have the power to inspire, inform, and influence. As a freelance writer and content strategist, I help businesses communicate their message clearly and effectively. My expertise includes blog writing, copywriting, content marketing, and brand storytelling. I work with clients across various industries to create content that not only engages their audience but also drives measurable results.',
                'banner_image' => 'banners/creator-banner-5.jpg',
                'resume_cv' => 'resumes/alex-writer-cv.pdf',
                'website_url' => 'https://alexwrites.com',
                'facebook_url' => 'https://facebook.com/alexwrites',
                'instagram_url' => null,
                'twitter_url' => 'https://twitter.com/alexwrites',
                'linkedin_url' => 'https://linkedin.com/in/alexwrites',
                'youtube_url' => null,
                'tiktok_url' => null,
                'is_featured' => false,
                'profile_views' => rand(300, 1500),
                'total_likes' => rand(80, 300),
            ],
        ];

        foreach ($creatorProfiles as $index => $profile) {
            if (isset($creatorUsers[$index])) {
                CreatorProfile::create(array_merge($profile, [
                    'user_id' => $creatorUsers[$index]->id,
                    'is_active' => true,
                ]));
            }
        }

        $this->command->info('Creator profiles seeded successfully!');
    }

    private function createCreatorUsersIfNeeded(): void
    {
        $creatorUsers = [
            [
                'name' => 'John Designer',
                'email' => 'john.designer@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ],
            [
                'name' => 'Sarah Developer',
                'email' => 'sarah.developer@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ],
            [
                'name' => 'Mike Photographer',
                'email' => 'mike.photographer@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ],
            [
                'name' => 'Emma Video Producer',
                'email' => 'emma.video@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ],
            [
                'name' => 'Alex Writer',
                'email' => 'alex.writer@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ],
        ];

        foreach ($creatorUsers as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
    }
}