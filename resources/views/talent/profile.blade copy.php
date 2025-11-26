@extends('layouts.landing')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <a href="/" class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-pink-500 to-orange-500 rounded-sm flex items-center justify-center">
                            <div class="w-6 h-6 bg-white rounded-sm"></div>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Curaçao Talents</span>
                    </a>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="/" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Home
                        </a>
                        <a href="/talents" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Discover Talents
                        </a>
                        <a href="/about" class="text-gray-700 hover:text-pink-600 transition-colors">
                            About
                        </a>
                        <a href="/contact" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Contact
                        </a>
                    </nav>

                    <!-- User Actions -->
                    <div class="flex items-center gap-4">
                        @auth
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-600">
                                    Welcome, {{ auth()->user()->name }}
                                </span>
                                <a href="/dashboard">
                                    <button
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                        Dashboard
                                    </button>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                    Login
                                </a>
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:bg-primary/90 h-9 px-3">
                                    Sign Up
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative bg-gradient-to-r from-gray-900 via-blue-900 to-purple-900 text-white py-12">
            <div class="container mx-auto px-6">
                <!-- Breadcrumb -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2 text-gray-300">
                        <a href="/talents" class="hover:text-white transition-colors flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            Talenten
                        </a>
                        <span>/</span>
                        <span>Talent Details</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="handleShare()"
                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white hover:bg-white/10 h-9 px-3">
                            <i data-lucide="share-2" class="w-4 h-4 mr-2"></i>
                            Delen
                        </button>
                        <button onclick="handleReport()"
                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white hover:bg-white/10 h-9 px-3">
                            <i data-lucide="flag" class="w-4 h-4 mr-2"></i>
                            Rapporteer
                        </button>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column - Talent Info -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-4 mb-4">
                            <h1 class="text-4xl md:text-5xl font-bold">
                                {{ $talent['profession'] }}
                            </h1>
                            @if ($talent['verified'])
                                <div class="flex items-center gap-1 bg-blue-600 px-2 py-1 rounded-full">
                                    <i data-lucide="shield" class="w-4 h-4"></i>
                                    <span class="text-sm font-medium">Geverifieerd</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div
                                class="inline-flex items-center rounded-full border border-transparent bg-gradient-to-r from-pink-500 to-orange-500 text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                {{ $talent['category'] }}
                            </div>
                            <div
                                class="inline-flex items-center rounded-full border border-transparent bg-blue-600 text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                {{ $talent['level'] }}
                            </div>
                            <div
                                class="inline-flex items-center rounded-full border border-transparent bg-green-600 text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                {{ $talent['availability'] }}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-gray-300">
                            <div class="flex items-center gap-2">
                                <div class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                                    <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}"
                                        class="aspect-square h-full w-full">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-full bg-muted">{{ substr($talent['name'], 0, 2) }}</span>
                                </div>
                                <div>
                                    <div class="text-sm">Door</div>
                                    <div class="font-semibold">{{ $talent['name'] }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                                <div>
                                    <div class="font-semibold">{{ $talent['rating'] }}</div>
                                    <div class="text-xs">({{ $talent['reviewCount'] }} reviews)</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="users" class="w-4 h-4"></i>
                                <div>
                                    <div class="font-semibold">{{ $talent['studentsCount'] }}</div>
                                    <div class="text-xs">klanten</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                                <div>
                                    <div class="font-semibold">{{ $talent['profileViews'] }}</div>
                                    <div class="text-xs">profielweergaven</div>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-300 text-lg leading-relaxed mb-4">
                            {{ $talent['description'] }}
                        </p>

                        <div class="flex items-center gap-6 text-sm text-gray-400">
                            <span>Lid sinds {{ $talent['joinedDate'] }}</span>
                            <span>Laatst actief: {{ $talent['lastActive'] }}</span>
                            <span>Prijsklasse: {{ $talent['priceRange'] }}</span>
                        </div>
                    </div>

                    <!-- Right Column - Video Preview -->
                    <div class="lg:col-span-1">
                        <div class="relative bg-black rounded-lg overflow-hidden shadow-2xl">
                            <img src="{{ $talent['image'] }}" alt="{{ $talent['name'] }}"
                                class="w-full h-64 object-cover" />
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <button onclick="playVideo()"
                                    class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full p-4 inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                                    <i data-lucide="play" class="w-8 h-8"></i>
                                </button>
                            </div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <div class="bg-black/60 backdrop-blur-sm rounded-lg p-3 text-white text-sm">
                                    <div class="font-semibold mb-1">Introductie Video</div>
                                    <div class="text-xs opacity-90">Leer {{ explode(' ', $talent['name'])[0] }} kennen en
                                        haar werkwijze</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-6 py-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Tabs -->
                    <div class="space-y-6">
                        <div
                            class="grid grid-cols-4 h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground w-full">
                            <button id="tab-portfolio" onclick="switchTab('portfolio')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-background text-foreground shadow-sm">Portfolio</button>
                            <button id="tab-about" onclick="switchTab('about')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Over
                                Talent</button>
                            <button id="tab-reviews" onclick="switchTab('reviews')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Reviews</button>
                            <button id="tab-qa" onclick="switchTab('qa')"
                                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Q&A</button>
                        </div>

                        <!-- Portfolio Tab -->
                        <div id="content-portfolio" class="tab-content space-y-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-gray-900">Mijn Portfolio</h3>
                                <button onclick="downloadPortfolio()"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                    Download Portfolio
                                </button>
                            </div>
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach ($talent['portfolio'] as $item)
                                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden hover:shadow-lg transition-shadow cursor-pointer group"
                                        onclick="handlePortfolioClick({{ json_encode($item) }})">
                                        <div class="p-0">
                                            <div class="relative">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                                                <div
                                                    class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                                    <i data-lucide="camera"
                                                        class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                                </div>
                                            </div>
                                            <div class="p-4">
                                                <h4 class="font-semibold text-gray-900 mb-2">{{ $item['title'] }}</h4>
                                                <p class="text-gray-600 text-sm mb-2">{{ $item['description'] }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs text-gray-500">Client:
                                                        {{ $item['clientName'] }}</span>
                                                    <span class="text-pink-600 text-xs font-medium">Klik voor details
                                                        →</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- About Tab -->
                        <div id="content-about" class="tab-content space-y-8 hidden">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Over {{ $talent['name'] }}</h3>
                                <div class="prose max-w-none">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-6">
                                        {{ $talent['about'] }}
                                    </p>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Werkwijze</h4>
                                    <p class="text-gray-700 leading-relaxed mb-6">
                                        {{ $talent['workingProcess'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                        <i data-lucide="palette" class="w-5 h-5 text-pink-600"></i>
                                        Vaardigheden
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($talent['skills'] as $skill)
                                            <div
                                                class="inline-flex items-center rounded-full border border-transparent bg-gradient-to-r from-pink-100 to-orange-100 text-pink-700 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                                {{ $skill }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                        <i data-lucide="globe" class="w-5 h-5 text-pink-600"></i>
                                        Talen
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($talent['languages'] as $language)
                                            <div
                                                class="inline-flex items-center rounded-full border border-gray-200 text-gray-700 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                                {{ $language }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                        <i data-lucide="graduation-cap" class="w-5 h-5 text-pink-600"></i>
                                        Opleiding
                                    </h4>
                                    <div class="space-y-3">
                                        @foreach ($talent['education'] as $edu)
                                            <div class="border-l-2 border-pink-200 pl-4">
                                                <div class="font-medium text-gray-900">{{ $edu['degree'] }}</div>
                                                <div class="text-sm text-gray-600">{{ $edu['school'] }}</div>
                                                <div class="text-xs text-gray-500">{{ $edu['year'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                        <i data-lucide="trophy" class="w-5 h-5 text-pink-600"></i>
                                        Onderscheidingen
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach ($talent['awards'] as $award)
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                                                <span class="text-sm text-gray-700">{{ $award }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                    <i data-lucide="briefcase" class="w-5 h-5 text-pink-600"></i>
                                    Certificeringen
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($talent['certifications'] as $cert)
                                        <div
                                            class="inline-flex items-center rounded-full border border-transparent bg-blue-100 text-blue-700 hover:bg-blue-200 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                                            {{ $cert }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div id="content-reviews" class="tab-content space-y-6 hidden">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-gray-900">Klant Reviews</h3>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-gray-900">{{ $talent['rating'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $talent['reviewCount'] }} reviews</div>
                                </div>
                            </div>

                            <!-- Review Stats -->
                            <div class="rounded-lg border bg-gradient-to-r from-blue-50 to-purple-50">
                                <div class="p-6">
                                    <div class="grid grid-cols-3 gap-4 text-center">
                                        <div>
                                            <div class="text-2xl font-bold text-blue-600">{{ $talent['repeatClients'] }}
                                            </div>
                                            <div class="text-sm text-gray-600">Terugkerende klanten</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-green-600">{{ $talent['onTimeDelivery'] }}
                                            </div>
                                            <div class="text-sm text-gray-600">Op tijd opgeleverd</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-purple-600">{{ $talent['responseTime'] }}
                                            </div>
                                            <div class="text-sm text-gray-600">Reactietijd</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                @foreach ($talent['reviews'] as $review)
                                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                        <div class="p-6">
                                            <div class="flex items-start gap-4">
                                                <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                                    <div
                                                        class="flex h-full w-full items-center justify-center rounded-full bg-gray-100">
                                                        {{ $review['avatar'] }}
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <div class="flex items-center gap-2">
                                                            <h4 class="font-semibold text-gray-900">{{ $review['name'] }}
                                                            </h4>
                                                            @if ($review['verified'])
                                                                <i data-lucide="check-circle"
                                                                    class="w-4 h-4 text-green-600"
                                                                    title="Geverifieerde klant"></i>
                                                            @endif
                                                        </div>
                                                        <span class="text-sm text-gray-500">{{ $review['date'] }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1 mb-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star"
                                                                class="w-4 h-4 {{ $i <= $review['rating'] ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                        <span class="text-sm text-gray-600 ml-2">Project:
                                                            {{ $review['project'] }}</span>
                                                    </div>
                                                    <p class="text-gray-700">{{ $review['comment'] }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Q&A Tab -->
                        <div id="content-qa" class="tab-content space-y-6 hidden">
                            <div class="mt-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-6">Veelgestelde Vragen</h3>

                                <div class="space-y-4">
                                    @foreach ($talent['faqs'] as $index => $faq)
                                        <div class="faq-item border border-gray-200 rounded-lg">
                                            <button type="button"
                                                class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200"
                                                data-target="faq-{{ $index }}">
                                                <span class="font-medium text-gray-900">{{ $faq['question'] }}</span>
                                                <i data-lucide="chevron-down"
                                                    class="faq-icon w-5 h-5 text-gray-500 transition-transform duration-200"></i>
                                            </button>
                                            <div id="faq-{{ $index }}" class="faq-content hidden px-6 pb-4">
                                                <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <!-- Booking Card -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-lg">
                            <div class="p-6">
                                <div class="text-center mb-6">
                                    <div class="text-3xl font-bold text-gray-900 mb-2">
                                        Beschikbaar voor projecten
                                    </div>
                                    <p class="text-gray-600">Neem contact op voor een offerte</p>
                                    <div class="text-lg font-semibold text-pink-600 mt-2">
                                        {{ $talent['priceRange'] }}
                                    </div>
                                </div>

                                <div class="space-y-3 mb-6">
                                    <button onclick="openBookingForm()"
                                        class="w-full bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white font-semibold py-3 px-4 rounded-md transition-colors">
                                        Boek Nu
                                    </button>
                                    <button onclick="toggleFavorite()"
                                        class="w-full border-2 border-gray-300 hover:bg-gray-50 py-3 px-4 rounded-md flex items-center justify-center gap-2 transition-colors">
                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                        Voeg toe aan Favorieten
                                    </button>
                                </div>

                                <div class="space-y-3 text-sm text-gray-600 border-t pt-4">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        <span>Reactietijd: {{ $talent['responseTime'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                                        <span>{{ $talent['location'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="award" class="w-4 h-4"></i>
                                        <span>{{ $talent['completedProjects'] }} voltooide projecten</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="globe" class="w-4 h-4"></i>
                                        <span>Talen: {{ implode(', ', array_slice($talent['languages'], 0, 2)) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instagram Feed -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-lg">
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <i data-lucide="instagram" class="w-5 h-5 text-pink-600"></i>
                                    <h3 class="font-semibold text-gray-900">Instagram Feed</h3>
                                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                                        class="ml-auto text-pink-600 hover:text-pink-700">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    @foreach ($talent['instagramPosts'] as $post)
                                        <div class="relative group cursor-pointer">
                                            <div class="aspect-square overflow-hidden rounded-lg">
                                                <img src="{{ $post['image'] }}" alt="Instagram post"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                                            </div>

                                            <!-- Hover overlay -->
                                            <div
                                                class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                                                <div class="text-white text-center">
                                                    <div class="flex items-center justify-center gap-4 mb-2">
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="heart" class="w-4 h-4 fill-current"></i>
                                                            <span class="text-sm">{{ $post['likes'] }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="message-circle" class="w-4 h-4"></i>
                                                            <span class="text-sm">{{ $post['comments'] }}</span>
                                                        </div>
                                                    </div>
                                                    <p class="text-xs px-2 line-clamp-2">{{ $post['caption'] }}</p>
                                                </div>
                                            </div>

                                            <!-- Time indicator -->
                                            <div
                                                class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                                {{ $post['timeAgo'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4 text-center">
                                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                                        class="text-pink-600 hover:text-pink-700 font-medium text-sm flex items-center justify-center gap-2">
                                        <i data-lucide="instagram" class="w-4 h-4"></i>
                                        Bekijk meer op Instagram
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Options -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-900 mb-4">Contact Opties</h3>
                                <div class="space-y-3">
                                    <button
                                        class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
                                        <i data-lucide="phone" class="w-4 h-4"></i>
                                        Bel Direct
                                    </button>
                                    <button
                                        class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
                                        <i data-lucide="mail" class="w-4 h-4"></i>
                                        Email
                                    </button>
                                    <button
                                        class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
                                        <i data-lucide="message-circle" class="w-4 h-4"></i>
                                        WhatsApp
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Trust & Safety -->
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="shield" class="w-5 h-5 text-green-600"></i>
                                    Vertrouwen & Veiligheid
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center gap-2 text-green-600">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span>Identiteit geverifieerd</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-green-600">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span>Betalingen beveiligd</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-green-600">
                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                        <span>24/7 klantenservice</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Lightbox Modal -->
    <div id="portfolio-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="relative">
                <!-- Close button -->
                <button onclick="closePortfolioModal()"
                    class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors">
                    <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
                </button>

                <!-- Modal content -->
                <div id="modal-content" class="p-6">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedPortfolioItem = null;

        function switchTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            const tabs = document.querySelectorAll('[id^="tab-"]');
            tabs.forEach(tab => {
                tab.classList.remove('bg-background', 'text-foreground', 'shadow-sm');
            });

            // Show selected tab content
            const selectedContent = document.getElementById(`content-${tabName}`);
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }

            // Add active class to selected tab
            const selectedTab = document.getElementById(`tab-${tabName}`);
            if (selectedTab) {
                selectedTab.classList.add('bg-background', 'text-foreground', 'shadow-sm');
            }
        }

        function handlePortfolioClick(item) {
            selectedPortfolioItem = item;
            openPortfolioModal();
        }

        function openPortfolioModal() {
            if (!selectedPortfolioItem) return;

            const modal = document.getElementById('portfolio-modal');
            const modalContent = document.getElementById('modal-content');

            modalContent.innerHTML = `
        <div class="space-y-6">
          <!-- Portfolio Image -->
          <div class="relative">
            <img src="${selectedPortfolioItem.image}" alt="${selectedPortfolioItem.title}"
                 class="w-full h-96 object-cover rounded-lg">
          </div>

          <!-- Portfolio Details -->
          <div class="space-y-4">
            <div>
              <h2 class="text-3xl font-bold text-gray-900 mb-2">${selectedPortfolioItem.title}</h2>
              <p class="text-gray-600 text-lg">${selectedPortfolioItem.description}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Doelstelling</h3>
                <p class="text-gray-700 leading-relaxed">${selectedPortfolioItem.projectObjective}</p>
              </div>

              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Project Resultaat</h3>
                <p class="text-gray-700 leading-relaxed">${selectedPortfolioItem.projectResult}</p>
              </div>
            </div>

            <div class="border-t pt-4">
              <div class="flex items-center justify-between">
                <div>
                  <span class="text-sm text-gray-500">Client</span>
                  <p class="font-semibold text-gray-900">${selectedPortfolioItem.clientName}</p>
                </div>
                <div class="flex gap-3">
                  <button onclick="sharePortfolio()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    <i data-lucide="share-2" class="w-4 h-4"></i>
                    Delen
                  </button>
                  <button onclick="contactAboutProject()" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 text-white rounded-md transition-colors">
                    <i data-lucide="message-circle" class="w-4 h-4"></i>
                    Contact over dit project
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Re-initialize Lucide icons for the modal content
            lucide.createIcons();
        }

        function closePortfolioModal() {
            const modal = document.getElementById('portfolio-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            selectedPortfolioItem = null;
        }

        function sharePortfolio() {
            if (selectedPortfolioItem) {
                if (navigator.share) {
                    navigator.share({
                        title: `${selectedPortfolioItem.title} - {{ $talent['name'] }}`,
                        text: selectedPortfolioItem.description,
                        url: window.location.href,
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Portfolio link gekopieerd naar klembord!');
                }
            }
        }

        function contactAboutProject() {
            if (selectedPortfolioItem) {
                alert(
                    `Contact over "${selectedPortfolioItem.title}" - bericht functionaliteit zou hier geïmplementeerd worden`);
            }
        }

        // Close modal when clicking outside
        document.getElementById('portfolio-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePortfolioModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePortfolioModal();
            }
        });

        function handleShare() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $talent['name'] }} - {{ $talent['profession'] }}',
                    text: '{{ $talent['description'] }}',
                    url: window.location.href,
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Profiel link gekopieerd naar klembord!');
            }
        }

        function handleReport() {
            alert('Rapporteer functionaliteit zou hier geïmplementeerd worden');
        }

        function playVideo() {
            alert('Video afspelen functionaliteit zou hier geïmplementeerd worden');
        }

        function downloadPortfolio() {
            alert('Portfolio download functionaliteit zou hier geïmplementeerd worden');
        }

        function openBookingForm() {
            alert('Boekingsformulier openen - functionaliteit zou hier geïmplementeerd worden');
        }

        function contactTalent() {
            alert('Bericht sturen functionaliteit zou hier geïmplementeerd worden');
        }

        function toggleFavorite() {
            alert('{{ $talent['name'] }} is toegevoegd aan je favorieten!');
        }

        // FAQ Accordion functionality
        function toggleFAQ(targetId) {
            const content = document.getElementById(targetId);
            const button = document.querySelector(`[data-target="${targetId}"]`);
            const icon = button.querySelector('.faq-icon');

            if (content.classList.contains('hidden')) {
                // Close all other FAQs
                document.querySelectorAll('.faq-content').forEach(item => {
                    if (item.id !== targetId) {
                        item.classList.add('hidden');
                        const otherButton = document.querySelector(`[data-target="${item.id}"]`);
                        const otherIcon = otherButton.querySelector('.faq-icon');
                        otherIcon.style.transform = 'rotate(0deg)';
                    }
                });

                // Open this FAQ
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                // Close this FAQ
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            switchTab('portfolio');

            // Add FAQ button event listeners
            document.querySelectorAll('.faq-button').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    toggleFAQ(targetId);
                });
            });
        });
    </script>
@endsection
