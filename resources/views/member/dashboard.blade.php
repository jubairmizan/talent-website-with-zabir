@extends('layouts.landing')

@section('title', 'Member Dashboard - Curaçao Talents')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-2">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-auto object-contain"
                            style="height: 65px;">
                    </a>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center gap-8">
                        <a href="/" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Home
                        </a>
                        <a href="/talents" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Discover Talents
                        </a>
                        {{-- <a href="/blog" class="text-gray-700 hover:text-pink-600 transition-colors">
              Blog
            </a> --}}
                        <a href="/about" class="text-gray-700 hover:text-pink-600 transition-colors">
                            About
                        </a>
                        <a href="/contact" class="text-gray-700 hover:text-pink-600 transition-colors">
                            Contact
                        </a>
                    </nav>

                    <!-- User Actions -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600">
                                Welcome, Member
                            </span>
                            <a href="/dashboard">
                                <button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                    Dashboard
                                </button>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                    <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="container mx-auto px-6 py-8">
            <!-- Success/Status Messages -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md mb-6"
                    id="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mijn Dashboard</h1>
                    <p class="text-gray-600">Beheer je boekingen en ontdek nieuwe talenten</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        <i data-lucide="bell" class="w-4 h-4 mr-2"></i>
                        Notificaties
                    </button>
                    <!-- <button
                                                                  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                                                  <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                                  Nieuwe Boeking
                                                                </button> -->
                </div>
            </div>

            <!-- Facebook-style Chat Button -->
            <button id="messages-toggle" onclick="toggleMessagesPanel()"
                class="fixed bottom-4 right-4 z-[100] bg-gradient-to-r from-pink-500 to-orange-500 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i data-lucide="message-circle" class="w-6 h-6"></i>
            </button>

            <!-- Tabs -->
            <div class="row">
                <div id="main-content" class="col-lg-12 space-y-6 transition-all duration-500 ease-in-out">
                    <div
                        class="inline-flex h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground w-full grid grid-cols-3">
                        <button id="tab-overview" onclick="switchTab('overview')"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-background text-foreground shadow-sm">Overzicht</button>
                        <!-- <button id="tab-bookings" onclick="switchTab('bookings')"
                                                                  class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Boekingen</button> -->
                        <button id="tab-favorites" data-tab="favorites" onclick="switchTab('favorites')"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Favorieten</button>
                        <!-- <button id="tab-reviews" onclick="switchTab('reviews')"
                                                                  class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Reviews</button> -->
                        <button id="tab-profile" data-tab="profile" onclick="switchTab('profile')"
                            class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Profiel</button>
                        <!-- <button id="tab-messages" onclick="switchTab('messages')"
                                                                  class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Berichten</button> -->
                    </div>

                    <!-- Overview Tab -->
                    <div id="content-overview" class="tab-content space-y-6">
                        <!-- Stats Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            <!-- <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                                                    <div class="p-6">
                                                                      <div class="flex items-center justify-between">
                                                                        <div>
                                                                          <p class="text-sm text-gray-600">Totaal Boekingen</p>
                                                                          <p class="text-2xl font-bold">{{ $userStats['totalBookings'] }}</p>
                                                                        </div>
                                                                        <i data-lucide="calendar" class="w-8 h-8 text-blue-500"></i>
                                                                      </div>
                                                                    </div>
                                                                  </div>

                                                                  <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                                                    <div class="p-6">
                                                                      <div class="flex items-center justify-between">
                                                                        <div>
                                                                          <p class="text-sm text-gray-600">Voltooid</p>
                                                                          <p class="text-2xl font-bold">{{ $userStats['completedBookings'] }}</p>
                                                                        </div>
                                                                        <i data-lucide="star" class="w-8 h-8 text-green-500"></i>
                                                                      </div>
                                                                    </div>
                                                                  </div> -->

                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-600">Ongelezen Berichten</p>
                                            <p class="text-2xl font-bold">{{ $userStats['unreadMessages'] ?? 0 }}</p>
                                        </div>
                                        <i data-lucide="message-circle" class="w-8 h-8 text-blue-500"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-600">Number of Favoriete Creators</p>
                                            <p id="favorites-count" class="text-2xl font-bold">
                                                {{ $userStats['savedCreators'] }}</p>
                                        </div>
                                        <i data-lucide="heart" class="w-8 h-8 text-pink-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
                            <!-- <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                                                    <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                                                      <h3 class="text-2xl font-semibold leading-none tracking-tight">Aankomende Boekingen</h3>
                                                                    </div>
                                                                    <div class="p-6">
                                                                      <div class="space-y-4">
                                                                        @foreach ($bookings as $booking)
    @if ($booking['status'] !== 'completed')
    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-lg">
                                                                              <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                                                                <img src="{{ $booking['creatorImage'] }}" alt="{{ $booking['creator'] }}" class="aspect-square h-full w-full" />
                                                                              </div>
                                                                              <div class="flex-1">
                                                                                <p class="font-semibold">{{ $booking['creator'] }}</p>
                                                                                <p class="text-sm text-gray-600">{{ $booking['service'] }}</p>
                                                                                <div class="flex items-center gap-4 text-xs text-gray-500 mt-1">
                                                                                  <span class="flex items-center gap-1">
                                                                                    <i data-lucide="calendar" class="w-3 h-3"></i>
                                                                                    {{ $booking['date'] }}
                                                                                  </span>
                                                                                  <span class="flex items-center gap-1">
                                                                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                                                                    {{ $booking['time'] }}
                                                                                  </span>
                                                                                  <span class="flex items-center gap-1">
                                                                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                                                                    {{ $booking['location'] }}
                                                                                  </span>
                                                                                </div>
                                                                              </div>
                                                                              <div class="text-right">
                                                                                <div
                                                                                  class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                            @if ($booking['status'] === 'confirmed') border-transparent bg-secondary text-secondary-foreground @else text-foreground @endif">
                                                                                  @if ($booking['status'] === 'confirmed')
    Bevestigd
@else
    In behandeling
    @endif
                                                                                </div>
                                                                                <p class="text-sm font-semibold mt-1">€{{ $booking['amount'] }}</p>
                                                                              </div>
                                                                            </div>
    @endif
    @endforeach
                                                                      </div>
                                                                    </div>
                                                                  </div> -->

                            <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">List of Favoriete
                                        Creators</h3>
                                </div>
                                <div class="p-6">
                                    <!-- Loading indicator -->
                                    <div id="overview-favorites-loading" class="text-center py-4">
                                        <div
                                            class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-pink-500">
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600">Favorieten laden...</p>
                                    </div>

                                    <!-- Error message -->
                                    <div id="overview-favorites-error"
                                        class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                                        <p class="text-sm">Er is een fout opgetreden bij het laden van je favorieten.</p>
                                    </div>

                                    <!-- Empty state -->
                                    <div id="overview-favorites-empty" class="hidden text-center py-8">
                                        <div
                                            class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <i data-lucide="heart" class="w-8 h-8 text-gray-400"></i>
                                        </div>
                                        <h4 class="text-md font-semibold text-gray-900 mb-2">Nog geen favorieten</h4>
                                        <p class="text-sm text-gray-600 mb-3">Je hebt nog geen creators toegevoegd aan je
                                            favorieten.</p>
                                        <a href="/talents"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:opacity-90 h-9 px-3">
                                            Ontdek Creators
                                        </a>
                                    </div>

                                    <!-- Favorites list -->
                                    <div id="overview-favorites-list" class="hidden space-y-4">
                                        <!-- Dynamic content will be inserted here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Tab -->
                    <!-- <div id="content-bookings" class="tab-content space-y-6 hidden">
                                                                <div class="flex items-center justify-between">
                                                                  <h2 class="text-2xl font-bold">Mijn Boekingen</h2>
                                                                  <div class="flex gap-2">
                                                                    <button
                                                                      class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                                                      <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                                                                      Filter
                                                                    </button>
                                                                    <button
                                                                      class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                                                      <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                                                      Nieuwe Boeking
                                                                    </button>
                                                                  </div>
                                                                </div>

                                                                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                                                  <div class="p-0">
                                                                    <div class="space-y-4 p-6">
                                                                      @foreach ($bookings as $booking)
    <div class="flex items-center justify-between p-6 border rounded-lg hover:shadow-md transition-shadow">
                                                                          <div class="flex items-center gap-4">
                                                                            <div class="relative flex h-16 w-16 shrink-0 overflow-hidden rounded-full">
                                                                              <img src="{{ $booking['creatorImage'] }}" alt="{{ $booking['creator'] }}" class="aspect-square h-full w-full" />
                                                                            </div>
                                                                            <div>
                                                                              <p class="font-semibold text-lg">{{ $booking['creator'] }}</p>
                                                                              <p class="text-gray-600">{{ $booking['service'] }}</p>
                                                                              <div class="flex items-center gap-4 text-sm text-gray-500 mt-2">
                                                                                <span class="flex items-center gap-1">
                                                                                  <i data-lucide="calendar" class="w-4 h-4"></i>
                                                                                  {{ $booking['date'] }}
                                                                                </span>
                                                                                <span class="flex items-center gap-1">
                                                                                  <i data-lucide="clock" class="w-4 h-4"></i>
                                                                                  {{ $booking['time'] }}
                                                                                </span>
                                                                                <span class="flex items-center gap-1">
                                                                                  <i data-lucide="map-pin" class="w-4 h-4"></i>
                                                                                  {{ $booking['location'] }}
                                                                                </span>
                                                                              </div>
                                                                            </div>
                                                                          </div>
                                                                          <div class="flex items-center gap-4">
                                                                            <div class="text-right">
                                                                              <div
                                                                                class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                          @if ($booking['status'] === 'completed') border-transparent bg-primary text-primary-foreground
                          @elseif($booking['status'] === 'confirmed') border-transparent bg-secondary text-secondary-foreground
                          @else text-foreground @endif">
                                                                                @if ($booking['status'] === 'completed')
    Voltooid
@elseif($booking['status'] === 'confirmed')
    Bevestigd
@else
    In behandeling
    @endif
                                                                              </div>
                                                                              <p class="font-semibold text-lg mt-1">€{{ $booking['amount'] }}</p>
                                                                            </div>
                                                                            <div class="flex gap-2">
                                                                              <button
                                                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                                                                <i data-lucide="message-square" class="w-4 h-4"></i>
                                                                              </button>
                                                                              @if ($booking['status'] === 'completed')
    <button
                                                                                  class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                                                                                  <i data-lucide="star" class="w-4 h-4"></i>
                                                                                </button>
    @endif
                                                                            </div>
                                                                          </div>
                                                                        </div>
    @endforeach
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div> -->

                    <!-- Favorites Tab -->
                    <div id="content-favorites" class="tab-content space-y-6 hidden">
                        <div class="flex items-center justify-between">
                            <h2 class="text-3xl font-bold tracking-tight">Mijn Favorieten</h2>
                            <div class="relative">
                                <i data-lucide="search"
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4"></i>
                                <input type="text" id="favorites-search" placeholder="Zoek creators..."
                                    class="pl-10 pr-4 py-2 border border-input bg-background rounded-md text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            </div>
                        </div>

                        <!-- Loading indicator -->
                        <div id="favorites-loading" class="text-center py-8">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pink-500"></div>
                            <p class="mt-2 text-gray-600">Favorieten laden...</p>
                        </div>

                        <!-- Error message -->
                        <div id="favorites-error"
                            class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                            <p>Er is een fout opgetreden bij het laden van je favorieten. Probeer de pagina te vernieuwen.
                            </p>
                        </div>

                        <!-- Empty state -->
                        <div id="favorites-empty" class="hidden text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="heart" class="w-12 h-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nog geen favorieten</h3>
                            <p class="text-gray-600 mb-4">Je hebt nog geen creators toegevoegd aan je favorieten.</p>
                            <a href="/talents"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:opacity-90 h-10 px-4 py-2">
                                Ontdek Creators
                            </a>
                        </div>

                        <!-- Favorites grid -->
                        <div id="favorites-grid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Dynamic content will be inserted here -->
                        </div>
                    </div>

                    <!-- Reviews Tab -->
                    <div id="content-reviews" class="tab-content space-y-6 hidden">
                        <div class="flex items-center justify-between">
                            <h2 class="text-3xl font-bold tracking-tight">Mijn Reviews</h2>
                            <button
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:opacity-90 h-10 px-4 py-2">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Review Schrijven
                            </button>
                        </div>

                        <div class="space-y-6">
                            @foreach ($reviews as $review)
                                <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                                    <div class="p-6">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex items-center gap-4">
                                                <div class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                                    <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $review['creator'] }}"
                                                        alt="{{ $review['creator'] }}"
                                                        class="aspect-square h-full w-full">
                                                    <span
                                                        class="flex h-full w-full items-center justify-center rounded-full bg-muted">{{ substr($review['creator'], 0, 2) }}</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold">{{ $review['creator'] }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $review['service'] }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="flex items-center mb-1">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i data-lucide="star"
                                                            class="w-4 h-4 {{ $i <= $review['rating'] ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-gray-500">{{ $review['date'] }}</span>
                                            </div>
                                        </div>

                                        <p class="text-gray-700 mb-4">{{ $review['comment'] }}</p>

                                        <div class="flex items-center gap-2">
                                            <button
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 px-3">
                                                <i data-lucide="edit" class="w-4 h-4"></i>
                                                Bewerken
                                            </button>
                                            <button
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 px-3">
                                                <i data-lucide="share-2" class="w-4 h-4"></i>
                                                Delen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Profile Tab -->
                    <div id="content-profile" class="tab-content space-y-6 hidden">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Profiel Instellingen</h3>
                            </div>
                            <div class="p-6 pt-0 space-y-6">
                                <!-- Loading indicator -->
                                <div id="profile-loading" class="text-center py-4">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-pink-500">
                                    </div>
                                    <p class="mt-2 text-gray-600">Profiel laden...</p>
                                </div>

                                <!-- Error message -->
                                <div id="profile-error"
                                    class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                                    <p>Er is een fout opgetreden bij het laden van je profiel. Probeer de pagina te
                                        vernieuwen.</p>
                                </div>

                                <!-- Success message -->
                                <div id="profile-success"
                                    class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                                    <p>Profiel succesvol bijgewerkt!</p>
                                </div>

                                <!-- Profile form -->
                                <form id="profile-form" class="hidden space-y-6">
                                    @csrf
                                    <div class="flex items-center gap-6">
                                        <div class="relative flex h-24 w-24 shrink-0 overflow-hidden rounded-full">
                                            <img id="profile-avatar" src="" alt="Profile"
                                                class="aspect-square h-full w-full">
                                            <span id="profile-initials"
                                                class="flex h-full w-full items-center justify-center rounded-full bg-muted text-lg font-semibold"></span>
                                        </div>
                                        <div>
                                            <button type="button"
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                                Foto Uploaden
                                            </button>
                                            <p class="text-sm text-gray-600 mt-2">JPG, PNG of GIF. Max 2MB.</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="userFirstName"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Voornaam</label>
                                            <input id="userFirstName" name="first_name" required
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="userLastName"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Achternaam</label>
                                            <input id="userLastName" name="last_name" required
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="userEmail"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                                            <input id="userEmail" name="email" type="email" required
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        </div>
                                        <div class="space-y-2">
                                            <label for="userLocation"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Locatie</label>
                                            <input id="userLocation" name="location"
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="userBio"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bio</label>
                                        <textarea id="userBio" name="bio" rows="3" placeholder="Vertel iets over jezelf..."
                                            class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                                    </div>

                                    <div class="space-y-2">
                                        <label for="userInterests"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Interesses</label>
                                        <input id="userInterests" name="interests"
                                            placeholder="Bijv. fotografie, muziek, design..."
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    </div>

                                    <button type="submit" id="save-profile-btn"
                                        class="w-full inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-gradient-to-r from-pink-500 to-orange-500 text-primary-foreground hover:opacity-90 h-10 px-4 py-2">
                                        <span class="save-text">Profiel Opslaan</span>
                                        <div class="save-loading hidden">
                                            <div
                                                class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white">
                                            </div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Tab -->
                    <div id="content-messages" class="tab-content space-y-6 hidden">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Berichten</h3>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="space-y-4">
                                    @for ($i = 1; $i <= 3; $i++)
                                        <div
                                            class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                                <img src="https://api.dicebear.com/7.x/initials/svg?seed=Creator{{ $i }}"
                                                    alt="Creator {{ $i }}"
                                                    class="aspect-square h-full w-full">
                                                <span
                                                    class="flex h-full w-full items-center justify-center rounded-full bg-muted">C{{ $i }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-semibold">Creator {{ $i }}</p>
                                                    <span class="text-xs text-gray-500">1 uur geleden</span>
                                                </div>
                                                <p class="text-sm text-gray-600">Bedankt voor je boeking! Ik kijk ernaar
                                                    uit om met je te werken...</p>
                                            </div>
                                            <div
                                                class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">
                                                Nieuw
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facebook-style Chat Panel (Initially Hidden) -->
                <div id="messages-panel"
                    class="fixed bottom-20 right-4 w-80 bg-white rounded-lg shadow-xl z-[100] hidden transform translate-y-full transition-all duration-300 ease-in-out">
                    <div class="flex flex-col h-[500px] border border-gray-200 rounded-lg">
                        <!-- Header -->
                        <div class="flex items-center justify-between p-3 border-b">
                            <div>
                                <h3 class="font-semibold text-lg">Gesprekken</h3>
                                <p class="text-xs text-gray-500">Actieve creators</p>
                            </div>
                            <button onclick="toggleMessagesPanel()"
                                class="text-gray-500 hover:text-gray-700 transition-colors">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="p-3 border-b">
                            <div class="relative">
                                <input type="text" placeholder="Zoek creators..."
                                    class="w-full pl-8 pr-3 py-1 text-sm border rounded-full focus:outline-none focus:ring-1 focus:ring-pink-500">
                                <i data-lucide="search"
                                    class="w-4 h-4 absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Creator List -->
                        <div class="flex-1 overflow-y-auto p-2">
                            <div id="chat-list" class="space-y-1">
                                <!-- Active creators will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

            // Load data based on active tab
            if (tabName === 'profile') {
                loadProfileData();
            } else if (tabName === 'favorites') {
                loadFavoritesData();
            }
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('overview');
            loadFavoritesCount();
            loadOverviewFavorites();
        });

        // Profile management functions
        function loadProfileData() {
            const loadingEl = document.getElementById('profile-loading');
            const errorEl = document.getElementById('profile-error');
            const formEl = document.getElementById('profile-form');

            // Show loading state
            loadingEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            formEl.classList.add('hidden');

            fetch('/member/profile', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateProfileForm(data.data);
                        loadingEl.classList.add('hidden');
                        formEl.classList.remove('hidden');
                    } else {
                        throw new Error(data.message || 'Failed to load profile data');
                    }
                })
                .catch(error => {
                    console.error('Error loading profile:', error);
                    loadingEl.classList.add('hidden');
                    errorEl.classList.remove('hidden');
                });
        }

        function populateProfileForm(profileData) {
            // Populate user data
            document.getElementById('userFirstName').value = profileData.first_name || '';
            document.getElementById('userLastName').value = profileData.last_name || '';
            document.getElementById('userEmail').value = profileData.email || '';

            // Populate profile data
            document.getElementById('userLocation').value = profileData.location || '';
            document.getElementById('userBio').value = profileData.bio || '';
            document.getElementById('userInterests').value = profileData.interests || '';

            // Handle avatar
            const avatarImg = document.getElementById('profile-avatar');
            const initialsSpan = document.getElementById('profile-initials');

            if (profileData.avatar) {
                avatarImg.src = profileData.avatar;
                avatarImg.style.display = 'block';
                initialsSpan.style.display = 'none';
            } else {
                // Generate initials
                const firstName = profileData.first_name || '';
                const lastName = profileData.last_name || '';
                const initials = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
                initialsSpan.textContent = initials || 'U';
                avatarImg.style.display = 'none';
                initialsSpan.style.display = 'flex';
            }
        }

        // Handle profile form submission
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const saveBtn = document.getElementById('save-profile-btn');
            const saveText = saveBtn.querySelector('.save-text');
            const saveLoading = saveBtn.querySelector('.save-loading');
            const successEl = document.getElementById('profile-success');
            const errorEl = document.getElementById('profile-error');

            // Show loading state
            saveBtn.disabled = true;
            saveText.classList.add('hidden');
            saveLoading.classList.remove('hidden');
            successEl.classList.add('hidden');
            errorEl.classList.add('hidden');

            const formData = new FormData(this);

            fetch('/member/profile', {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        successEl.classList.remove('hidden');
                        // Optionally reload profile data to reflect any server-side changes
                        setTimeout(() => {
                            successEl.classList.add('hidden');
                        }, 5000);
                    } else {
                        throw new Error(data.message || 'Failed to update profile');
                    }
                })
                .catch(error => {
                    console.error('Error updating profile:', error);
                    errorEl.querySelector('p').textContent =
                        'Er is een fout opgetreden bij het opslaan van je profiel. Probeer het opnieuw.';
                    errorEl.classList.remove('hidden');
                })
                .finally(() => {
                    // Reset button state
                    saveBtn.disabled = false;
                    saveText.classList.remove('hidden');
                    saveLoading.classList.add('hidden');
                });
        });

        // Favorites functionality
        let allFavorites = [];
        let filteredFavorites = [];

        function loadFavoritesData() {
            const loadingDiv = document.getElementById('favorites-loading');
            const errorDiv = document.getElementById('favorites-error');
            const emptyDiv = document.getElementById('favorites-empty');
            const gridDiv = document.getElementById('favorites-grid');

            // Show loading state
            loadingDiv.classList.remove('hidden');
            errorDiv.classList.add('hidden');
            emptyDiv.classList.add('hidden');
            gridDiv.classList.add('hidden');

            fetch('/member/favorites', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    loadingDiv.classList.add('hidden');

                    if (data.success) {
                        allFavorites = data.data;
                        filteredFavorites = [...allFavorites];

                        if (allFavorites.length === 0) {
                            emptyDiv.classList.remove('hidden');
                        } else {
                            displayFavorites(filteredFavorites);
                            gridDiv.classList.remove('hidden');
                        }
                    } else {
                        throw new Error(data.message || 'Failed to load favorites');
                    }
                })
                .catch(error => {
                    console.error('Error loading favorites:', error);
                    loadingDiv.classList.add('hidden');
                    errorDiv.classList.remove('hidden');
                });
        }

        function displayFavorites(favorites) {
            const gridDiv = document.getElementById('favorites-grid');

            if (favorites.length === 0) {
                gridDiv.innerHTML =
                    '<div class="col-span-full text-center py-8 text-gray-500">Geen creators gevonden met deze zoekopdracht.</div>';
                return;
            }

            gridDiv.innerHTML = favorites.map(creator => `
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm cursor-pointer hover:shadow-lg transition-shadow" onclick="window.location.href='/talent/${creator.id}'">
          <div class="p-6">
            <div class="relative mb-4">
              <div class="relative flex h-48 w-full overflow-hidden rounded-lg">
                <img src="${creator.image}" alt="${creator.name}" class="object-cover aspect-square h-full w-full">
              </div>
              <button onclick="event.stopPropagation(); removeFavorite(${creator.id})" class="absolute top-2 right-2 inline-flex items-center justify-center rounded-full w-8 h-8 bg-red-500 text-white hover:bg-red-600 transition-colors">
                <i data-lucide="heart" class="w-4 h-4 fill-current"></i>
              </button>
            </div>

            <div class="space-y-2">
              <h3 class="font-semibold text-lg">${creator.name}</h3>
              <p class="text-sm text-gray-600">${creator.profession}</p>

              <div class="flex items-center gap-2">
                <div class="text-sm font-medium text-blue-600">
                  ${creator.total_likes || 0} likes
                </div>
              </div>




            </div>
          </div>
        </div>
      `).join('');

            // Re-initialize Lucide icons for the new content
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }



        function removeFavorite(creatorId) {
            if (!confirm('Weet je zeker dat je deze creator uit je favorieten wilt verwijderen?')) {
                return;
            }

            fetch('/member/favorites', {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        creator_profile_id: creatorId
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Remove from local arrays
                        allFavorites = allFavorites.filter(creator => creator.id !== creatorId);
                        filteredFavorites = filteredFavorites.filter(creator => creator.id !== creatorId);

                        // Re-display favorites
                        if (allFavorites.length === 0) {
                            document.getElementById('favorites-grid').classList.add('hidden');
                            document.getElementById('favorites-empty').classList.remove('hidden');
                        } else {
                            displayFavorites(filteredFavorites);
                        }

                        // Update overview favorites and count
                        loadFavoritesCount();
                        loadOverviewFavorites();
                    } else {
                        throw new Error(data.message || 'Failed to remove favorite');
                    }
                })
                .catch(error => {
                    console.error('Error removing favorite:', error);
                    alert('Er is een fout opgetreden bij het verwijderen van de favoriet.');
                });
        }

        // Search functionality for favorites
        document.getElementById('favorites-search').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            filteredFavorites = allFavorites.filter(creator =>
                creator.name.toLowerCase().includes(searchTerm) ||
                creator.profession.toLowerCase().includes(searchTerm)
            );

            displayFavorites(filteredFavorites);
        });

        // Load favorites count
        function loadFavoritesCount() {
            fetch('/member/favorites/count', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('favorites-count').textContent = data.count;
                    }
                })
                .catch(error => {
                    console.error('Error loading favorites count:', error);
                    document.getElementById('favorites-count').textContent = '0';
                });
        }

        // Load favorites for overview section
        function loadOverviewFavorites() {
            const loadingEl = document.getElementById('overview-favorites-loading');
            const errorEl = document.getElementById('overview-favorites-error');
            const emptyEl = document.getElementById('overview-favorites-empty');
            const listEl = document.getElementById('overview-favorites-list');

            // Show loading state
            loadingEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            emptyEl.classList.add('hidden');
            listEl.classList.add('hidden');

            fetch('/member/favorites', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    loadingEl.classList.add('hidden');

                    if (data.success && data.data && data.data.length > 0) {
                        displayOverviewFavorites(data.data.slice(0, 3)); // Show only first 3
                        listEl.classList.remove('hidden');
                    } else {
                        emptyEl.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error loading favorites:', error);
                    loadingEl.classList.add('hidden');
                    errorEl.classList.remove('hidden');
                });
        }

        function displayOverviewFavorites(favorites) {
            const listEl = document.getElementById('overview-favorites-list');

            listEl.innerHTML = favorites.map(creator => `
        <div class="flex items-center gap-4 cursor-pointer hover:bg-gray-50 p-3 rounded-lg transition-colors" onclick="window.location.href='/talent/${creator.id}'">
          <img src="${creator.image}" alt="${creator.name}" class="w-12 h-12 rounded-full object-cover" />
          <div class="flex-1">
            <p class="font-semibold">${creator.name}</p>
            <p class="text-sm text-gray-600">${creator.profession}</p>
            <div class="flex items-center gap-2 text-xs text-gray-500">
              <div class="flex items-center gap-1">
                <span class="text-blue-600">${creator.total_likes || 0} likes</span>
              </div>
            </div>
          </div>
          <div class="text-right">
            <button onclick="event.stopPropagation(); window.location.href='/talent/${creator.id}'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3 mt-1">
              Bekijk
            </button>
          </div>
        </div>
      `).join('');
        }



        // Event listeners for tab data loading are now handled in switchTab function

        // Load conversations on page load
        loadConversations();

        function loadConversations() {
            fetch('/member/conversations', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayConversations(data.conversations);
                    } else {
                        console.error('Error loading conversations:', data.message);
                        document.getElementById('chat-list').innerHTML =
                            '<p class="text-gray-500 text-center py-4">Error loading conversations</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('chat-list').innerHTML =
                        '<p class="text-gray-500 text-center py-4">Error loading conversations</p>';
                });
        }

        function displayConversations(conversations) {
            const chatList = document.getElementById('chat-list');

            if (conversations.length === 0) {
                chatList.innerHTML = '<p class="text-gray-500 text-center py-4">Geen gesprekken gevonden</p>';
                return;
            }

            chatList.innerHTML = conversations.map(conversation => `
        <div class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors" onclick="openConversation(${conversation.creator_id}, '${conversation.creator_name}')">
          <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <div class="flex h-full w-full items-center justify-center rounded-full bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold">
              ${conversation.creator_name.charAt(0).toUpperCase()}
            </div>
          </div>
          <div class="flex-1">
            <h4 class="font-semibold text-gray-900">${conversation.creator_name}</h4>
            <p class="text-sm text-gray-500">${conversation.last_message_at}</p>
          </div>
          <div class="text-right">
            <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400"></i>
          </div>
        </div>
      `).join('');

            // Re-initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function openConversation(creatorId, creatorName = null) {
            // Use the global chat interface to open conversation
            if (window.chatInterface) {
                window.chatInterface.openConversation(creatorId, creatorName);
            } else {
                console.error('Chat interface not available');
                alert('Chat system is loading. Please try again in a moment.');
            }
        }

        // Toggle Messages Panel Functionality
        let messagesPanelVisible = false;

        function toggleMessagesPanel() {
            const messagesPanel = document.getElementById('messages-panel');
            const toggleButton = document.getElementById('messages-toggle');

            if (!messagesPanelVisible) {
                // Show messages panel
                messagesPanel.classList.remove('hidden');
                setTimeout(() => {
                    messagesPanel.classList.remove('translate-y-full');
                    messagesPanel.classList.add('translate-y-0');
                    loadActiveCreators();
                }, 10);
                messagesPanelVisible = true;
            } else {
                // Hide messages panel
                messagesPanel.classList.remove('translate-y-0');
                messagesPanel.classList.add('translate-y-full');
                setTimeout(() => {
                    messagesPanel.classList.add('hidden');
                }, 300);
                messagesPanelVisible = false;
            }
        }

        // Load active creators for the chat panel
        function loadActiveCreators() {
            fetch('/api/creators/search?q=')
                .then(response => response.json())
                .then(creators => {
                    const chatList = document.getElementById('chat-list');
                    if (creators && creators.length > 0) {
                        chatList.innerHTML = creators.map(creator => `
              <div class="flex items-center p-2 hover:bg-gray-100 rounded-md cursor-pointer" onclick="openConversation(${creator.id}, '${creator.name}')">
                <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full mr-3">
                  <img src="${creator.image || 'https://via.placeholder.com/40'}" alt="${creator.name}" class="h-full w-full object-cover">
                  <span class="absolute bottom-0 right-0 h-2.5 w-2.5 rounded-full bg-green-500 border-2 border-white"></span>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-medium text-sm truncate">${creator.name}</p>
                  <p class="text-xs text-gray-500 truncate">${creator.profession || 'Creator'}</p>
                </div>
              </div>
            `).join('');
                    } else {
                        chatList.innerHTML =
                            '<p class="text-center text-gray-500 text-sm p-4">Geen actieve creators gevonden</p>';
                    }

                    // Re-initialize Lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                })
                .catch(error => {
                    console.error('Error loading creators:', error);
                    document.getElementById('chat-list').innerHTML =
                        '<p class="text-center text-gray-500 text-sm p-4">Fout bij het laden van creators</p>';
                });
        }
    </script>

    <!-- Chat Interface for authenticated users -->
    {{-- <x-chat-interface /> --}}
@endsection
