<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ComprehensiveBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create blog categories
        $categories = $this->createBlogCategories();

        // Get admin user
        $adminUser = User::where('email', 'admin@admin.com')->first() ?? User::first();

        if (!$adminUser) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        // Create blog posts with downloaded images
        $this->createBlogPosts($categories, $adminUser);

        $this->command->info('Blog seeder completed successfully!');
    }

    private function createBlogCategories(): array
    {
        $categoriesData = [
            [
                'name' => 'Creative Arts & Design',
                'slug' => 'creative-arts-design',
                'description' => 'Explore the world of creativity, design trends, and artistic expression.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Photography & Visual Arts',
                'slug' => 'photography-visual-arts',
                'description' => 'Discover photography techniques, visual storytelling, and digital art.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Music & Performance',
                'slug' => 'music-performance',
                'description' => 'Learn about music creation, performance techniques, and industry insights.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Writing & Content Creation',
                'slug' => 'writing-content-creation',
                'description' => 'Tips and strategies for writers, bloggers, and content creators.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Technology & Innovation',
                'slug' => 'technology-innovation',
                'description' => 'Stay updated with the latest technology trends affecting creative industries.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Business & Entrepreneurship',
                'slug' => 'business-entrepreneurship',
                'description' => 'Build your creative business and entrepreneurial skills.',
                'is_active' => true,
                'sort_order' => 6,
            ]
        ];

        $createdCategories = [];
        foreach ($categoriesData as $categoryData) {
            $category = BlogCategory::create($categoryData);
            $createdCategories[] = $category;
            $this->command->info("Created category: {$category->name}");
        }

        return $createdCategories;
    }

    private function createBlogPosts(array $categories, User $adminUser): void
    {
        $blogPostsData = [
            [
                'title' => 'The Future of Digital Art: AI and Creative Expression',
                'excerpt' => 'Exploring how artificial intelligence is revolutionizing the way artists create and express themselves in the digital age.',
                'content' => $this->getArtContent(),
                'category' => 'creative-arts-design',
                'image_url' => 'https://images.unsplash.com/photo-1561736778-92e52a7769ef?w=800&h=600&fit=crop',
                'image_name' => 'digital-art-ai.jpg',
                'is_featured' => true,
            ],
            [
                'title' => 'Mastering Portrait Photography: Tips from the Pros',
                'excerpt' => 'Learn professional techniques for capturing stunning portraits that tell a story and connect with viewers.',
                'content' => $this->getPhotographyContent(),
                'category' => 'photography-visual-arts',
                'image_url' => 'https://images.unsplash.com/photo-1554048612-b6a482b224d1?w=800&h=600&fit=crop',
                'image_name' => 'portrait-photography.jpg',
                'is_featured' => true,
            ],
            [
                'title' => 'Building Your Music Brand in the Digital Age',
                'excerpt' => 'Essential strategies for musicians to build their brand and reach audiences through digital platforms.',
                'content' => $this->getMusicContent(),
                'category' => 'music-performance',
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop',
                'image_name' => 'music-branding.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'Content Writing That Converts: A Complete Guide',
                'excerpt' => 'Master the art of persuasive writing that engages readers and drives action across all platforms.',
                'content' => $this->getWritingContent(),
                'category' => 'writing-content-creation',
                'image_url' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=800&h=600&fit=crop',
                'image_name' => 'content-writing.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'Emerging Technologies Reshaping Creative Industries',
                'excerpt' => 'Discover how VR, AR, and blockchain technologies are transforming creative workflows and opportunities.',
                'content' => $this->getTechnologyContent(),
                'category' => 'technology-innovation',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=800&h=600&fit=crop',
                'image_name' => 'emerging-tech.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'From Passion to Profit: Monetizing Your Creative Skills',
                'excerpt' => 'Transform your creative talents into sustainable income streams with proven business strategies.',
                'content' => $this->getBusinessContent(),
                'category' => 'business-entrepreneurship',
                'image_url' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?w=800&h=600&fit=crop',
                'image_name' => 'creative-business.jpg',
                'is_featured' => true,
            ],
            [
                'title' => 'Color Theory for Digital Designers: Beyond the Basics',
                'excerpt' => 'Deep dive into advanced color theory concepts that will elevate your digital design work.',
                'content' => $this->getColorTheoryContent(),
                'category' => 'creative-arts-design',
                'image_url' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&h=600&fit=crop',
                'image_name' => 'color-theory.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'Street Photography: Capturing Life in Motion',
                'excerpt' => 'Learn the art of street photography and how to capture authentic moments in urban environments.',
                'content' => $this->getStreetPhotographyContent(),
                'category' => 'photography-visual-arts',
                'image_url' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=800&h=600&fit=crop',
                'image_name' => 'street-photography.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'The Psychology of Music: How Sound Affects Emotion',
                'excerpt' => 'Explore the fascinating connection between music, psychology, and emotional response.',
                'content' => $this->getMusicPsychologyContent(),
                'category' => 'music-performance',
                'image_url' => 'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800&h=600&fit=crop',
                'image_name' => 'music-psychology.jpg',
                'is_featured' => false,
            ],
            [
                'title' => 'SEO for Content Creators: Getting Found Online',
                'excerpt' => 'Essential SEO strategies that help content creators increase their visibility and reach.',
                'content' => $this->getSEOContent(),
                'category' => 'writing-content-creation',
                'image_url' => 'https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=800&h=600&fit=crop',
                'image_name' => 'seo-content.jpg',
                'is_featured' => false,
            ]
        ];

        foreach ($blogPostsData as $postData) {
            $category = collect($categories)->firstWhere('slug', $postData['category']);

            if (!$category) {
                $this->command->warn("Category {$postData['category']} not found for post: {$postData['title']}");
                continue;
            }

            // Download and save image
            $imagePath = $this->downloadImage($postData['image_url'], $postData['image_name']);

            BlogPost::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'featured_image' => $imagePath,
                'author_id' => $adminUser->id,
                'blog_category_id' => $category->id,
                'status' => 'published',
                'is_featured' => $postData['is_featured'],
                'views_count' => rand(50, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);

            $this->command->info("Created blog post: {$postData['title']}");
        }
    }

    private function downloadImage(string $url, string $filename): string
    {
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $imagePath = 'blog/featured-images/' . $filename;
                Storage::disk('public')->put($imagePath, $response->body());
                $this->command->info("Downloaded image: {$filename}");
                return $imagePath;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download image {$filename}: " . $e->getMessage());
        }

        return 'blog/featured-images/placeholder.jpg';
    }

    private function getArtContent(): string
    {
        return '
        <p>The intersection of artificial intelligence and creative expression represents one of the most fascinating developments in contemporary art. As AI tools become increasingly sophisticated, artists are discovering new ways to push the boundaries of traditional creative processes.</p>

        <h3>The AI Creative Revolution</h3>
        <p>From neural networks that can generate stunning visual art to algorithms that compose music, AI is not replacing human creativity but rather amplifying it. Artists are learning to collaborate with machines, using AI as a sophisticated brush or instrument that responds to their creative vision.</p>

        <h3>Tools and Techniques</h3>
        <p>Popular AI art tools like DALL-E, Midjourney, and Stable Diffusion have democratized access to advanced image generation. Meanwhile, tools like RunwayML and Adobe\'s AI features are being integrated into traditional creative workflows, making AI assistance accessible to creators at all levels.</p>

        <h3>The Future Landscape</h3>
        <p>As we look ahead, the fusion of human creativity and artificial intelligence promises to unlock entirely new forms of artistic expression. The key is learning to harness these tools while maintaining the human touch that gives art its emotional resonance and cultural significance.</p>

        <p>The future belongs to artists who can seamlessly blend traditional skills with cutting-edge technology, creating works that neither human nor machine could produce alone.</p>
        ';
    }

    private function getPhotographyContent(): string
    {
        return '
        <p>Portrait photography is an art form that goes beyond simply capturing someone\'s likeness. It\'s about revealing personality, emotion, and story through careful composition, lighting, and connection with your subject.</p>

        <h3>Understanding Light</h3>
        <p>Light is the foundation of great portrait photography. Natural light from a window can create soft, flattering illumination, while dramatic artificial lighting can add mood and character. Learn to see how light falls on faces and use it to enhance your subject\'s best features.</p>

        <h3>Building Rapport</h3>
        <p>The best portraits happen when your subject feels comfortable and confident. Take time to connect with them, understand their personality, and help them relax in front of the camera. This emotional connection translates directly into more authentic and compelling images.</p>

        <h3>Technical Excellence</h3>
        <p>Master your camera settings: use wide apertures for shallow depth of field, focus precisely on the eyes, and consider your background carefully. The technical aspects should become second nature so you can focus on the creative and interpersonal elements.</p>

        <h3>Post-Processing Artistry</h3>
        <p>Great portraits often come to life in post-processing. Learn to enhance skin tones, adjust lighting, and add subtle effects that support your creative vision while maintaining a natural, authentic feel.</p>
        ';
    }

    private function getMusicContent(): string
    {
        return '
        <p>In today\'s digital landscape, musicians have unprecedented opportunities to build their brand and connect directly with audiences. Success requires more than just great music – it demands strategic thinking about brand identity and digital presence.</p>

        <h3>Defining Your Musical Identity</h3>
        <p>Your brand starts with understanding what makes your music unique. What emotions do you evoke? What stories do you tell? Your brand should authentically represent your artistic vision while appealing to your target audience.</p>

        <h3>Digital Platform Strategy</h3>
        <p>Each platform serves different purposes: Spotify for music discovery, Instagram for visual storytelling, TikTok for viral moments, and YouTube for long-form content. Develop platform-specific strategies that work together to build a cohesive brand presence.</p>

        <h3>Content Creation Beyond Music</h3>
        <p>Share your creative process, behind-the-scenes moments, and personal stories. Fans connect with authenticity, and showing the person behind the music creates deeper engagement than promotional content alone.</p>

        <h3>Building Community</h3>
        <p>Foster genuine relationships with your audience. Respond to comments, collaborate with other artists, and create experiences that make fans feel part of your journey. A engaged community becomes your most powerful marketing tool.</p>
        ';
    }

    private function getWritingContent(): string
    {
        return '
        <p>Effective content writing combines creativity with strategy, crafting messages that not only engage readers but also drive them to take action. Whether you\'re writing blog posts, sales copy, or social media content, certain principles remain constant.</p>

        <h3>Know Your Audience</h3>
        <p>Great writing starts with deep understanding of your readers. What are their pain points, desires, and motivations? Speak their language, address their concerns, and provide solutions to their problems. Every word should serve your reader\'s needs.</p>

        <h3>Structure for Success</h3>
        <p>Organize your content with clear headlines, subheadings, and logical flow. Use the AIDA framework (Attention, Interest, Desire, Action) or similar structures to guide readers from initial engagement to conversion.</p>

        <h3>The Power of Storytelling</h3>
        <p>Stories make abstract concepts concrete and emotional. Use case studies, personal anecdotes, and customer success stories to illustrate your points and create emotional connections with your readers.</p>

        <h3>Call-to-Action Mastery</h3>
        <p>Every piece of content should have a clear next step. Whether it\'s subscribing to a newsletter, downloading a resource, or making a purchase, make your calls-to-action specific, compelling, and easy to follow.</p>
        ';
    }

    private function getTechnologyContent(): string
    {
        return '
        <p>The creative industries are experiencing a technological revolution that\'s fundamentally changing how artists, designers, and content creators work. From virtual reality experiences to blockchain-based art marketplaces, new technologies are opening unprecedented opportunities.</p>

        <h3>Virtual and Augmented Reality</h3>
        <p>VR and AR technologies are creating entirely new mediums for creative expression. Artists can now create immersive experiences that transport viewers into their imagined worlds, while designers can prototype and test ideas in three-dimensional space.</p>

        <h3>Blockchain and NFTs</h3>
        <p>Despite market volatility, blockchain technology continues to offer new models for artists to monetize their work and connect directly with collectors. Smart contracts enable automatic royalty payments, while decentralized platforms reduce reliance on traditional gatekeepers.</p>

        <h3>AI-Powered Tools</h3>
        <p>Machine learning algorithms are becoming sophisticated creative partners. From AI-assisted photo editing to algorithmic music composition, these tools are augmenting human creativity rather than replacing it.</p>

        <h3>Cloud-Based Collaboration</h3>
        <p>Remote collaboration tools have revolutionized how creative teams work together. Real-time editing, version control, and seamless file sharing enable global teams to collaborate as if they were in the same room.</p>
        ';
    }

    private function getBusinessContent(): string
    {
        return '
        <p>Transforming creative passion into sustainable income requires both artistic vision and business acumen. Many talented creators struggle with the business side, but with the right strategies, you can build a thriving creative enterprise.</p>

        <h3>Diversifying Income Streams</h3>
        <p>Don\'t rely on a single source of income. Combine client work, product sales, teaching, licensing, and passive income streams. This diversification provides stability and reduces risk while maximizing your earning potential.</p>

        <h3>Pricing Your Worth</h3>
        <p>Many creatives undervalue their work. Research market rates, factor in all your costs including time, expertise, and overhead, then price accordingly. Remember, competing on price alone is a race to the bottom.</p>

        <h3>Building Systems and Processes</h3>
        <p>Systematize repetitive tasks to free up time for creative work. Use project management tools, create templates for common tasks, and automate wherever possible. Efficient systems allow you to scale without working more hours.</p>

        <h3>Marketing and Networking</h3>
        <p>Build genuine relationships within your industry. Attend events, collaborate with peers, and maintain an active online presence. Word-of-mouth referrals from satisfied clients and colleagues often provide the best business opportunities.</p>
        ';
    }

    private function getColorTheoryContent(): string
    {
        return '
        <p>Color is one of the most powerful tools in a designer\'s arsenal, capable of evoking emotions, creating hierarchy, and communicating brand values. Moving beyond basic color wheels, advanced color theory helps designers make more intentional and impactful choices.</p>

        <h3>Understanding Color Psychology</h3>
        <p>Different colors trigger different emotional and psychological responses. Red energizes and demands attention, blue instills trust and calm, while green suggests growth and nature. However, cultural context and personal associations also influence color perception.</p>

        <h3>Advanced Color Harmonies</h3>
        <p>Beyond complementary and analogous schemes, explore split-complementary, triadic, and tetradic relationships. These more complex harmonies can create sophisticated palettes that are both harmonious and dynamic.</p>

        <h3>Color in Digital Contexts</h3>
        <p>Digital design presents unique challenges: screens vary in color accuracy, ambient lighting affects perception, and accessibility requirements must be considered. Learn to design for these variables while maintaining visual impact.</p>

        <h3>Brand Color Strategy</h3>
        <p>Color choices should align with brand personality and target audience. A luxury brand might use sophisticated monochromes, while a children\'s product could embrace bright, playful hues. Consistency across all touchpoints reinforces brand recognition.</p>
        ';
    }

    private function getStreetPhotographyContent(): string
    {
        return '
        <p>Street photography captures the raw energy and authentic moments of urban life. It\'s a genre that requires technical skill, artistic vision, and the ability to anticipate and react to fleeting moments in busy environments.</p>

        <h3>Ethics and Legal Considerations</h3>
        <p>Understanding the legal and ethical aspects of street photography is crucial. Know your rights regarding public photography, respect people\'s privacy and dignity, and consider the impact of your images on subjects and communities.</p>

        <h3>Technical Mastery</h3>
        <p>Street photography demands quick reflexes and adaptability. Master manual focus, learn to work in various lighting conditions, and become comfortable with higher ISO settings. Your camera should become an extension of your vision.</p>

        <h3>Developing Your Eye</h3>
        <p>Great street photography is about seeing extraordinary moments in ordinary situations. Study the work of masters like Henri Cartier-Bresson and Vivian Maier, but develop your own perspective and style.</p>

        <h3>Patience and Persistence</h3>
        <p>The best street photographs often require patience. Learn to wait for the right moment, return to promising locations at different times, and be prepared to take hundreds of photos to get one great shot.</p>
        ';
    }

    private function getMusicPsychologyContent(): string
    {
        return '
        <p>Music has a profound impact on human psychology and emotion, influencing our moods, memories, and even physical responses. Understanding this connection can help musicians and composers create more impactful and meaningful work.</p>

        <h3>The Science of Musical Emotion</h3>
        <p>Research shows that music activates multiple brain regions simultaneously, triggering emotional responses through various mechanisms including expectation, memory association, and physiological entrainment with rhythm and melody.</p>

        <h3>Cultural and Personal Influences</h3>
        <p>Musical preferences and emotional responses are shaped by cultural background, personal experiences, and social context. What sounds joyful in one culture might have different connotations in another, highlighting the importance of understanding your audience.</p>

        <h3>Therapeutic Applications</h3>
        <p>Music therapy utilizes these psychological connections for healing and wellness. From reducing anxiety to improving cognitive function in dementia patients, music\'s therapeutic potential continues to be explored and documented.</p>

        <h3>Practical Applications for Musicians</h3>
        <p>Understanding music psychology can inform composition, performance, and production choices. Consider how tempo affects energy levels, how harmony creates tension and resolution, and how dynamics guide emotional arcs in your music.</p>
        ';
    }

    private function getSEOContent(): string
    {
        return '
        <p>Search engine optimization for content creators goes beyond keyword stuffing. Modern SEO requires creating valuable, user-focused content that naturally attracts both search engines and human readers.</p>

        <h3>Keyword Research and Intent</h3>
        <p>Understand what your audience is searching for and why. Use tools like Google Keyword Planner and Answer the Public to identify relevant topics and questions. Focus on search intent – are users looking for information, products, or solutions?</p>

        <h3>Content Structure and Optimization</h3>
        <p>Structure your content with clear headings, meta descriptions, and internal linking strategies. Write compelling titles that include your target keywords while remaining engaging for human readers.</p>

        <h3>Technical SEO Basics</h3>
        <p>Ensure your website loads quickly, is mobile-friendly, and has proper URL structure. These technical factors significantly impact search rankings and user experience.</p>

        <h3>Building Authority</h3>
        <p>Create comprehensive, expert-level content that other sites want to link to. Build relationships with other creators in your niche, guest post on relevant platforms, and establish yourself as a trusted voice in your field.</p>

        <h3>Measuring Success</h3>
        <p>Use Google Analytics and Search Console to track your SEO performance. Monitor organic traffic, click-through rates, and keyword rankings to understand what\'s working and what needs improvement.</p>
        ';
    }
}