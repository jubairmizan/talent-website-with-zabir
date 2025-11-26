<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users and blog categories
        $this->createUsersIfNeeded();
        
        $users = User::all();
        $categories = BlogCategory::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run user seeder first.');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->warn('No blog categories found. Please run blog category seeder first.');
            return;
        }

        $blogPosts = [
            [
                'title' => '10 Design Trends That Will Dominate 2025',
                'excerpt' => 'Explore the cutting-edge design trends that are shaping the creative landscape this year.',
                'content' => $this->getDesignTrendsContent(),
                'featured_image' => 'blog/images/design-trends-2025.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views_count' => rand(500, 2000),
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'The Complete Guide to Freelancing as a Creative',
                'excerpt' => 'Everything you need to know about starting and growing your freelance creative business.',
                'content' => $this->getFreelancingGuideContent(),
                'featured_image' => 'blog/images/freelancing-guide.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views_count' => rand(300, 1500),
                'published_at' => Carbon::now()->subDays(rand(1, 20)),
            ],
            [
                'title' => 'Mastering Color Theory in Digital Design',
                'excerpt' => 'Learn how to use color effectively in your digital designs to create emotional impact.',
                'content' => $this->getColorTheoryContent(),
                'featured_image' => 'blog/images/color-theory.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => rand(200, 800),
                'published_at' => Carbon::now()->subDays(rand(5, 25)),
            ],
            [
                'title' => 'Building Your First React Application: A Beginner\'s Guide',
                'excerpt' => 'Step-by-step tutorial for creating your first React application from scratch.',
                'content' => $this->getReactTutorialContent(),
                'featured_image' => 'blog/images/react-tutorial.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => rand(400, 1200),
                'published_at' => Carbon::now()->subDays(rand(3, 15)),
            ],
            [
                'title' => 'The Art of Client Communication',
                'excerpt' => 'Essential tips for maintaining professional relationships and clear communication with clients.',
                'content' => $this->getClientCommunicationContent(),
                'featured_image' => 'blog/images/client-communication.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => rand(150, 600),
                'published_at' => Carbon::now()->subDays(rand(7, 20)),
            ],
            [
                'title' => 'Top 15 Design Tools Every Creative Should Know',
                'excerpt' => 'A comprehensive review of the best design tools and software for modern creatives.',
                'content' => $this->getDesignToolsContent(),
                'featured_image' => 'blog/images/design-tools.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views_count' => rand(600, 2500),
                'published_at' => Carbon::now()->subDays(rand(2, 12)),
            ],
            [
                'title' => 'Creating Compelling Video Content on a Budget',
                'excerpt' => 'Learn how to produce high-quality video content without breaking the bank.',
                'content' => $this->getVideoContentContent(),
                'featured_image' => 'blog/images/video-budget.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views_count' => rand(250, 900),
                'published_at' => Carbon::now()->subDays(rand(4, 18)),
            ],
            [
                'title' => 'The Future of Web Development: Trends to Watch',
                'excerpt' => 'Explore emerging technologies and trends that are shaping the future of web development.',
                'content' => $this->getWebDevFutureContent(),
                'featured_image' => 'blog/images/web-dev-future.jpg',
                'status' => 'draft',
                'is_featured' => false,
                'views_count' => 0,
                'published_at' => null,
            ],
        ];

        foreach ($blogPosts as $index => $post) {
            // Assign random author and category
            $author = $users->random();
            $category = $categories->random();

            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => $post['featured_image'],
                'author_id' => $author->id,
                'blog_category_id' => $category->id,
                'status' => $post['status'],
                'is_featured' => $post['is_featured'],
                'views_count' => $post['views_count'],
                'published_at' => $post['published_at'],
            ]);
        }

        $this->command->info('Blog posts seeded successfully!');
    }

    private function createUsersIfNeeded(): void
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'status' => 'active',
            ]);

            User::create([
                'name' => 'Content Writer',
                'email' => 'writer@example.com',
                'password' => bcrypt('password'),
                'role' => 'creator',
                'status' => 'active',
            ]);
        }
    }

    private function getDesignTrendsContent(): string
    {
        return '<p>Design trends are constantly evolving, and 2025 promises to bring some exciting new directions for creative professionals. Here are the top 10 trends that will shape the design landscape this year.</p>

<h2>1. Sustainable Design</h2>
<p>Environmental consciousness is driving design decisions, with creators focusing on sustainable materials and eco-friendly practices.</p>

<h2>2. Minimalist Maximalism</h2>
<p>The perfect balance between clean minimalism and bold, expressive elements creates visually striking designs.</p>

<h2>3. AI-Assisted Creativity</h2>
<p>Artificial intelligence tools are becoming integral to the creative process, enhancing rather than replacing human creativity.</p>

<p>Stay ahead of the curve by incorporating these trends into your design work while maintaining your unique creative voice.</p>';
    }

    private function getFreelancingGuideContent(): string
    {
        return '<p>Starting a freelance creative business can be both exciting and challenging. This comprehensive guide will help you navigate the journey from beginner to successful freelancer.</p>

<h2>Getting Started</h2>
<p>Before diving into freelancing, it\'s essential to assess your skills, define your niche, and understand the market demand for your services.</p>

<h2>Building Your Portfolio</h2>
<p>A strong portfolio is your most powerful marketing tool. Showcase your best work and demonstrate your range of capabilities.</p>

<h2>Finding Clients</h2>
<p>Learn effective strategies for finding and attracting your ideal clients, from networking to online platforms.</p>

<h2>Pricing Your Services</h2>
<p>Understand how to price your work competitively while ensuring you\'re fairly compensated for your time and expertise.</p>';
    }

    private function getColorTheoryContent(): string
    {
        return '<p>Color is one of the most powerful tools in a designer\'s arsenal. Understanding color theory can dramatically improve the impact and effectiveness of your digital designs.</p>

<h2>The Color Wheel</h2>
<p>Master the basics of primary, secondary, and tertiary colors, and learn how they relate to each other.</p>

<h2>Color Harmony</h2>
<p>Explore different color schemes like complementary, analogous, and triadic combinations.</p>

<h2>Psychological Impact</h2>
<p>Understand how different colors evoke emotions and influence user behavior in digital interfaces.</p>

<h2>Practical Applications</h2>
<p>Learn how to apply color theory principles in real-world design projects for maximum impact.</p>';
    }

    private function getReactTutorialContent(): string
    {
        return '<p>React is one of the most popular JavaScript libraries for building user interfaces. This tutorial will guide you through creating your first React application.</p>

<h2>Setting Up Your Environment</h2>
<p>Learn how to install Node.js, npm, and create your first React project using Create React App.</p>

<h2>Understanding Components</h2>
<p>Discover the building blocks of React applications and how to create reusable components.</p>

<h2>State and Props</h2>
<p>Master the concepts of state management and data flow between components.</p>

<h2>Building Your First App</h2>
<p>Follow along as we build a simple but functional React application from start to finish.</p>';
    }

    private function getClientCommunicationContent(): string
    {
        return '<p>Effective client communication is crucial for project success and long-term business relationships. Here are essential strategies for professional communication.</p>

<h2>Setting Expectations</h2>
<p>Clear communication from the start prevents misunderstandings and ensures project success.</p>

<h2>Regular Updates</h2>
<p>Keep clients informed about project progress and any potential challenges or changes.</p>

<h2>Handling Feedback</h2>
<p>Learn how to receive and implement client feedback constructively and professionally.</p>

<h2>Managing Difficult Situations</h2>
<p>Strategies for handling challenging clients and resolving conflicts diplomatically.</p>';
    }

    private function getDesignToolsContent(): string
    {
        return '<p>The right tools can significantly enhance your creative workflow and output quality. Here\'s a comprehensive review of the top design tools every creative professional should consider.</p>

<h2>Design Software</h2>
<p>From Adobe Creative Suite to Figma and Sketch, explore the best software for different design disciplines.</p>

<h2>Collaboration Tools</h2>
<p>Discover platforms that facilitate seamless collaboration with clients and team members.</p>

<h2>Productivity Apps</h2>
<p>Time management and project organization tools that help streamline your workflow.</p>

<h2>Free Alternatives</h2>
<p>Budget-friendly options that don\'t compromise on quality or functionality.</p>';
    }

    private function getVideoContentContent(): string
    {
        return '<p>Creating high-quality video content doesn\'t have to cost a fortune. With the right techniques and tools, you can produce compelling videos on any budget.</p>

<h2>Planning Your Content</h2>
<p>Effective pre-production planning is key to creating successful video content within budget constraints.</p>

<h2>Equipment Essentials</h2>
<p>Learn about affordable equipment options that deliver professional results.</p>

<h2>Lighting on a Budget</h2>
<p>Creative lighting solutions using natural light and inexpensive equipment.</p>

<h2>Post-Production Tips</h2>
<p>Editing techniques and free software options for polishing your video content.</p>';
    }

    private function getWebDevFutureContent(): string
    {
        return '<p>The web development landscape is constantly evolving. Stay ahead of the curve by understanding the trends and technologies that will shape the future of web development.</p>

<h2>Emerging Technologies</h2>
<p>Explore new frameworks, libraries, and tools that are gaining traction in the development community.</p>

<h2>Performance Optimization</h2>
<p>Learn about new techniques for creating faster, more efficient web applications.</p>

<h2>User Experience Evolution</h2>
<p>Understand how user expectations are changing and how to adapt your development approach.</p>

<h2>Career Implications</h2>
<p>What these trends mean for web developers and how to prepare for the future job market.</p>';
    }
}