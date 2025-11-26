<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TalentsController extends Controller
{
    /**
     * Show the talents page.
     */
    public function index(Request $request)
    {
        // Fetch dynamic data from database
        $creatorsQuery = User::where('role', 'creator')
            ->where('status', 'active')
            ->with([
                'creatorProfile.talentCategories',
                'creatorProfile.portfolioItems' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                },
                'creatorProfile.likes'
            ]);

        // Handle search and filters
        $searchTerm = $request->get('search', '');
        $selectedCategory = $request->get('category', 'all');
        $selectedLocation = $request->get('location', 'all');
        $viewMode = $request->get('view', 'grid');

        // Apply database-level filtering for better performance
        if (!empty($searchTerm)) {
            $creatorsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('creatorProfile', function ($q) use ($searchTerm) {
                        $q->where('short_bio', 'like', '%' . $searchTerm . '%')
                            ->orWhere('about_me', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('creatorProfile.talentCategories', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($selectedCategory !== 'all') {
            $creatorsQuery->whereHas('creatorProfile.talentCategories', function ($query) use ($selectedCategory) {
                $query->where('name', $selectedCategory);
            });
        }

        // Execute the query with filters
        $creators = $creatorsQuery->get();

        // Get current user's favorites if logged in as member
        $userFavorites = [];
        if (auth()->check() && auth()->user()->role === 'member') {
            $userFavorites = auth()->user()->favorites()
                ->pluck('creator_profile_id')
                ->toArray();
        }

        // Transform creators data to match the expected format
        $talents = $creators->map(function ($creator) use ($userFavorites) {
            $profile = $creator->creatorProfile;

            if (!$profile) {
                return null; // Skip creators without profiles
            }

            // Get primary talent category
            $primaryCategory = $profile->talentCategories->first();

            // Generate some sample data for missing fields
            $rating = round(4.0 + (rand(0, 90) / 100), 1); // Random rating between 4.0-4.9
            $reviewCount = rand(10, 150);
            $completedProjects = rand(20, 200);
            $responseTime = rand(1, 8) . ' uur';
            $priceFrom = rand(50, 500);

            // Sample locations (since not in database)
            $locations = ['Willemstad', 'Punda', 'Otrobanda', 'Scharloo', 'Pietermaai'];
            $location = $locations[array_rand($locations)];

            // Get main card image - priority: banner_image > avatar > portfolio > default
            $cardImage = $profile->banner_image
                ? asset('storage/' . $profile->banner_image)
                : ($creator->avatar
                    ? asset('storage/' . $creator->avatar)
                    : ($profile->portfolioItems->first()?->file_path
                        ? asset('storage/' . $profile->portfolioItems->first()->file_path)
                        : 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=200&fit=crop'));

            // Get profile image (avatar)
            $profileImage = $creator->avatar
                ? asset('storage/' . $creator->avatar)
                : asset('images/default-avatar.svg');

            // Get skills from talent categories
            $skills = $profile->talentCategories->pluck('name')->toArray();
            if (empty($skills)) {
                $skills = ['Algemeen']; // Default skill if no categories
            }

            // Check if this creator is favorited by current user
            $isFavorited = in_array($profile->id, $userFavorites);

            return [
                'id' => $creator->id,
                'creator_profile_id' => $profile->id,
                'name' => $creator->name,
                'profession' => $profile->short_bio ?: 'Creative Professional',
                'category' => $primaryCategory?->name ?: 'Algemeen',
                'location' => $location,
                'rating' => $rating,
                'reviewCount' => $reviewCount,
                'is_favorited' => $isFavorited,
                'completedProjects' => $completedProjects,
                'responseTime' => $responseTime,
                'priceFrom' => $priceFrom,
                'image' => $cardImage,
                'profileImage' => $profileImage,
                'skills' => $skills,
                'verified' => $creator->email_verified_at !== null,
                'featured' => $profile->is_featured,
                'availability' => $profile->is_active ? 'Beschikbaar' : 'Niet Beschikbaar',
                'joinedDate' => $creator->created_at->format('Y')
            ];
        })->filter()->values(); // Remove null values and reindex

        // Get categories from database
        $categoriesFromDb = \App\Models\TalentCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categories = collect([
            ['value' => 'all', 'label' => 'Alle Categorieën']
        ])->concat(
            $categoriesFromDb->map(function ($category) {
                return [
                    'value' => $category->name,
                    'label' => $category->name
                ];
            })
        )->toArray();

        // Apply location filtering on the transformed data (since location is generated)
        $filteredTalents = $talents;
        if ($selectedLocation !== 'all') {
            $filteredTalents = $talents->filter(function ($talent) use ($selectedLocation) {
                return $talent['location'] === $selectedLocation;
            });
        }

        return view('talents', compact(
            'filteredTalents',
            'categories',
            'searchTerm',
            'selectedCategory',
            'selectedLocation',
            'viewMode'
        ));
    }

    /**
     * Show individual talent profile
     */
    public function show($id)
    {
        // Fetch creator from database
        $creator = User::where('role', 'creator')
            ->where('status', 'active')
            ->where('id', $id)
            ->with([
                'creatorProfile.talentCategories',
                'creatorProfile.portfolioItems' => function ($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                },
                'creatorProfile.likes'
            ])
            ->first();

        // Return 404 if creator not found
        if (!$creator || !$creator->creatorProfile) {
            abort(404, 'Talent not found');
        }

        $profile = $creator->creatorProfile;

        // Generate sample data for missing fields (same as in index method)
        $rating = round(4.0 + (rand(0, 90) / 100), 1);
        $reviewCount = rand(10, 150);
        $studentsCount = rand(50, 300);
        $profileViews = rand(500, 5000);
        $completedProjects = rand(20, 200);
        $responseTime = rand(1, 8) . ' uur';
        $priceFrom = rand(50, 500);
        $priceTo = $priceFrom + rand(200, 2000);

        // Sample locations
        $locations = ['Willemstad', 'Punda', 'Otrobanda', 'Scharloo', 'Pietermaai'];
        $location = $locations[array_rand($locations)] . ', Curaçao';

        // Sample languages
        $allLanguages = ['Nederlands', 'Papiamentu', 'Engels', 'Spaans', 'Portugees'];
        $languages = array_slice($allLanguages, 0, rand(2, 4));

        // Get primary talent category
        $primaryCategory = $profile->talentCategories->first();

        // Get profile image (avatar)
        $profileImage = $creator->avatar
            ? asset('storage/' . $creator->avatar)
            : asset('images/default-avatar.svg');

        // Get main image - priority: banner_image > avatar > portfolio > default
        $mainImage = $profile->banner_image
            ? asset('storage/' . $profile->banner_image)
            : ($creator->avatar
                ? asset('storage/' . $creator->avatar)
                : ($profile->portfolioItems->first()?->file_path
                    ? asset('storage/' . $profile->portfolioItems->first()->file_path)
                    : 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=600&h=400&fit=crop'));

        // Get skills from talent categories
        $skills = $profile->talentCategories->pluck('name')->toArray();
        if (empty($skills)) {
            $skills = ['Algemeen'];
        }

        // Transform portfolio items
        $portfolio = $profile->portfolioItems->map(function ($item, $index) {
            $sampleClients = ['Hotel Kura Hulanda', 'Curaçao Museum', 'Curaçao Sea Aquarium', 'Sentro di Komunidat Otrobanda', 'Restaurant Gouverneur', 'Plaza Hotel'];
            $sampleObjectives = [
                'Het hotel wilde een authentieke Caribische sfeer creëren in hun lobby met een muurschildering die de lokale cultuur en geschiedenis van Curaçao zou weerspiegelen.',
                'Het museum wilde een nieuwe tentoonstelling over lokale helden en pioniers, met portretten die hun bijdragen aan de samenleving zouden benadrukken.',
                'Het aquarium wilde bezoekers bewust maken van de bedreigde koraalriffen rond Curaçao door middel van kunst die zowel de schoonheid als de kwetsbaarheid zou tonen.',
                'Het gemeenschapscentrum wilde hun buitenmuur transformeren tot een vrolijk en uitnodigend kunstwerk dat de diversiteit van de lokale gemeenschap zou vieren.'
            ];
            $sampleResults = [
                'Een 8x4 meter muurschildering die de evolutie van Curaçao toont, van de oorspronkelijke Arawak bewoners tot de koloniale periode en moderne tijd.',
                'Een serie van 12 realistische portretten van invloedrijke Curaçaoënaars, elk 60x80cm. De tentoonstelling trok 40% meer bezoekers dan verwacht.',
                'Een drieluik abstract schilderij (totaal 6x2 meter) dat de transformatie van gezonde naar bedreigde koraalriffen toont.',
                'Een 15 meter lange muurschildering die verschillende generaties en culturen toont. Het centrum zag een 60% toename in jeugdparticipatie.'
            ];

            return [
                'id' => $item->id,
                'title' => $item->title ?: 'Kunstwerk ' . ($index + 1),
                'image' => $item->file_path ? asset('storage/' . $item->file_path) : 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=400&h=300&fit=crop',
                'description' => $item->description ?: 'Prachtig kunstwerk dat de lokale cultuur weergeeft',
                'clientName' => $sampleClients[array_rand($sampleClients)],
                'projectObjective' => $sampleObjectives[array_rand($sampleObjectives)],
                'projectResult' => $sampleResults[array_rand($sampleResults)]
            ];
        })->toArray();

        // Generate sample reviews
        $sampleNames = ['Carlos Martina', 'Isabella Santos', 'Miguel Pieters', 'Ana Rodriguez', 'Roberto Silva'];
        $sampleComments = [
            'Prachtige muurschildering gemaakt voor ons restaurant. Professionaliteit en creativiteit zijn ongeëvenaard. Zeer tevreden!',
            'Geweldige ervaring! Luisterde echt naar onze wensen en heeft die perfect vertaald naar een prachtig kunstwerk. Aanrader!',
            'Professioneel werk en goede communicatie. Het eindresultaat overtrof onze verwachtingen. Dank je wel!',
            'Fantastische samenwerking. Het kunstwerk heeft onze ruimte compleet getransformeerd. Zeer aan te bevelen!',
            'Uitstekende kwaliteit en service. Het project werd op tijd opgeleverd en ziet er geweldig uit.'
        ];
        $sampleProjects = ['Restaurant Muurschildering', 'Familie Portret', 'Kantoor Decoratie', 'Woning Interieur', 'Bedrijfslogo'];

        $reviews = [];
        for ($i = 0; $i < min(3, $reviewCount); $i++) {
            $name = $sampleNames[array_rand($sampleNames)];
            $reviews[] = [
                'id' => $i + 1,
                'name' => $name,
                'avatar' => strtoupper(substr($name, 0, 1) . substr(explode(' ', $name)[1] ?? '', 0, 1)),
                'rating' => rand(4, 5),
                'date' => rand(1, 8) . ' ' . (rand(0, 1) ? 'weken' : 'maanden') . ' geleden',
                'comment' => $sampleComments[array_rand($sampleComments)],
                'project' => $sampleProjects[array_rand($sampleProjects)],
                'verified' => rand(0, 1) == 1
            ];
        }

        // Generate sample FAQs
        $faqs = [
            [
                'question' => 'Wat zijn je specialiteiten?',
                'answer' => 'Ik specialiseer mij in ' . implode(', ', array_slice($skills, 0, 3)) . '. Mijn stijl combineert traditionele technieken met moderne Caribische invloeden.'
            ],
            [
                'question' => 'Hoe lang duurt een gemiddeld project?',
                'answer' => 'Dit hangt af van de grootte en complexiteit van het project. Een portret duurt meestal 1-2 weken, terwijl een grote muurschildering 2-4 weken kan duren.'
            ],
            [
                'question' => 'Werk je ook buiten Willemstad?',
                'answer' => 'Ja, ik werk door heel Curaçao en ben ook beschikbaar voor projecten op andere Caribische eilanden. Voor projecten buiten Curaçao kunnen er extra reiskosten van toepassing zijn.'
            ],
            [
                'question' => 'Wat zijn je tarieven?',
                'answer' => 'Mijn tarieven variëren van €' . $priceFrom . ' voor kleine werken tot €' . $priceTo . ' voor grote projecten. De exacte prijs hangt af van de grootte, complexiteit en materialen.'
            ]
        ];

        // Generate sample Instagram posts from portfolio
        $instagramPosts = [];
        foreach (array_slice($portfolio, 0, 4) as $index => $portfolioItem) {
            $instagramPosts[] = [
                'id' => $index + 1,
                'image' => $portfolioItem['image'],
                'likes' => rand(50, 250),
                'comments' => rand(5, 35),
                'caption' => 'Nieuw project voltooid! 🎨✨ #CuracaoArt #' . str_replace(' ', '', $skills[0] ?? 'Art'),
                'timeAgo' => rand(1, 14) . 'd'
            ];
        }

        // Check if current user has favorited this creator
        $isFavorited = false;
        if (auth()->check() && auth()->user()->role === 'member') {
            $isFavorited = auth()->user()->hasFavorited($profile->id);
        }

        // Check if current user can edit this profile
        $canEdit = false;
        if (auth()->check() && auth()->user()->role === 'creator' && auth()->id() === $creator->id) {
            $canEdit = true;
        }

        // Build the talent array with dynamic data
        $talent = [
            'id' => $creator->id,
            'creator_profile_id' => $profile->id,
            'name' => $creator->name,
            'featured_video' => $creator->featured_video,
            'profession' => $profile->short_bio ?: 'Creative Professional',
            'category' => $primaryCategory?->name ?: 'Algemeen',
            'location' => $location,
            'rating' => $rating,
            'reviewCount' => $reviewCount,
            'is_favorited' => $isFavorited,
            'can_edit' => $canEdit,
            'studentsCount' => $studentsCount,
            'profileViews' => $profileViews,
            'joinedDate' => $creator->created_at->format('F Y'),
            'lastActive' => rand(1, 24) . ' uur geleden',
            'verified' => $creator->email_verified_at !== null,
            'level' => $profile->experience_level ?: 'Professional',
            'availability' => $profile->is_active ? 'Beschikbaar' : 'Niet Beschikbaar',
            'responseTime' => 'Binnen ' . $responseTime,
            'completedProjects' => $completedProjects,
            'repeatClients' => rand(85, 98) . '%',
            'onTimeDelivery' => rand(90, 100) . '%',
            'priceRange' => '€' . $priceFrom . ' - €' . $priceTo,
            'image' => $mainImage,
            'profileImage' => $profileImage,
            'skills' => $skills,
            'experience' => $profile->years_experience ? $profile->years_experience . ' jaar ervaring' : rand(2, 15) . ' jaar ervaring',
            'languages' => $languages,
            'description' => $profile->short_bio ?: 'Gepassioneerde kunstenaar gespecialiseerd in creatieve projecten met lokale invloeden.',
            'about' => $profile->about_me ?: 'Hallo! Ik ben ' . $creator->name . ', een professionele kunstenaar uit Curaçao. Met jarenlange ervaring help ik klanten hun visie tot leven te brengen door middel van kunst en creativiteit.',
            'workingProcess' => $profile->working_process ?: 'Mijn werkproces begint altijd met een uitgebreid gesprek om uw visie te begrijpen. Daarna maak ik schetsen en concepten, gevolgd door de uitvoering met regelmatige updates.',
            'education' => [
                [
                    'degree' => 'Bachelor Beeldende Kunst',
                    'school' => 'Universiteit van Curaçao',
                    'year' => '2015'
                ]
            ],
            'certifications' => [
                'Professioneel ' . ($primaryCategory?->name ?: 'Kunstenaar'),
                'Gecertificeerd Creative Professional'
            ],
            'awards' => [
                'Beste Lokale Kunstenaar 2023',
                'Caribische Kunst Prijs 2022'
            ],
            'portfolio' => $portfolio,
            'reviews' => $reviews,
            'faqs' => $faqs,
            'instagramPosts' => $instagramPosts,
            // Add raw database data for editing
            'profile_data' => [
                'youtube_profile_url' => $profile->youtube_profile_url,
                'short_bio' => $profile->short_bio,
                'about_me' => $profile->about_me,
                'website_url' => $profile->website_url,
                'facebook_url' => $profile->facebook_url,
                'instagram_url' => $profile->instagram_url,
                'twitter_url' => $profile->twitter_url,
                'linkedin_url' => $profile->linkedin_url,
                'youtube_url' => $profile->youtube_url,
                'tiktok_url' => $profile->tiktok_url,
            ]
        ];
        return view('talent.profile', compact('talent'));
    }

    /**
     * Search creators for autocomplete
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $creators = User::where('role', 'creator')
            ->where('status', 'active')
            ->with(['creatorProfile.talentCategories']);

        // Apply search filters if query has at least 2 characters
        if (strlen($query) >= 2) {
            $creators->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhereHas('creatorProfile', function ($profile) use ($query) {
                        $profile->where('short_bio', 'LIKE', '%' . $query . '%')
                            ->orWhere('about_me', 'LIKE', '%' . $query . '%');
                    })
                    ->orWhereHas('creatorProfile.talentCategories', function ($category) use ($query) {
                        $category->where('name', 'LIKE', '%' . $query . '%');
                    });
            });
        }

        $results = $creators->limit(8)->get();

        $suggestions = $results->map(function ($creator) {
            $profile = $creator->creatorProfile;
            if (!$profile) {
                return null;
            }

            $primaryCategory = $profile->talentCategories->first();
            $profileImage = $creator->avatar
                ? asset('storage/' . $creator->avatar)
                : asset('images/default-avatar.svg');

            return [
                'id' => $creator->id,
                'name' => $creator->name,
                'profession' => $profile->short_bio ?: 'Creative Professional',
                'category' => $primaryCategory?->name ?: 'Algemeen',
                'image' => $profileImage,
                'url' => route('talent.show', $creator->id)
            ];
        })->filter()->values();

        return response()->json($suggestions);
    }
}
