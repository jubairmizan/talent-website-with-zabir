@extends('layouts.landing')

@section('title', 'Creator Dashboard - Curaçao Talents')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b sticky top-0 z-50">
            <div class="container mx-auto px-6 py-2">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-auto object-contain"
                            style="height: 64px;">
                    </a>

                    <!-- Navigation -->
                    <nav class="hidden md:flex items-center gap-8">
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
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600">
                                Welcome, Creator
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

        <div class="container mx-auto px-6 py-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Creator Dashboard</h1>
                    <p class="text-gray-600">Beheer je profiel en bekijk je statistieken</p>
                </div>
                <button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2"
                    style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                    onmouseover="this.style.background='#6A0AFC'"
                    onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                    Instellingen
                </button>
            </div>

            <div class="space-y-6">
                <!-- Tabs -->
                <div class="grid w-full grid-cols-6 bg-muted p-1 text-muted-foreground rounded-md">
                    <button onclick="switchTab('overview')" id="tab-overview"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-background text-foreground shadow-sm">
                        Overzicht
                    </button>
                    <button onclick="switchTab('bookings')" id="tab-bookings"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Boekingen
                    </button>
                    <button onclick="switchTab('portfolio')" id="tab-portfolio"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Portfolio
                    </button>
                    <button onclick="switchTab('profile')" id="tab-profile"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Profiel
                    </button>
                    <button onclick="switchTab('analytics')" id="tab-analytics"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Analytics
                    </button>
                    <button onclick="switchTab('messages')" id="tab-messages"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                        Berichten
                    </button>
                </div>

                <!-- Overview Tab -->
                <div id="content-overview" class="tab-content space-y-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Weergaven</p>
                                        <p class="text-2xl font-bold">{{ number_format($stats['totalViews']) }}</p>
                                    </div>
                                    <i data-lucide="eye" class="w-8 h-8 text-blue-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Boekingen</p>
                                        <p class="text-2xl font-bold">{{ $stats['totalBookings'] }}</p>
                                    </div>
                                    <i data-lucide="calendar" class="w-8 h-8 text-green-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Totaal Inkomsten</p>
                                        <p class="text-2xl font-bold">€{{ $stats['totalEarnings'] }}</p>
                                    </div>
                                    <i data-lucide="dollar-sign" class="w-8 h-8 text-yellow-500"></i>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Gemiddelde Rating</p>
                                        <div class="flex items-center gap-1">
                                            <p class="text-2xl font-bold">{{ $stats['rating'] }}</p>
                                            <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                                        </div>
                                    </div>
                                    <i data-lucide="star" class="w-8 h-8 text-orange-500"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Recente Boekingen</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach ($recentBookings as $booking)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
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
                                                <p class="text-sm font-semibold mt-1">€{{ $booking['amount'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Portfolio Prestaties</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach (array_slice($portfolio, 0, 3) as $item)
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                class="w-16 h-16 rounded-lg object-cover" />
                                            <div class="flex-1">
                                                <p class="font-semibold">{{ $item['title'] }}</p>
                                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                        {{ $item['views'] }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
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
                <div id="content-bookings" class="tab-content space-y-6 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Alle Boekingen</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($recentBookings as $booking)
                                    <div class="flex items-center justify-between p-6 border rounded-lg">
                                        <div class="flex items-center gap-4">
                                            <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ $booking['client'] }}"
                                                    alt="{{ $booking['client'] }}" class="aspect-square h-full w-full" />
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $booking['client'] }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking['service'] }}</p>
                                                <p class="text-xs text-gray-500">{{ $booking['date'] }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold badge-{{ strtolower(str_replace(' ', '-', $booking['status'])) }}">
                                                {{ $booking['status'] }}
                                            </div>
                                            <p class="font-semibold">€{{ $booking['amount'] }}</p>
                                            <button
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                                                <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
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
                <div id="content-portfolio" class="tab-content space-y-6 hidden">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Mijn Portfolio</h2>
                        <div class="flex gap-3">
                            <a href="{{ route('creator.portfolio.index') }}"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                <i data-lucide="folder" class="w-4 h-4 mr-2"></i>
                                Beheer Portfolio
                            </a>
                            <a href="{{ route('creator.portfolio.create') }}"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground h-10 px-4 py-2"
                                style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                onmouseover="this.style.background='#6A0AFC'"
                                onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Nieuw Item Toevoegen
                            </a>
                        </div>
                    </div>

                    @if ($portfolio && count($portfolio) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($portfolio as $item)
                                <div
                                    class="rounded-lg border bg-card text-card-foreground shadow-sm group cursor-pointer hover:shadow-lg transition-shadow">
                                    <div class="p-0">
                                        <div class="relative">
                                            @if (isset($item['file_type']) && $item['file_type'] === 'video')
                                                @if (isset($item['thumbnail_path']) && $item['thumbnail_path'])
                                                    <img src="{{ $item['thumbnail_path'] }}" alt="{{ $item['title'] }}"
                                                        class="w-full h-48 object-cover rounded-t-lg" />
                                                @else
                                                    <div
                                                        class="w-full h-48 bg-gray-200 rounded-t-lg flex items-center justify-center">
                                                        <i data-lucide="play-circle" class="w-12 h-12 text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div
                                                    class="absolute top-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                                                    <i data-lucide="play" class="w-3 h-3 inline mr-1"></i>
                                                    Video
                                                </div>
                                            @else
                                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                    class="w-full h-48 object-cover rounded-t-lg" />
                                            @endif

                                            <div
                                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <div class="flex gap-2">
                                                    @if (isset($item['id']))
                                                        <a href="{{ route('creator.portfolio.show', $item['id']) }}"
                                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-gray-900 hover:bg-gray-100 h-9 px-3">
                                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                                        </a>
                                                        <a href="{{ route('creator.portfolio.edit', $item['id']) }}"
                                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-gray-900 hover:bg-gray-100 h-9 px-3">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('creator.portfolio.destroy', $item['id']) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="return confirm('Weet je zeker dat je dit item wilt verwijderen?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-600 text-white hover:bg-red-700 h-9 px-3">
                                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button
                                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-gray-900 hover:bg-gray-100 h-9 px-3">
                                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                                        </button>
                                                        <button
                                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-gray-900 hover:bg-gray-100 h-9 px-3">
                                                            <i data-lucide="share-2" class="w-4 h-4"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            @if (isset($item['is_active']) && !$item['is_active'])
                                                <div
                                                    class="absolute top-2 left-2 bg-gray-600 text-white px-2 py-1 rounded text-xs">
                                                    Inactief
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="font-semibold mb-2">{{ $item['title'] }}</h3>
                                            @if (isset($item['description']) && $item['description'])
                                                <p class="text-sm text-gray-600 mb-2 line-clamp-2">
                                                    {{ Str::limit($item['description'], 80) }}</p>
                                            @endif
                                            <div class="flex items-center justify-between text-sm text-gray-600">
                                                @if (isset($item['views']))
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                        {{ $item['views'] }} weergaven
                                                    </span>
                                                @endif
                                                @if (isset($item['likes']))
                                                    <span class="flex items-center gap-1">
                                                        <i data-lucide="heart" class="w-4 h-4"></i>
                                                        {{ $item['likes'] }} likes
                                                    </span>
                                                @endif
                                                @if (isset($item['file_type']))
                                                    <span class="flex items-center gap-1 capitalize">
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
                        <div class="text-center py-12">
                            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                                <i data-lucide="folder-open" class="w-24 h-24"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Geen portfolio items</h3>
                            <p class="text-gray-600 mb-6">Je hebt nog geen portfolio items toegevoegd. Begin met het
                                toevoegen van je eerste item.</p>
                            <a href="{{ route('creator.portfolio.create') }}"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground h-10 px-4 py-2"
                                style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                onmouseover="this.style.background='#6A0AFC'"
                                onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                                Eerste Item Toevoegen
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Profile Tab -->
                <div id="content-profile" class="tab-content space-y-6 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Profiel Bewerken</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Success/Error Messages -->
                            @if (session('status'))
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md"
                                    id="status-message">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-md"
                                    id="success-message">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md"
                                    id="error-message">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md">
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
                                <div class="flex items-center gap-6">
                                    <div class="relative flex h-24 w-24 shrink-0 overflow-hidden rounded-full">
                                        <img src="{{ $profile['avatar'] }}"
                                            alt="{{ $profile['firstName'] }} {{ $profile['lastName'] }}"
                                            class="aspect-square h-full w-full" id="avatar-preview" />
                                    </div>
                                    <div>
                                        <input type="file" name="avatar" id="avatar-input" accept="image/*"
                                            class="hidden" />
                                        <div class="flex gap-2">
                                            <button type="button"
                                                onclick="document.getElementById('avatar-input').click()"
                                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                                <i data-lucide="upload" class="w-4 h-4 mr-2"></i>
                                                Foto Uploaden
                                            </button>
                                            @if ($profile['avatar'])
                                                <a href="{{ route('creator.download.avatar') }}"
                                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-blue-50 hover:bg-blue-100 text-blue-700 h-10 px-4 py-2">
                                                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                                                    Download
                                                </a>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">JPG, PNG of GIF. Max 2MB.</p>
                                        @error('avatar')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label for="firstName"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">First
                                            Name</label>
                                        <input id="firstName" name="first_name" type="text" required
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            value="{{ old('last_name', $profile['lastName']) }}" />
                                        @error('last_name')
                                            <p class="text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label for="email"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email</label>
                                        <input id="email" name="email" type="email" required
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                        @foreach ($talentCategories as $category)
                                            <label
                                                class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                                <input type="checkbox" name="talent_categories[]"
                                                    value="{{ $category->id }}"
                                                    {{ in_array($category->id, $selectedTalentCategories) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 rounded focus:ring-pink-500 focus:ring-2">
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="banner_image"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Banner
                                                Image</label>
                                            <input id="banner_image" name="banner_image" type="file" accept="image/*"
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                            @if ($profile['banner_image'])
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs text-gray-600">Current:
                                                        {{ basename($profile['banner_image']) }}</p>
                                                    <a href="{{ route('creator.download.banner') }}"
                                                        class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800">
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                                            @if ($profile['resume_cv'])
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs text-gray-600">Current:
                                                        {{ basename($profile['resume_cv']) }}</p>
                                                    <a href="{{ route('creator.download.resume') }}"
                                                        class="inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800">
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2">
                                            <label for="website_url"
                                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Website
                                                URL</label>
                                            <input id="website_url" name="website_url" type="url"
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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
                                                class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
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

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-primary-foreground h-10 px-4 py-2 w-full"
                                    style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                                    onmouseover="this.style.background='#6A0AFC'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'"
                                    <span id="save-text">Save
                                    Profile</span>
                                    <div id="save-spinner" class="hidden">
                                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white"
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
                <div id="content-analytics" class="tab-content space-y-6 hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Weergaven per Maand</h3>
                            </div>
                            <div class="p-6">
                                <div class="h-64 flex flex-col items-center justify-center text-gray-500">
                                    <i data-lucide="bar-chart-3" class="w-16 h-16 mb-4"></i>
                                    <p>Grafiek wordt hier weergegeven</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                            <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                                <h3 class="text-2xl font-semibold leading-none tracking-tight">Inkomsten Overzicht</h3>
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
                <div id="content-messages" class="tab-content space-y-6 hidden">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-6 border-b border-border">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Berichten</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($messages as $message)
                                    <div
                                        class="flex items-center gap-4 p-4 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                        <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                            <img src="{{ $message['avatar'] }}" alt="{{ $message['client'] }}"
                                                class="aspect-square h-full w-full" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="font-semibold">{{ $message['client'] }}</p>
                                                <span class="text-xs text-gray-500">{{ $message['time'] }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $message['message'] }}</p>
                                        </div>
                                        <div
                                            class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-secondary text-secondary-foreground">
                                            {{ $message['status'] }}
                                        </div>
                                    </div>
                                @endforeach
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
    </script>
@endsection
