<?php<?php<?php



namespace Database\Seeders;



use Illuminate\Database\Seeder;namespace Database\Seeders;namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Http;

use App\Models\User;

use App\Models\PortfolioItem;use Illuminate\Database\Seeder;use Illuminate\Database\Seeder;



class PortfolioItemSeeder extends Seederuse Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\DB;

{

    /**use Illuminate\Support\Facades\Storage;use Illuminate\Support\Facades\Storage;

     * Category-specific portfolio data mapping

     */use Illuminate\Support\Facades\Http;use Illuminate\Support\Facades\Http;

    private $categoryPortfolios = [

        'Singer' => [use App\Models\User;use App\Models\User;

            'images' => [

                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',use App\Models\CreatorProfile;use App\Models\CreatorProfile;

                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'use App\Models\PortfolioItem;use App\Models\PortfolioItem;

            ],

            'titles' => ['Live Concert Performance', 'Studio Recording Session', 'Music Video Shoot'],use App\Models\TalentCategory;use App\Models\TalentCategory;

            'descriptions' => [

                'Captivating live performance at the annual Caribbean Music Festival',use Carbon\Carbon;use Carbon\Carbon;

                'Professional studio recording of my latest single "Island Dreams"',

                'Behind the scenes from my latest music video production'

            ]

        ],class PortfolioItemSeeder extends Seederclass PortfolioItemSeeder extends Seeder

        'Songwriter' => [

            'images' => [{{

                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',    /**    /**

                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'

            ],     * Category-specific portfolio data mapping     * Run the database seeds.

            'titles' => ['Song Composition Process', 'Lyric Writing Session', 'Collaboration Work'],

            'descriptions' => [     */     */

                'Creative process behind my award-winning song "Tropical Nights"',

                'Working on heartfelt lyrics inspired by Curaçao\'s beautiful landscapes',    private $categoryPortfolios = [    public function run(): void

                'Collaborating with local artists to create authentic Caribbean sounds'

            ]        'Singer' => [    {

        ],

        'Designer' => [            'images' => [        // First, ensure we have some creator profiles to work with

            'images' => [

                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',        // Create some users and creator profiles if they don't exist

                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',        $this->createCreatorProfilesIfNeeded();

            ],

            'titles' => ['Brand Design Project', 'UI/UX Design', 'Print Design'],                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'

            'descriptions' => [

                'Complete brand identity design for Curaçao startup company',            ],        // Get all creator profiles

                'Modern mobile app design inspired by Caribbean aesthetics',

                'Creative print campaign for local tourism board'            'titles' => ['Live Concert Performance', 'Studio Recording Session', 'Music Video Shoot'],        $creatorProfiles = CreatorProfile::all();

            ]

        ],            'descriptions' => [

        'Actor' => [

            'images' => [                'Captivating live performance at the annual Caribbean Music Festival',        if ($creatorProfiles->isEmpty()) {

                'https://images.unsplash.com/photo-1507924538820-ede94a04019d?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',                'Professional studio recording of my latest single "Island Dreams"',            $this->command->warn('No creator profiles found. Please run creator profile seeder first.');

                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'

            ],                'Behind the scenes from my latest music video production'            return;

            'titles' => ['Film Acting Role', 'Theater Performance', 'Commercial Acting'],

            'descriptions' => [            ]        }

                'Leading role in critically acclaimed local film "Beyond the Reef"',

                'Captivating stage performance in contemporary Caribbean drama',        ],

                'Professional commercial work for international tourism campaign'

            ]        'Songwriter' => [        // Sample portfolio items data

        ],

        'Dancer' => [            'images' => [        $portfolioItems = [

            'images' => [

                'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?w=800&h=600&fit=crop&crop=center',                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',            [

                'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1545224144-b38cd309ef69?w=800&h=600&fit=crop&crop=center'                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',                'title' => 'Modern Website Design',

            ],

            'titles' => ['Solo Dance Performance', 'Choreography Creation', 'Dance Competition'],                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'                'description' => 'A clean and modern website design for a tech startup. Features responsive layout, smooth animations, and user-friendly interface.',

            'descriptions' => [

                'Mesmerizing solo performance combining traditional and contemporary styles',            ],                'file_path' => 'portfolio/images/modern-website-design.jpg',

                'Original choreography for music video featuring local artists',

                'First place winner at Caribbean Dance Championship'            'titles' => ['Song Composition Process', 'Lyric Writing Session', 'Collaboration Work'],                'file_type' => 'image',

            ]

        ]            'descriptions' => [                'mime_type' => 'image/jpeg',

    ];

                'Creative process behind my award-winning song "Tropical Nights"',                'file_size' => 2048576, // 2MB

    /**

     * Default portfolio for categories not specifically defined                'Working on heartfelt lyrics inspired by Curaçao\'s beautiful landscapes',                'thumbnail_path' => 'portfolio/thumbnails/modern-website-design-thumb.jpg',

     */

    private $defaultPortfolio = [                'Collaborating with local artists to create authentic Caribbean sounds'                'sort_order' => 1,

        'images' => [

            'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',            ]                'is_active' => true,

            'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',

            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'        ],            ],

        ],

        'titles' => ['Creative Project', 'Professional Work', 'Artistic Expression'],        'Komedia' => [            [

        'descriptions' => [

            'Showcasing creative excellence and professional dedication',            'images' => [                'title' => 'Brand Identity Package',

            'High-quality work that reflects passion and skill',

            'Artistic expression celebrating Caribbean culture and heritage'                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center',                'description' => 'Complete brand identity design including logo, business cards, letterhead, and brand guidelines for a local restaurant.',

        ]

    ];                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',                'file_path' => 'portfolio/images/brand-identity-package.png',



    public function run(): void                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'                'file_type' => 'image',

    {

        $this->command->info('Starting Portfolio Items Seeder...');            ],                'mime_type' => 'image/png',

        

        // Clear existing portfolio items            'titles' => ['Stand-up Comedy Show', 'Theater Performance', 'Comedy Writing'],                'file_size' => 1536000, // 1.5MB

        PortfolioItem::truncate();

                    'descriptions' => [                'thumbnail_path' => 'portfolio/thumbnails/brand-identity-package-thumb.png',

        // Get all creators with their profiles and categories

        $creators = User::where('role', 'creator')                'Hilarious stand-up set at Plaza Hotel\'s comedy night',                'sort_order' => 2,

            ->where('status', 'active')

            ->with(['creatorProfile.talentCategories'])                'Playing the lead role in "Laughter Under the Stars" theater production',                'is_active' => true,

            ->get();

                'Script writing for upcoming comedy special featuring Curaçao humor'            ],

        $this->command->info("Found {$creators->count()} creators to process.");

            ]            [

        $totalCreated = 0;

        ],                'title' => 'Product Demo Video',

        foreach ($creators as $creator) {

            if (!$creator->creatorProfile) {        'Drama' => [                'description' => 'Engaging product demonstration video showcasing the features and benefits of a mobile app. Includes motion graphics and professional voiceover.',

                continue;

            }            'images' => [                'file_path' => 'portfolio/videos/product-demo-video.mp4',



            $createdCount = $this->createPortfolioForCreator($creator);                'https://images.unsplash.com/photo-1507924538820-ede94a04019d?w=800&h=600&fit=crop&crop=center',                'file_type' => 'video',

            $totalCreated += $createdCount;

        }                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',                'mime_type' => 'video/mp4',



        $this->command->info("✅ Portfolio seeding completed!");                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'                'file_size' => 15728640, // 15MB

        $this->command->info("📊 Total portfolio items created: {$totalCreated}");

    }            ],                'thumbnail_path' => 'portfolio/thumbnails/product-demo-video-thumb.jpg',



    private function createPortfolioForCreator(User $creator): int            'titles' => ['Dramatic Theater Role', 'Method Acting Workshop', 'Character Development'],                'sort_order' => 3,

    {

        $profile = $creator->creatorProfile;            'descriptions' => [                'is_active' => true,

        $primaryCategory = $profile->talentCategories->first();

                        'Powerful performance in "Tears of Curaçao" at Teatro Nacional',            ],

        // Get portfolio data based on category

        $portfolioData = $this->getPortfolioDataForCategory($primaryCategory?->name);                'Leading an intensive method acting workshop for aspiring actors',            [

        

        // Create 3-5 portfolio items per creator                'Deep character study for my upcoming role in historical drama'                'title' => 'E-commerce Mobile App UI',

        $itemCount = rand(3, 5);

        $createdCount = 0;            ]                'description' => 'User interface design for a fashion e-commerce mobile application. Includes wireframes, mockups, and interactive prototypes.',



        for ($i = 0; $i < $itemCount; $i++) {        ],                'file_path' => 'portfolio/images/ecommerce-mobile-ui.jpg',

            try {

                $this->createPortfolioItem($profile->id, $portfolioData, $i);        'Cinematographer' => [                'file_type' => 'image',

                $createdCount++;

            } catch (\Exception $e) {            'images' => [                'mime_type' => 'image/jpeg',

                $this->command->warn("Failed to create portfolio item for creator {$creator->name}: " . $e->getMessage());

            }                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',                'file_size' => 3145728, // 3MB

        }

                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',                'thumbnail_path' => 'portfolio/thumbnails/ecommerce-mobile-ui-thumb.jpg',

        return $createdCount;

    }                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'                'sort_order' => 4,



    private function getPortfolioDataForCategory(?string $categoryName): array            ],                'is_active' => true,

    {

        return $this->categoryPortfolios[$categoryName] ?? $this->defaultPortfolio;            'titles' => ['Film Cinematography', 'Documentary Shoot', 'Commercial Production'],            ],

    }

            'descriptions' => [            [

    private function createPortfolioItem(int $creatorProfileId, array $portfolioData, int $index): void

    {                'Stunning visual storytelling for indie film "Caribbean Sunset"',                'title' => 'Corporate Presentation',

        $imageIndex = $index % count($portfolioData['images']);

        $imageUrl = $portfolioData['images'][$imageIndex];                'Capturing authentic moments for Curaçao tourism documentary',                'description' => 'Professional presentation design for quarterly business review. Clean layout with data visualization and corporate branding.',

        $title = $portfolioData['titles'][$imageIndex];

        $description = $portfolioData['descriptions'][$imageIndex];                'Creative commercial shoot for local resort featuring drone cinematography'                'file_path' => 'portfolio/images/corporate-presentation.png',



        // Download and save the image            ]                'file_type' => 'image',

        $fileName = $this->downloadImage($imageUrl, $creatorProfileId, $index);

                ],                'mime_type' => 'image/png',

        if (!$fileName) {

            throw new \Exception("Failed to download image from: {$imageUrl}");        'Director' => [                'file_size' => 2621440, // 2.5MB

        }

            'images' => [                'thumbnail_path' => 'portfolio/thumbnails/corporate-presentation-thumb.png',

        // Create portfolio item record

        PortfolioItem::create([                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',                'sort_order' => 5,

            'creator_profile_id' => $creatorProfileId,

            'title' => $title,                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',                'is_active' => true,

            'description' => $description,

            'file_path' => "portfolio/images/{$fileName}",                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'            ],

            'file_type' => 'image',

            'mime_type' => 'image/jpeg',            ],            [

            'file_size' => Storage::disk('public')->size("portfolio/images/{$fileName}"),

            'thumbnail_path' => "portfolio/images/{$fileName}",            'titles' => ['Film Direction', 'Music Video Direction', 'Theater Direction'],                'title' => 'Social Media Campaign',

            'sort_order' => $index + 1,

            'is_active' => true,            'descriptions' => [                'description' => 'Creative social media campaign design for a fitness brand. Includes Instagram posts, stories, and promotional banners.',

        ]);

    }                'Directing award-winning short film "Island Stories"',                'file_path' => 'portfolio/images/social-media-campaign.jpg',



    private function downloadImage(string $url, int $creatorProfileId, int $index): ?string                'Creative direction for local artist\'s breakthrough music video',                'file_type' => 'image',

    {

        try {                'Bringing classic Caribbean tales to life on stage'                'mime_type' => 'image/jpeg',

            // Add query parameters to ensure we get a fresh image

            $imageUrl = $url . '&sig=' . uniqid();            ]                'file_size' => 1843200, // 1.8MB

            

            $response = Http::timeout(30)->get($imageUrl);        ],                'thumbnail_path' => 'portfolio/thumbnails/social-media-campaign-thumb.jpg',

            

            if (!$response->successful()) {        'Dance group' => [                'sort_order' => 6,

                $this->command->warn("Failed to download image from {$url}");

                return null;            'images' => [                'is_active' => true,

            }

                'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?w=800&h=600&fit=crop&crop=center',            ],

            $imageContent = $response->body();

            $fileName = "creator_{$creatorProfileId}_item_{$index}_" . time() . '.jpg';                'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop&crop=center',            [

            

            // Save to storage                'https://images.unsplash.com/photo-1545224144-b38cd309ef69?w=800&h=600&fit=crop&crop=center'                'title' => 'Animated Logo Reveal',

            Storage::disk('public')->put("portfolio/images/{$fileName}", $imageContent);

                        ],                'description' => 'Dynamic animated logo reveal for brand introduction. Features smooth transitions and modern motion graphics.',

            return $fileName;

                        'titles' => ['Group Performance', 'Choreography Workshop', 'Cultural Dance'],                'file_path' => 'portfolio/videos/animated-logo-reveal.mp4',

        } catch (\Exception $e) {

            $this->command->warn("Error downloading image: " . $e->getMessage());            'descriptions' => [                'file_type' => 'video',

            return null;

        }                'Energetic performance at Curaçao Carnival featuring traditional dances',                'mime_type' => 'video/mp4',

    }

}                'Teaching authentic Caribbean dance moves to the community',                'file_size' => 8388608, // 8MB

                'Preserving and sharing Antillean cultural dance traditions'                'thumbnail_path' => 'portfolio/thumbnails/animated-logo-reveal-thumb.jpg',

            ]                'sort_order' => 7,

        ],                'is_active' => true,

        'Drummer' => [            ],

            'images' => [            [

                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',                'title' => 'Restaurant Menu Design',

                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',                'description' => 'Elegant menu design for an upscale restaurant. Features beautiful typography, food photography, and sophisticated layout.',

                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'                'file_path' => 'portfolio/images/restaurant-menu-design.pdf',

            ],                'file_type' => 'image',

            'titles' => ['Live Drumming Performance', 'Studio Session', 'Drum Workshop'],                'mime_type' => 'application/pdf',

            'descriptions' => [                'file_size' => 5242880, // 5MB

                'Powerful drumming performance at Jazz Festival Curaçao',                'thumbnail_path' => 'portfolio/thumbnails/restaurant-menu-design-thumb.jpg',

                'Laying down the rhythmic foundation for local band\'s new album',                'sort_order' => 8,

                'Teaching traditional Caribbean percussion to young musicians'                'is_active' => true,

            ]            ],

        ],            [

        'Designer' => [                'title' => 'Explainer Video Animation',

            'images' => [                'description' => 'Educational explainer video for a fintech startup. Combines 2D animation with clear narration to explain complex concepts.',

                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',                'file_path' => 'portfolio/videos/explainer-video-animation.mp4',

                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',                'file_type' => 'video',

                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'                'mime_type' => 'video/mp4',

            ],                'file_size' => 20971520, // 20MB

            'titles' => ['Brand Design Project', 'UI/UX Design', 'Print Design'],                'thumbnail_path' => 'portfolio/thumbnails/explainer-video-animation-thumb.jpg',

            'descriptions' => [                'sort_order' => 9,

                'Complete brand identity design for Curaçao startup company',                'is_active' => true,

                'Modern mobile app design inspired by Caribbean aesthetics',            ],

                'Creative print campaign for local tourism board'            [

            ]                'title' => 'Book Cover Design',

        ],                'description' => 'Eye-catching book cover design for a mystery novel. Features dramatic imagery and compelling typography to attract readers.',

        'Actor' => [                'file_path' => 'portfolio/images/book-cover-design.jpg',

            'images' => [                'file_type' => 'image',

                'https://images.unsplash.com/photo-1507924538820-ede94a04019d?w=800&h=600&fit=crop&crop=center',                'mime_type' => 'image/jpeg',

                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',                'file_size' => 1048576, // 1MB

                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'                'thumbnail_path' => 'portfolio/thumbnails/book-cover-design-thumb.jpg',

            ],                'sort_order' => 10,

            'titles' => ['Film Acting Role', 'Theater Performance', 'Commercial Acting'],                'is_active' => true,

            'descriptions' => [            ],

                'Leading role in critically acclaimed local film "Beyond the Reef"',            [

                'Captivating stage performance in contemporary Caribbean drama',                'title' => 'Wedding Photography Portfolio',

                'Professional commercial work for international tourism campaign'                'description' => 'Collection of beautiful wedding photographs capturing special moments. Includes ceremony, reception, and portrait shots.',

            ]                'file_path' => 'portfolio/images/wedding-photography-portfolio.jpg',

        ],                'file_type' => 'image',

        'Dj' => [                'mime_type' => 'image/jpeg',

            'images' => [                'file_size' => 4194304, // 4MB

                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',                'thumbnail_path' => 'portfolio/thumbnails/wedding-photography-portfolio-thumb.jpg',

                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',                'sort_order' => 11,

                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'                'is_active' => true,

            ],            ],

            'titles' => ['Club DJ Set', 'Wedding DJ Performance', 'Festival DJ Set'],            [

            'descriptions' => [                'title' => 'Music Video Production',

                'High-energy set at Mambo Beach Club featuring Latin and Caribbean beats',                'description' => 'Creative music video for an indie artist. Features artistic cinematography, color grading, and synchronized editing.',

                'Creating magical moments at beachfront wedding celebration',                'file_path' => 'portfolio/videos/music-video-production.mp4',

                'Headlining performance at Curaçao Electronic Music Festival'                'file_type' => 'video',

            ]                'mime_type' => 'video/mp4',

        ],                'file_size' => 52428800, // 50MB

        'Editor' => [                'thumbnail_path' => 'portfolio/thumbnails/music-video-production-thumb.jpg',

            'images' => [                'sort_order' => 12,

                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',                'is_active' => true,

                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',            ],

                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'        ];

            ],

            'titles' => ['Film Editing Project', 'Documentary Post-Production', 'Commercial Editing'],        // Distribute portfolio items among creator profiles

            'descriptions' => [        foreach ($portfolioItems as $index => $item) {

                'Post-production magic for award-winning Caribbean documentary',            // Assign to different creator profiles in rotation

                'Crafting compelling narrative through expert video editing techniques',            $creatorProfile = $creatorProfiles[$index % $creatorProfiles->count()];

                'Dynamic commercial editing featuring Curaçao\'s natural beauty'            

            ]            PortfolioItem::create(array_merge($item, [

        ],                'creator_profile_id' => $creatorProfile->id,

        'Influencer' => [            ]));

            'images' => [        }

                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',

                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',        $this->command->info('Portfolio items seeded successfully!');

                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'    }

            ],

            'titles' => ['Brand Collaboration', 'Content Creation', 'Social Media Campaign'],    /**

            'descriptions' => [     * Create some basic creator profiles if they don't exist

                'Successful brand partnership showcasing sustainable Caribbean lifestyle',     */

                'Authentic content creation highlighting local culture and traditions',    private function createCreatorProfilesIfNeeded(): void

                'Viral social media campaign promoting Curaçao tourism'    {

            ]        if (CreatorProfile::count() === 0) {

        ],            // Create some sample users and creator profiles

        'Dancer' => [            $users = [

            'images' => [                [

                'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?w=800&h=600&fit=crop&crop=center',                    'name' => 'John Designer',

                'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop&crop=center',                    'email' => 'john.designer@example.com',

                'https://images.unsplash.com/photo-1545224144-b38cd309ef69?w=800&h=600&fit=crop&crop=center'                    'password' => bcrypt('password'),

            ],                    'role' => 'creator',

            'titles' => ['Solo Dance Performance', 'Choreography Creation', 'Dance Competition'],                    'status' => 'active',

            'descriptions' => [                ],

                'Mesmerizing solo performance combining traditional and contemporary styles',                [

                'Original choreography for music video featuring local artists',                    'name' => 'Sarah Artist',

                'First place winner at Caribbean Dance Championship'                    'email' => 'sarah.artist@example.com',

            ]                    'password' => bcrypt('password'),

        ],                    'role' => 'creator',

        'Pianist' => [                    'status' => 'active',

            'images' => [                ],

                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',                [

                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',                    'name' => 'Mike Developer',

                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'                    'email' => 'mike.developer@example.com',

            ],                    'password' => bcrypt('password'),

            'titles' => ['Classical Piano Recital', 'Jazz Performance', 'Wedding Performance'],                    'role' => 'creator',

            'descriptions' => [                    'status' => 'active',

                'Elegant classical recital at Curaçao\'s historic Fortaleza',                ],

                'Smooth jazz performance at waterfront restaurant',            ];

                'Creating romantic atmosphere for beachside wedding ceremony'

            ]            foreach ($users as $userData) {

        ],                $user = User::create($userData);

        'Content creator' => [                

            'images' => [                CreatorProfile::create([

                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',                    'user_id' => $user->id,

                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',                    'short_bio' => 'Passionate creative professional with years of experience.',

                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'                    'about_me' => 'I am a dedicated creative professional who loves bringing ideas to life through innovative design and compelling visual storytelling.',

            ],                    'is_featured' => false,

            'titles' => ['Digital Content Series', 'Brand Content Creation', 'Educational Content'],                    'profile_views' => rand(50, 500),

            'descriptions' => [                    'total_likes' => rand(10, 100),

                'Engaging digital series showcasing Caribbean culture and lifestyle',                    'is_active' => true,

                'Professional brand content for luxury resort marketing campaign',                ]);

                'Educational content teaching Papiamentu language to international audience'            }

            ]        }

        ],    }

        'Model' => [}
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Fashion Photography', 'Commercial Modeling', 'Editorial Shoot'],
            'descriptions' => [
                'Stunning fashion photography featuring Caribbean-inspired designs',
                'Professional commercial modeling for international tourism campaign',
                'Editorial photoshoot highlighting natural beauty of Curaçao'
            ]
        ],
        'Tattoo artist' => [
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Custom Tattoo Design', 'Traditional Caribbean Art', 'Tattoo Portfolio'],
            'descriptions' => [
                'Intricate custom tattoo design inspired by Antillean heritage',
                'Traditional Caribbean symbols reimagined in modern tattoo art',
                'Award-winning tattoo work recognized at Caribbean Tattoo Convention'
            ]
        ],
        'Digital creator' => [
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Digital Art Creation', 'NFT Collection', 'Interactive Media'],
            'descriptions' => [
                'Innovative digital art celebrating Caribbean culture and nature',
                'Exclusive NFT collection featuring Curaçao\'s iconic landmarks',
                'Interactive digital installation for local art museum'
            ]
        ],
        'Comedian' => [
            'images' => [
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Stand-up Comedy Special', 'Comedy Writing', 'Improv Performance'],
            'descriptions' => [
                'Hilarious stand-up special featuring observational humor about island life',
                'Writing comedy material that celebrates Caribbean culture and quirks',
                'High-energy improv performance getting audiences laughing all night'
            ]
        ],
        'Rapper' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Hip-Hop Performance', 'Music Video Production', 'Studio Recording'],
            'descriptions' => [
                'Powerful rap performance addressing social issues in Caribbean society',
                'Creative music video showcasing authentic Curaçao street culture',
                'Studio session recording bilingual tracks in English and Papiamentu'
            ]
        ],
        'Producer' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Music Production', 'Album Production', 'Sound Design'],
            'descriptions' => [
                'Producing chart-topping Caribbean fusion album for local artists',
                'Complete album production featuring traditional and modern sounds',
                'Innovative sound design for film and commercial projects'
            ]
        ]
    ];

    /**
     * Default portfolio for categories not specifically defined
     */
    private $defaultPortfolio = [
        'images' => [
            'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
            'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
        ],
        'titles' => ['Creative Project', 'Professional Work', 'Artistic Expression'],
        'descriptions' => [
            'Showcasing creative excellence and professional dedication',
            'High-quality work that reflects passion and skill',
            'Artistic expression celebrating Caribbean culture and heritage'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting Portfolio Items Seeder...');
        
        // Clear existing portfolio items
        PortfolioItem::truncate();
        
        // Get all creators with their profiles and categories
        $creators = User::where('role', 'creator')
            ->where('status', 'active')
            ->with(['creatorProfile.talentCategories'])
            ->get();

        $this->command->info("Found {$creators->count()} creators to process.");

        $totalCreated = 0;
        $progressBar = $this->command->getOutput()->createProgressBar($creators->count());

        foreach ($creators as $creator) {
            if (!$creator->creatorProfile) {
                $progressBar->advance();
                continue;
            }

            $createdCount = $this->createPortfolioForCreator($creator);
            $totalCreated += $createdCount;
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->info("\n✅ Portfolio seeding completed!");
        $this->command->info("📊 Total portfolio items created: {$totalCreated}");
        $this->command->info("🎯 Average per creator: " . round($totalCreated / $creators->count(), 1));
    }

    /**
     * Create portfolio items for a specific creator
     */
    private function createPortfolioForCreator(User $creator): int
    {
        $profile = $creator->creatorProfile;
        $primaryCategory = $profile->talentCategories->first();
        
        // Get portfolio data based on category
        $portfolioData = $this->getPortfolioDataForCategory($primaryCategory?->name);
        
        // Create 3-5 portfolio items per creator
        $itemCount = rand(3, 5);
        $createdCount = 0;

        for ($i = 0; $i < $itemCount; $i++) {
            try {
                $this->createPortfolioItem($profile->id, $portfolioData, $i);
                $createdCount++;
            } catch (\Exception $e) {
                $this->command->warn("Failed to create portfolio item for creator {$creator->name}: " . $e->getMessage());
            }
        }

        return $createdCount;
    }

    /**
     * Get portfolio data based on category
     */
    private function getPortfolioDataForCategory(?string $categoryName): array
    {
        return $this->categoryPortfolios[$categoryName] ?? $this->defaultPortfolio;
    }

    /**
     * Create a single portfolio item
     */
    private function createPortfolioItem(int $creatorProfileId, array $portfolioData, int $index): void
    {
        $imageIndex = $index % count($portfolioData['images']);
        $imageUrl = $portfolioData['images'][$imageIndex];
        $title = $portfolioData['titles'][$imageIndex];
        $description = $portfolioData['descriptions'][$imageIndex];

        // Download and save the image
        $fileName = $this->downloadImage($imageUrl, $creatorProfileId, $index);
        
        if (!$fileName) {
            throw new \Exception("Failed to download image from: {$imageUrl}");
        }

        // Create portfolio item record
        PortfolioItem::create([
            'creator_profile_id' => $creatorProfileId,
            'title' => $title,
            'description' => $description,
            'file_path' => "portfolio/images/{$fileName}",
            'file_type' => 'image',
            'mime_type' => 'image/jpeg',
            'file_size' => Storage::disk('public')->size("portfolio/images/{$fileName}"),
            'thumbnail_path' => "portfolio/images/{$fileName}", // Using same image as thumbnail
            'sort_order' => $index + 1,
            'is_active' => true,
        ]);
    }

    /**
     * Download image from URL and save to storage
     */
    private function downloadImage(string $url, int $creatorProfileId, int $index): ?string
    {
        try {
            // Add query parameters to ensure we get a fresh image
            $imageUrl = $url . '&sig=' . uniqid();
            
            $response = Http::timeout(30)->get($imageUrl);
            
            if (!$response->successful()) {
                $this->command->warn("Failed to download image from {$url}");
                return null;
            }

            $imageContent = $response->body();
            $fileName = "creator_{$creatorProfileId}_item_{$index}_" . time() . '.jpg';
            
            // Save to storage
            Storage::disk('public')->put("portfolio/images/{$fileName}", $imageContent);
            
            return $fileName;
            
        } catch (\Exception $e) {
            $this->command->warn("Error downloading image: " . $e->getMessage());
            return null;
        }
    }
}