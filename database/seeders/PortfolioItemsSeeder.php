<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\CreatorProfile;
use App\Models\PortfolioItem;
use App\Models\TalentCategory;
use Carbon\Carbon;

class PortfolioItemsSeeder extends Seeder
{
    /**
     * Category-specific portfolio data mapping
     */
    private $categoryPortfolios = [
        'Singer' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Live Concert Performance', 'Studio Recording Session', 'Music Video Shoot'],
            'descriptions' => [
                'Captivating live performance at the annual Caribbean Music Festival',
                'Professional studio recording of my latest single "Island Dreams"',
                'Behind the scenes from my latest music video production'
            ]
        ],
        'Songwriter' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Song Composition Process', 'Lyric Writing Session', 'Collaboration Work'],
            'descriptions' => [
                'Creative process behind my award-winning song "Tropical Nights"',
                'Working on heartfelt lyrics inspired by Curaçao\'s beautiful landscapes',
                'Collaborating with local artists to create authentic Caribbean sounds'
            ]
        ],
        'Komedia' => [
            'images' => [
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Stand-up Comedy Show', 'Theater Performance', 'Comedy Writing'],
            'descriptions' => [
                'Hilarious stand-up set at Plaza Hotel\'s comedy night',
                'Playing the lead role in "Laughter Under the Stars" theater production',
                'Script writing for upcoming comedy special featuring Curaçao humor'
            ]
        ],
        'Drama' => [
            'images' => [
                'https://images.unsplash.com/photo-1507924538820-ede94a04019d?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Dramatic Theater Role', 'Method Acting Workshop', 'Character Development'],
            'descriptions' => [
                'Powerful performance in "Tears of Curaçao" at Teatro Nacional',
                'Leading an intensive method acting workshop for aspiring actors',
                'Deep character study for my upcoming role in historical drama'
            ]
        ],
        'Cinematographer' => [
            'images' => [
                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Film Cinematography', 'Documentary Shoot', 'Commercial Production'],
            'descriptions' => [
                'Stunning visual storytelling for indie film "Caribbean Sunset"',
                'Capturing authentic moments for Curaçao tourism documentary',
                'Creative commercial shoot for local resort featuring drone cinematography'
            ]
        ],
        'Director' => [
            'images' => [
                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Film Direction', 'Music Video Direction', 'Theater Direction'],
            'descriptions' => [
                'Directing award-winning short film "Island Stories"',
                'Creative direction for local artist\'s breakthrough music video',
                'Bringing classic Caribbean tales to life on stage'
            ]
        ],
        'Dance group' => [
            'images' => [
                'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1545224144-b38cd309ef69?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Group Performance', 'Choreography Workshop', 'Cultural Dance'],
            'descriptions' => [
                'Energetic performance at Curaçao Carnival featuring traditional dances',
                'Teaching authentic Caribbean dance moves to the community',
                'Preserving and sharing Antillean cultural dance traditions'
            ]
        ],
        'Drummer' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Live Drumming Performance', 'Studio Session', 'Drum Workshop'],
            'descriptions' => [
                'Powerful drumming performance at Jazz Festival Curaçao',
                'Laying down the rhythmic foundation for local band\'s new album',
                'Teaching traditional Caribbean percussion to young musicians'
            ]
        ],
        'Designer' => [
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Brand Design Project', 'UI/UX Design', 'Print Design'],
            'descriptions' => [
                'Complete brand identity design for Curaçao startup company',
                'Modern mobile app design inspired by Caribbean aesthetics',
                'Creative print campaign for local tourism board'
            ]
        ],
        'Actor' => [
            'images' => [
                'https://images.unsplash.com/photo-1507924538820-ede94a04019d?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516131206008-dd041a9764fd?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Film Acting Role', 'Theater Performance', 'Commercial Acting'],
            'descriptions' => [
                'Leading role in critically acclaimed local film "Beyond the Reef"',
                'Captivating stage performance in contemporary Caribbean drama',
                'Professional commercial work for international tourism campaign'
            ]
        ],
        'Dj' => [
            'images' => [
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Club DJ Set', 'Wedding DJ Performance', 'Festival DJ Set'],
            'descriptions' => [
                'High-energy set at Mambo Beach Club featuring Latin and Caribbean beats',
                'Creating magical moments at beachfront wedding celebration',
                'Headlining performance at Curaçao Electronic Music Festival'
            ]
        ],
        'Editor' => [
            'images' => [
                'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Film Editing Project', 'Documentary Post-Production', 'Commercial Editing'],
            'descriptions' => [
                'Post-production magic for award-winning Caribbean documentary',
                'Crafting compelling narrative through expert video editing techniques',
                'Dynamic commercial editing featuring Curaçao\'s natural beauty'
            ]
        ],
        'Influencer' => [
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Brand Collaboration', 'Content Creation', 'Social Media Campaign'],
            'descriptions' => [
                'Successful brand partnership showcasing sustainable Caribbean lifestyle',
                'Authentic content creation highlighting local culture and traditions',
                'Viral social media campaign promoting Curaçao tourism'
            ]
        ],
        'Dancer' => [
            'images' => [
                'https://images.unsplash.com/photo-1504609813442-a8924e83f76e?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1545224144-b38cd309ef69?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Solo Dance Performance', 'Choreography Creation', 'Dance Competition'],
            'descriptions' => [
                'Mesmerizing solo performance combining traditional and contemporary styles',
                'Original choreography for music video featuring local artists',
                'First place winner at Caribbean Dance Championship'
            ]
        ],
        'Pianist' => [
            'images' => [
                'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Classical Piano Recital', 'Jazz Performance', 'Wedding Performance'],
            'descriptions' => [
                'Elegant classical recital at Curaçao\'s historic Fortaleza',
                'Smooth jazz performance at waterfront restaurant',
                'Creating romantic atmosphere for beachside wedding ceremony'
            ]
        ],
        'Content creator' => [
            'images' => [
                'https://images.unsplash.com/photo-1558655146-d09347e92766?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1542744094-3a31f272c490?w=800&h=600&fit=crop&crop=center',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=center'
            ],
            'titles' => ['Digital Content Series', 'Brand Content Creation', 'Educational Content'],
            'descriptions' => [
                'Engaging digital series showcasing Caribbean culture and lifestyle',
                'Professional brand content for luxury resort marketing campaign',
                'Educational content teaching Papiamentu language to international audience'
            ]
        ],
        'Model' => [
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