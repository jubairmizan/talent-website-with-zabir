@extends('layouts.landing')

@section('title', 'Creator Dashboard - Curaçao Talents')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="sticky top-0 z-50 border-b shadow-sm backdrop-blur-sm bg-white/95">
            <div class="container px-6 py-2 mx-auto">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="object-contain w-auto"
                            style="height: 64px;">
                    </a>

                    <!-- Navigation -->
                    <nav class="hidden gap-8 items-center md:flex">
                        <a href="/" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'"
                            onmouseout="this.style.color=''">
                            Home
                        </a>
                        <a href="/talents" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'"
                            onmouseout="this.style.color=''">
                            Discover Talents
                        </a>
                        {{-- <a href="/blog" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color=''">
              Blog
            </a> --}}
                        <a href="/about" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'"
                            onmouseout="this.style.color=''">
                            About
                        </a>
                        <a href="/contact" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'"
                            onmouseout="this.style.color=''">
                            Contact
                        </a>
                    </nav>

                    <!-- User Actions -->
                    <div class="flex gap-4 items-center">
                        <div class="flex gap-3 items-center">
                            <span class="text-sm text-gray-600">
                                Welcome, Creator
                            </span>
                            <a href="/dashboard">
                                <button
                                    class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium whitespace-nowrap rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground">
                                    <i data-lucide="user" class="mr-2 w-4 h-4"></i>
                                    Dashboard
                                </button>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium whitespace-nowrap rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground">
                                    <i data-lucide="log-out" class="mr-2 w-4 h-4"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container px-6 py-8 mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Creator Dashboard</h1>
                    <p class="text-gray-600">Beheer je profiel en bekijk je statistieken</p>
                </div>
                <button
                    class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium text-white whitespace-nowrap rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"
                    style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                    onmouseover="this.style.background='#6A0AFC'"
                    onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                    <i data-lucide="settings" class="mr-2 w-4 h-4"></i>
                    Instellingen
                </button>
            </div>

            <div class="space-y-6">
                <!-- Tabs -->
                <div class="grid grid-cols-6 p-1 w-full rounded-md bg-muted text-muted-foreground">
                    <button onclick="switchTab('overview')" id="tab-overview"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm shadow-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-background text-foreground">
                        Overzicht
                    </button>
                    <button onclick="switchTab('bookings')" id="tab-bookings"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Boekingen
                    </button>
                    <button onclick="switchTab('portfolio')" id="tab-portfolio"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Portfolio
                    </button>
                    <button onclick="switchTab('profile')" id="tab-profile"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Profiel
                    </button>
                    <button onclick="switchTab('analytics')" id="tab-analytics"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Analytics
                    </button>
                    <button onclick="switchTab('messages')" id="tab-messages"
                        class="inline-flex justify-center items-center px-3 py-1.5 text-sm font-medium whitespace-nowrap rounded-sm transition-all ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Berichten
                    </button>
                </div>

                <!-- Overview Tab -->
                <div id="content-overview" class="space-y-6 tab-content">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Weergaven</p>
                                        <p class="text-2xl font-bold">{{ number_format($stats['totalViews']) }}</p>
                                    </div>
                                    <i data-lucide="eye" class="w-8 h-8 text-blue-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Boekingen</p>
                                        <p class="text-2xl font-bold">{{ $stats['totalBookings'] }}</p>
                                    </div>
                                    <i data-lucide="calendar" class="w-8 h-8 text-green-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Inkomsten</p>
                                        <p class="text-2xl font-bold">€{{ $stats['totalEarnings'] }}</p>
                                    </div>
                                    <i data-lucide="dollar-sign" class="w-8 h-8 text-yellow-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="p-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Gemiddelde Rating</p>
                                        <div class="flex gap-1 items-center">
                                            <p class="text-2xl font-bold">{{ $stats['rating'] }}</p>
                                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                                        </div>
                                    </div>
                                    <i data-lucide="star" class="w-8 h-8 text-orange-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                            <!-- Facebook-style Chat Button for creator dashboard -->
<button id="messages-toggle" onclick="toggleMessagesPanelOne()"
    class="fixed bottom-4 right-4 z-[100] bg-gradient-to-r from-pink-500 to-orange-500 text-white p-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
    <i data-lucide="message-circle" class="w-6 h-6"></i>
</button>

<!-- Facebook-style Chat Panel (Initially Hidden) for creator dashboard -->
<div id="messages-panel-one"
    class="fixed bottom-20 right-4 w-80 bg-white rounded-lg shadow-xl z-[100] hidden transform translate-y-full transition-all duration-300 ease-in-out">
    <div class="flex flex-col h-[500px] border border-gray-200 rounded-lg">
        <!-- Header -->
        <div class="flex justify-between items-center p-3 border-b">
            <div>
                <h3 class="text-lg font-semibold">Leden</h3>
                <p class="text-xs text-gray-500">Active members</p>
            </div>
            <button onclick="toggleMessagesPanelOne()"
                class="text-gray-500 transition-colors hover:text-gray-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <!-- Search -->
        <div class="p-3 border-b">
            <div class="relative">
                <input type="text" id="creator-chat-search" placeholder="Zoek leden..."
                    class="py-1 pr-3 pl-8 w-full text-sm rounded-full border focus:outline-none focus:ring-1 focus:ring-pink-500">
                <i data-lucide="search"
                    class="absolute left-2 top-1/2 w-4 h-4 text-gray-400 transform -translate-y-1/2"></i>
            </div>
        </div>
        <!-- Member List -->
        <div class="overflow-y-auto flex-1 p-2">
            <div id="chat-list-one" class="space-y-1">
                <!-- Active members will be loaded here -->
            </div>
        </div>
    </div>
</div>

                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                                <h3 class="text-2xl font-semibold tracking-tight leading-none">Recente Boekingen</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach ($recentBookings as $booking)
                                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                            <div>
                                                <p class="font-semibold">{{ $booking['client'] }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking['service'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $booking['date'] }}</p>
                                            </div>
                                            <div class="text-right">
                                                <div
                                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold badge-{{ strtolower(str_replace(' ', '-', $booking['status'])) }}">
                                                    {{ $booking['status'] }}
                                                </div>
                                                <p class="mt-1 text-sm font-semibold">€{{ $booking['amount'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                                <h3 class="text-2xl font-semibold tracking-tight leading-none">Portfolio Prestaties</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach (array_slice($portfolio, 0, 3) as $item)
                                        <div class="flex gap-4 items-center">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                class="object-cover w-16 h-16 rounded-lg" />
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $item['title'] }}</p>
                                                <div class="flex gap-4 items-center text-sm text-gray-600">
                                                    <span class="flex gap-1 items-center">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                        {{ $item['views'] }}
                                                    </span>
                                                    <span class="flex gap-1 items-center">
                                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                                        {{ $item['likes'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Tab -->
                <div id="content-bookings" class="hidden space-y-6 tab-content">
                    <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                        <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                            <h3 class="text-2xl font-semibold tracking-tight leading-none">Alle Boekingen</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($recentBookings as $booking)
                                    <div class="flex justify-between items-center p-6 rounded-lg border">
                                        <div class="flex gap-4 items-center">
                                            <div class="flex overflow-hidden relative w-10 h-10 rounded-full shrink-0">
                                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $booking['client'] }}"
                                                    alt="{{ $booking['client'] }}" class="w-full h-full aspect-square" />
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $booking['client'] }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking['service'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $booking['date'] }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 items-center">
                                            <div
                                                class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold badge-{{ strtolower(str_replace(' ', '-', $booking['status'])) }}">
                                                {{ $booking['status'] }}
                                            </div>
                                            <p class="font-semibold">€{{ $booking['amount'] }}</p>
                                            <button
                                                class="inline-flex gap-2 justify-center items-center px-4 py-2 h-9 text-sm font-medium whitespace-nowrap rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground">
                                                <i data-lucide="message-square" class="mr-2 w-4 h-4"></i>
                                                Contact
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Tab -->
                <div id="content-portfolio" class="hidden space-y-6 tab-content">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Mijn Portfolio</h2>
                        <div class="flex gap-3">
                            <a href="{{ route('creator.portfolio.index') }}"
                                class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium whitespace-nowrap rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground">
                                <i data-lucide="folder" class="mr-2 w-4 h-4"></i>
                                Beheer Portfolio
                            </a>
                            <a href="{{ route('creator.portfolio.create') }}"
                                class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium whitespace-nowrap rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground"
                                style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                onmouseover="this.style.background='#6A0AFC'"
                                onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                                <i data-lucide="plus" class="mr-2 w-4 h-4"></i>
                                Nieuw Item Toevoegen
                            </a>
                        </div>
                    </div>

                    @if ($portfolio && count($portfolio) > 0)
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($portfolio as $item)
                                <div
                                    class="rounded-lg border shadow-sm transition-shadow cursor-pointer bg-card text-card-foreground group hover:shadow-lg">
                                    <div class="p-0">
                                        <div class="relative">
                                            @if (isset($item['file_type']) && $item['file_type'] === 'video')
                                                @if (isset($item['thumbnail_path']) && $item['thumbnail_path'])
                                                    <img src="{{ $item['thumbnail_path'] }}" alt="{{ $item['title'] }}"
                                                        class="object-cover w-full h-48 rounded-t-lg" />
                                                @else
                                                    <div
                                                        class="flex justify-center items-center w-full h-48 bg-gray-200 rounded-t-lg">
                                                        <i data-lucide="play-circle" class="w-12 h-12 text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div
                                                    class="absolute top-2 right-2 px-2 py-1 text-xs text-white rounded bg-black/70">
                                                    <i data-lucide="play" class="inline mr-1 w-3 h-3"></i>
                                                    Video
                                                </div>
                                            @else
                                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                    class="object-cover w-full h-48 rounded-t-lg" />
                                            @endif

                                            <div
                                                class="flex absolute inset-0 justify-center items-center opacity-0 transition-opacity bg-black/50 group-hover:opacity-100">
                                                <div class="flex gap-2">
                                                    @if (isset($item['id']))
                                                        <a href="{{ route('creator.portfolio.show', $item['id']) }}"
                                                            class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium text-gray-900 whitespace-nowrap bg-white rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100">
                                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                                        </a>
                                                        <a href="{{ route('creator.portfolio.edit', $item['id']) }}"
                                                            class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium text-gray-900 whitespace-nowrap bg-white rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('creator.portfolio.destroy', $item['id']) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="return confirm('Weet je zeker dat je dit item wilt verwijderen?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium text-white whitespace-nowrap bg-red-600 rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-red-700">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button
                                                            class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium text-gray-900 whitespace-nowrap bg-white rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </button>
                                                        <button
                                                            class="inline-flex gap-2 justify-center items-center px-3 h-9 text-sm font-medium text-gray-900 whitespace-nowrap bg-white rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100">
                                                            <i data-lucide="share-2" class="w-4 h-4"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            @if (isset($item['is_active']) && !$item['is_active'])
                                                <div
                                                    class="absolute top-2 left-2 px-2 py-1 text-xs text-white bg-gray-600 rounded">
                                                    Inactief
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="mb-2 font-semibold">{{ $item['title'] }}</h3>
                                            @if (isset($item['description']) && $item['description'])
                                                <p class="mb-2 text-sm text-gray-600 line-clamp-2">
                                                    {{ Str::limit($item['description'], 80) }}</p>
                                            @endif
                                            <div class="flex justify-between items-center text-sm text-gray-600">
                                                @if (isset($item['views']))
                                                    <span class="flex gap-1 items-center">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                        {{ $item['views'] }} weergaven
                                                    </span>
                                                @endif
                                                @if (isset($item['likes']))
                                                    <span class="flex gap-1 items-center">
                                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                                        {{ $item['likes'] }} likes
                                                    </span>
                                                @endif
                                                @if (isset($item['file_type']))
                                                    <span class="flex gap-1 items-center capitalize">
                                                        @if ($item['file_type'] === 'image')
                                                            <i data-lucide="image" class="w-4 h-4"></i>
                                                        @elseif($item['file_type'] === 'video')
                                                            <i data-lucide="play" class="w-4 h-4"></i>
                                                        @endif
                                                        {{ $item['file_type'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-12 text-center">
                            <div class="mx-auto mb-4 w-24 h-24 text-gray-400">
                                <i data-lucide="folder-open" class="w-24 h-24"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-medium text-gray-900">Geen portfolio items</h3>
                            <p class="mb-6 text-gray-600">Je hebt nog geen portfolio items toegevoegd. Begin met het
                                toevoegen van je eerste item.</p>
                            <a href="{{ route('creator.portfolio.create') }}"
                                class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium whitespace-nowrap rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground"
                                style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                onmouseover="this.style.background='#6A0AFC'"
                                onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                                <i data-lucide="plus" class="mr-2 w-4 h-4"></i>
                                Eerste Item Toevoegen
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Profile Tab -->
                <div id="content-profile" class="hidden space-y-6 tab-content">
                    <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                        <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                            <h3 class="text-2xl font-semibold tracking-tight leading-none">Profiel Bewerken</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Success/Error Messages -->
                            @if (session('status'))
                                <div class="px-4 py-3 text-green-800 bg-green-50 rounded-md border border-green-200"
                                    id="status-message">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="px-4 py-3 text-green-800 bg-green-50 rounded-md border border-green-200"
                                    id="success-message">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="px-4 py-3 text-red-800 bg-red-50 rounded-md border border-red-200"
                                    id="error-message">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="px-4 py-3 text-red-800 bg-red-50 rounded-md border border-red-200">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('creator.profile.update') }}" method="POST"
                                enctype="multipart/form-data" id="profile-form">
                                @csrf
                                @method('PUT')

                                <!-- Avatar Upload Section -->
                                <div class="flex gap-6 items-center">
                                    <div class="flex overflow-hidden relative w-24 h-24 rounded-full shrink-0">
                                        <img src="{{ $profile['avatar'] }}"
                                            alt="{{ $profile['firstName'] }} {{ $profile['lastName'] }}"
                                            class="w-full h-full aspect-square" id="avatar-preview" />
                                    </div>
                                    <div>
                                        <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                            class="hidden" />
                                        <div class="flex gap-2">
                                            <button type="button"
                                                onclick="document.getElementById('avatar-input').click()"
                                                class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium whitespace-nowrap rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input bg-background hover:bg-accent hover:text-accent-foreground">
                                                <i data-lucide="upload" class="mr-2 w-4 h-4"></i>
                                                Foto Uploaden
                                            </button>
                                            @if ($profile['avatar'])
                                                <a href="{{ route('creator.download.avatar') }}"
                                                    class="inline-flex gap-2 justify-center items-center px-4 py-2 h-10 text-sm font-medium text-blue-700 whitespace-nowrap bg-blue-50 rounded-md border transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border-input hover:bg-blue-100">
                                                    <i data-lucide="download" class="mr-2 w-4 h-4"></i>
                                                    Download
                                                </a>
                                            @endif
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600">JPG, PNG of GIF. Max 2MB.</p>
                                        @error('avatar')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div class="space-y-2">
                                        <label for="firstName"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First
                                            Name</label>
                                        <input id="firstName" name="first_name" type="text" required
                                            class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            value="{{ old('first_name', $profile['firstName']) }}" />
                                        @error('first_name')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-2">
                                        <label for="lastName"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Last
                                            Name</label>
                                        <input id="lastName" name="last_name" type="text" required
                                            class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            value="{{ old('last_name', $profile['lastName']) }}" />
                                        @error('last_name')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label for="email"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                                        <input id="email" name="email" type="email" required
                                            class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            value="{{ old('email', $profile['email']) }}" />
                                        @error('email')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="bio"
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Short
                                        Bio</label>
                                    <textarea id="bio" name="short_bio" rows="3"
                                        class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="Brief description about yourself...">{{ old('short_bio', $profile['short_bio']) }}</textarea>
                                    @error('short_bio')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="about_me"
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">About
                                        Me</label>
                                    <textarea id="about_me" name="about_me" rows="6"
                                        class="flex min-h-[120px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="Tell us more about yourself, your experience, and what makes you unique...">{{ old('about_me', $profile['about_me']) }}</textarea>
                                    @error('about_me')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Talent Categories Selection -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold">Talent Categories</h4>
                                    <p class="text-sm text-gray-600">Select the categories that best describe your skills
                                        and services.</p>

                                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3">
                                        @foreach ($talentCategories as $category)
                                            <label
                                                class="flex items-center p-3 space-x-3 rounded-lg border transition-colors cursor-pointer hover:bg-gray-50">
                                                <input type="checkbox" name="talent_categories[]"
                                                    value="{{ $category->id }}"
                                                    {{ in_array($category->id, $selectedTalentCategories) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-pink-600 bg-gray-100 rounded border-gray-300 focus:ring-pink-500 focus:ring-2">
                                                <div class="flex items-center space-x-2">
                                                    <i class="{{ $category->icon }} text-pink-600"></i>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                    @error('talent_categories')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Uploads Section -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold">Media & Documents</h4>

                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div class="space-y-2">
                                            <label for="banner_image"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Banner
                                                Image</label>
                                            <input id="banner_image" name="banner_image" type="file" accept="image/*"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                            @if ($profile['banner_image'])
                                                <div class="flex justify-between items-center">
                                                    <p class="text-xs text-gray-600">Current:
                                                        {{ basename($profile['banner_image']) }}</p>
                                                    <a href="{{ route('creator.download.banner') }}"
                                                        class="inline-flex gap-1 items-center text-xs text-blue-600 hover:text-blue-800">
                                                        <i data-lucide="download" class="w-3 h-3"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            @endif
                                            @error('banner_image')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="resume_cv"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Resume/CV</label>
                                            <input id="resume_cv" name="resume_cv" type="file"
                                                accept=".pdf,.doc,.docx"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                            @if ($profile['resume_cv'])
                                                <div class="flex justify-between items-center">
                                                    <p class="text-xs text-gray-600">Current:
                                                        {{ basename($profile['resume_cv']) }}</p>
                                                    <a href="{{ route('creator.download.resume') }}"
                                                        class="inline-flex gap-1 items-center text-xs text-blue-600 hover:text-blue-800">
                                                        <i data-lucide="download" class="w-3 h-3"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            @endif
                                            @error('resume_cv')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Social Media & Website Section -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold">Social Media & Website</h4>

                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div class="space-y-2">
                                            <label for="website_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Website
                                                URL</label>
                                            <input id="website_url" name="website_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://yourwebsite.com"
                                                value="{{ old('website_url', $profile['website_url']) }}" />
                                            @error('website_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="facebook_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Facebook
                                                URL</label>
                                            <input id="facebook_url" name="facebook_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://facebook.com/yourprofile"
                                                value="{{ old('facebook_url', $profile['facebook_url']) }}" />
                                            @error('facebook_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="instagram_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Instagram
                                                URL</label>
                                            <input id="instagram_url" name="instagram_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://instagram.com/yourprofile"
                                                value="{{ old('instagram_url', $profile['instagram_url']) }}" />
                                            @error('instagram_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="twitter_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Twitter
                                                URL</label>
                                            <input id="twitter_url" name="twitter_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://twitter.com/yourprofile"
                                                value="{{ old('twitter_url', $profile['twitter_url']) }}" />
                                            @error('twitter_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="linkedin_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">LinkedIn
                                                URL</label>
                                            <input id="linkedin_url" name="linkedin_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://linkedin.com/in/yourprofile"
                                                value="{{ old('linkedin_url', $profile['linkedin_url']) }}" />
                                            @error('linkedin_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="youtube_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">YouTube
                                                URL</label>
                                            <input id="youtube_url" name="youtube_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://youtube.com/c/yourchannel"
                                                value="{{ old('youtube_url', $profile['youtube_url']) }}" />
                                            @error('youtube_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label for="tiktok_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">TikTok
                                                URL</label>
                                            <input id="tiktok_url" name="tiktok_url" type="url"
                                                class="flex px-3 py-2 w-full h-10 text-sm rounded-md border border-input bg-background ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                                placeholder="https://tiktok.com/@yourprofile"
                                                value="{{ old('tiktok_url', $profile['tiktok_url']) }}" />
                                            @error('tiktok_url')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Settings Section -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-semibold">Profile Settings</h4>

                                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                                class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                                                {{ old('is_featured', $profile['is_featured']) ? 'checked' : '' }} />
                                            <label for="is_featured"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Featured
                                                Profile</label>
                                        </div>

                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                                class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground"
                                                {{ old('is_active', $profile['is_active']) ? 'checked' : '' }} />
                                            <label for="is_active"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Active
                                                Profile</label>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" id="save-button"
                                    class="inline-flex gap-2 justify-center items-center px-4 py-2 w-full h-10 text-sm font-medium whitespace-nowrap rounded-md transition-colors ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground"
                                    style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                    onmouseover="this.style.background='#6A0AFC'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'"
                                    <span id="save-text">Save
                                    Profile</span>
                                    <div id="save-spinner" class="hidden">
                                        <svg class="mr-3 -ml-1 w-4 h-4 text-white animate-spin"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Analytics Tab -->
                <div id="content-analytics" class="hidden space-y-6 tab-content">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                                <h3 class="text-2xl font-semibold tracking-tight leading-none">Weergaven per Maand</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-col justify-center items-center h-64 text-gray-500">
                                    <i data-lucide="bar-chart-3" class="mb-4 w-16 h-16"></i>
                                    <p>Grafiek wordt hier weergegeven</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                            <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                                <h3 class="text-2xl font-semibold tracking-tight leading-none">Inkomsten Overzicht</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span>Deze maand</span>
                                        <span
                                            class="font-semibold">€{{ $analytics['monthlyEarnings']['thisMonth'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Vorige maand</span>
                                        <span
                                            class="font-semibold">€{{ $analytics['monthlyEarnings']['lastMonth'] }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Totaal dit jaar</span>
                                        <span
                                            class="font-semibold">€{{ $analytics['monthlyEarnings']['yearTotal'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Tab -->
                <div id="content-messages" class="hidden space-y-6 tab-content">
                    <div class="rounded-lg border shadow-sm bg-card text-card-foreground">
                        <div class="flex flex-col p-6 space-y-1.5 border-b border-border">
                            <h3 class="text-2xl font-semibold tracking-tight leading-none">Berichten</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($messages as $message)
                                    <div
                                        class="flex gap-4 items-center p-4 rounded-lg border cursor-pointer hover:bg-gray-50">
                                        <div class="flex overflow-hidden relative w-10 h-10 rounded-full shrink-0">
                                            <img src="{{ $message['avatar'] }}" alt="{{ $message['client'] }}"
                                                class="w-full h-full aspect-square" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center">
                                                <p class="font-semibold">{{ $message['client'] }}</p>
                                                <span class="text-xs text-gray-500">{{ $message['time'] }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $message['message'] }}</p>
                                        </div>
                                        <div
                                            class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full border bg-secondary text-secondary-foreground">
                                            {{ $message['status'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facebook-style Chat Panel (Initially Hidden) -->
                <div id="messages-panel"
                    class="fixed bottom-20 right-4 w-80 bg-white rounded-lg shadow-xl z-[100] hidden transform translate-y-full transition-all duration-300 ease-in-out">
                    <div class="flex flex-col h-[500px] border border-gray-200 rounded-lg">
                        <!-- Header -->
                        <div class="flex justify-between items-center p-3 border-b">
                            <div>
                                <h3 class="text-lg font-semibold">Gesprekken</h3>
                                <p class="text-xs text-gray-500">Active Member</p>
                            </div>
                            <button onclick="toggleMessagesPanel()"
                                class="text-gray-500 transition-colors hover:text-gray-700">
                                <i data-lucide="x" class="w-5 h-5"></i>
                            </button>
                        </div>

                        <!-- Search -->
                        <div class="p-3 border-b">
                            <div class="relative">
                                <input type="text" placeholder="Zoek creators..."
                                    class="py-1 pr-3 pl-8 w-full text-sm rounded-full border focus:outline-none focus:ring-1 focus:ring-pink-500">
                                <i data-lucide="search"
                                    class="absolute left-2 top-1/2 w-4 h-4 text-gray-400 transform -translate-y-1/2"></i>
                            </div>
                        </div>

                        <!-- Creator List -->
                        <div class="overflow-y-auto flex-1 p-2">
                            <div id="chat-list" class="space-y-1">
                                <!-- Active creators will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .badge-voltooid {
            background-color: #dcfce7;
            color: #166534;
            border-color: #bbf7d0;
        }

        .badge-bevestigd {
            background-color: #dbeafe;
            color: #1e40af;
            border-color: #93c5fd;
        }

        .badge-in-behandeling {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #d1d5db;
        }
    </style>

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
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('overview');

            // Profile form submission handling
            const profileForm = document.getElementById('profile-form');
            const saveButton = document.getElementById('save-button');
            const saveText = document.getElementById('save-text');
            const saveSpinner = document.getElementById('save-spinner');
            const avatarInput = document.getElementById('avatar-input');
            const avatarPreview = document.getElementById('avatar-preview');

            // Handle avatar preview
            if (avatarInput && avatarPreview) {
                avatarInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Handle form submission
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    // Show loading state
                    saveButton.disabled = true;
                    saveText.textContent = 'Saving...';
                    saveSpinner.classList.remove('hidden');
                });
            }
        });

                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
            }

        function toggleMessagesPanel() {
            const panel = document.getElementById('messages-panel');
            if (!panel) return;
            const isHidden = panel.classList.contains('hidden');
            if (isHidden) {
                panel.classList.remove('hidden');
                setTimeout(() => {
                    panel.classList.remove('translate-y-full');
                }, 10);
                loadCreatorConversations();
            } else {
                panel.classList.add('translate-y-full');
                setTimeout(() => {
                    panel.classList.add('hidden');
                }, 300);
            }
        }

        function escapeHtml(str) {
            if (str == null) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function openConversationFromList(conversationId, participantId, participantName) {
            if (typeof openConversationById === 'function') {
                openConversationById(conversationId, participantId, participantName);
            }
            toggleMessagesPanel();
        }

        async function loadCreatorConversations() {
            const chatList = document.getElementById('chat-list');
            if (!chatList) return;
            chatList.innerHTML = '<div class="p-4 text-sm text-center text-gray-500">Laden...</div>';

            try {
                const response = await fetch('/conversations', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load conversations');
                }

                const data = await response.json();
                const list = Array.isArray(data.conversations) ? data.conversations : [];

                if (!list.length) {
                    chatList.innerHTML = '<p class="p-4 text-sm text-center text-gray-500">Geen gesprekken gevonden</p>';
                    return;
                }

                chatList.innerHTML = list.map(c => {
                    const name = escapeHtml(c.participant_name || 'Gebruiker');
                    const lastMsg = escapeHtml(c.last_message || '');
                    const lastAt = escapeHtml(c.last_message_at || '');
                    const unread = Number(c.unread_count || 0);
                    const avatar = c.participant_avatar ? ('/storage/' + c.participant_avatar) : ('https://api.dicebear.com/7.x/initials/svg?seed=' + encodeURIComponent(name));

                    return `
                        <div class="flex gap-3 items-center p-2 rounded cursor-pointer hover:bg-gray-50"
                             onclick="openConversationFromList(${c.id}, ${c.participant_id}, '${name}')">
                            <div class="flex overflow-hidden relative w-8 h-8 rounded-full shrink-0">
                                <img src="${avatar}" alt="${name}" class="w-full h-full aspect-square" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-semibold truncate">${name}</p>
                                    ${unread > 0 ? `<span class="inline-flex items-center px-2 py-0.5 ml-2 text-xs font-semibold text-white bg-red-500 rounded-full">${unread}</span>` : ''}
                                </div>
                                <p class="text-xs text-gray-600 truncate">${lastMsg}</p>
                                <span class="text-[10px] text-gray-400">${lastAt}</span>
                            </div>
                        </div>
                    `;
                }).join('');

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            } catch (e) {
                chatList.innerHTML = '<p class="p-4 text-sm text-center text-gray-500">Fout bij het laden van leden</p>';
            }
        }

    </script>

<script>
function toggleMessagesPanelOne() {
    var panel = document.getElementById('messages-panel-one');
    if (!panel) return;
    
    if (panel.classList.contains('hidden')) {
        // Panel is opening - load all members
        panel.classList.remove('hidden');
        setTimeout(function(){ 
            panel.classList.remove('translate-y-full');
            // Load all members when panel opens
            if (typeof loadMembers === 'function') {
                loadMembers('');
            }
        }, 10);
    } else {
        // Panel is closing
        panel.classList.add('translate-y-full');
        setTimeout(function(){ 
            panel.classList.add('hidden');
        }, 300);
    }
}
</script>

<script>
// Debounce helper to avoid too many requests
function debounce(func, wait = 300) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Function to load and render members
function loadMembers(query = '') {
    const list = document.getElementById('chat-list-one');
    if (!list) return;
    
    list.innerHTML = '<div class="text-gray-500 text-sm p-4 text-center">Laden...</div>';

    fetch('/api/search-members?q=' + encodeURIComponent(query))
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch members');
            }
            return response.json();
        })
        .then(data => {
            list.innerHTML = '';
            
            if (!data || data.length === 0) {
                list.innerHTML = '<div class="text-gray-500 text-sm p-4 text-center">Geen leden gevonden.</div>';
                return;
            }

            // Separate online and offline members
            const online = data.filter(member => member.online === true);
            const offline = data.filter(member => member.online !== true);

            // Render function
            const renderMember = (member) => {
                const statusDot = member.online ? 'bg-green-400' : 'bg-gray-300';
                const statusText = member.online ? 'Online' : 'Offline';
                const statusColor = member.online ? 'text-green-500' : 'text-gray-400';
                const memberName = member.name || 'Unknown';
                const memberId = member.id;
                
                return `
                    <div data-member-id="${memberId}" data-member-name="${memberName.replace(/"/g, '&quot;')}" 
                         class="member-item flex items-center space-x-3 hover:bg-gray-100 rounded-lg p-2 transition cursor-pointer">
                        <div class="relative flex-shrink-0">
                            <img src="${member.image || '/images/default-avatar.svg'}" 
                                class="w-10 h-10 rounded-full object-cover border border-gray-200" 
                                alt="${memberName.replace(/"/g, '&quot;')}"
                                onerror="this.src='/images/default-avatar.svg'">
                            <span class="absolute bottom-0 right-0 block w-3 h-3 rounded-full border-2 border-white ${statusDot}"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-sm truncate">${memberName}</div>
                            <div class="text-xs mt-1 ${statusColor}">${statusText}</div>
                        </div>
                    </div>
                `;
            };

            // Render online members first, then offline
            let html = '';
            
            if (online.length > 0) {
                html += '<div class="px-2 py-1 text-xs font-semibold text-gray-500 uppercase">Online</div>';
                online.forEach(member => {
                    html += renderMember(member);
                });
            }
            
            if (offline.length > 0) {
                if (online.length > 0) {
                    html += '<div class="px-2 py-1 mt-2 text-xs font-semibold text-gray-500 uppercase">Offline</div>';
                }
                offline.forEach(member => {
                    html += renderMember(member);
                });
            }

            list.innerHTML = html;
            
            // Attach click handlers to member items using event delegation
            list.querySelectorAll('.member-item').forEach(item => {
                item.addEventListener('click', function() {
                    const memberId = parseInt(this.getAttribute('data-member-id'));
                    const memberName = this.getAttribute('data-member-name');
                    openChatWithMember(memberId, memberName);
                });
            });
        })
        .catch(error => {
            console.error('Error loading members:', error);
            list.innerHTML = '<div class="text-red-500 text-sm p-4 text-center">Fout bij het laden van leden.</div>';
        });
}

// Initialize search functionality when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('creator-chat-search');
    
    if (!searchInput) {
        console.warn('Search input not found');
        return;
    }

    // Debounced search function
    const debouncedSearch = debounce(function(e) {
        const query = e.target.value.trim();
        loadMembers(query);
    }, 300);

    // Attach event listener to search input
    searchInput.addEventListener('input', debouncedSearch);
});

// Function to open chat with a member
function openChatWithMember(memberId, memberName) {
    // Close the messages panel
    const panel = document.getElementById('messages-panel-one');
    if (panel && !panel.classList.contains('hidden')) {
        toggleMessagesPanelOne();
    }
    
    // Wait a bit for panel to close, then open chat
    setTimeout(function() {
        // Use the global openConversation function from chat-interface
        // For creators, this function finds existing conversation with the member
        if (typeof openConversation === 'function') {
            openConversation(memberId, memberName);
        } else if (window.chatInterface && typeof window.chatInterface.openConversation === 'function') {
            // Fallback: call directly if global function not available yet
            window.chatInterface.openConversation(memberId, memberName);
        } else {
            console.error('Chat interface not available. Please refresh the page.');
            alert('Chat interface not available. Please refresh the page.');
        }
    }, 300); // Wait for panel close animation
}
</script>

    <x-chat-interface />
@endsection
