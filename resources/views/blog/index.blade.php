@extends('layouts.landing')

@section('title', 'Blog & Nieuws - Curaçao Talents')

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
                        {{-- <a href="/blog" style="color: #6A0AFC;" class="font-medium">
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
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-9 px-3"
                                    style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;"
                                    onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
                                    onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                                    Sign Up
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative py-20" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
            <div class="absolute inset-0 overflow-hidden">
                <!-- Geometric shapes overlay -->
                <div class="absolute top-10 left-20 w-24 h-32 bg-white/10 rounded-2xl transform rotate-12"></div>
                <div class="absolute top-32 right-24 w-16 h-16 bg-white/10 rounded-full"></div>
                <div class="absolute bottom-20 left-32 w-20 h-24 bg-white/10 rounded-xl transform -rotate-12"></div>
                <div class="absolute top-40 left-1/3 w-20 h-20 bg-white/10 rounded-2xl transform rotate-45"></div>
            </div>

            <div class="relative container mx-auto px-6 text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-black mb-6">
                    Blog & Nieuws
                </h1>
                <p class="text-xl text-black/80 mb-8 max-w-2xl mx-auto">
                    Ontdek de laatste verhalen, tips en inzichten van creatieve professionals op Curaçao
                </p>

                <!-- Search and Filter Bar -->
                <div class="max-w-4xl mx-auto">
                    <form method="GET" class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                        <div class="grid md:grid-cols-3 gap-4">
                            <div class="relative">
                                <input type="text" name="search" placeholder="Zoek in blog posts..."
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-black placeholder-black/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50">
                                <i data-lucide="search"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-black/70 w-5 h-5"></i>
                            </div>

                            <select name="category"
                                class="px-4 py-3 rounded-lg bg-white/20 border border-white/30 text-black focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-white/50">
                                <option value="">Alle Categorieën</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}"
                                        {{ request('category') == $category->slug ? 'selected' : '' }}
                                        class="text-gray-900">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="px-6 py-3 bg-white rounded-lg font-semibold hover:bg-white/90 transition-colors"
                                style="color: #6A0AFC;">
                                <i data-lucide="search" class="w-4 h-4 inline mr-2"></i>
                                Zoeken
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-6 py-12">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    @if ($posts->count() > 0)
                        <!-- Featured Posts (first 2) -->
                        @if ($posts->currentPage() == 1)
                            <div class="mb-12">
                                <h2 class="text-3xl font-bold text-gray-900 mb-8">Uitgelichte Artikelen</h2>
                                <div class="grid md:grid-cols-2 gap-8">
                                    @foreach ($posts->take(2) as $post)
                                        <article class="group cursor-pointer">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                                <div class="relative overflow-hidden rounded-2xl mb-4">
                                                    @if ($post->featured_image)
                                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                            alt="{{ $post->title }}"
                                                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                                    @else
                                                        <div
                                                            class="w-full h-64 bg-gradient-to-br from-pink-100 to-orange-100 flex items-center justify-center">
                                                            <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                                                        </div>
                                                    @endif

                                                    @if ($post->category)
                                                        <div class="absolute top-4 left-4">
                                                            <span
                                                                class="px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold rounded-full"
                                                                style="color: #6A0AFC;">
                                                                {{ $post->category->name }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="space-y-3">
                                                    <h3 class="text-xl font-bold text-gray-900 transition-colors line-clamp-2"
                                                        onmouseover="this.style.color='#6A0AFC'"
                                                        onmouseout="this.style.color=''">
                                                        {{ $post->title }}
                                                    </h3>

                                                    @if ($post->excerpt)
                                                        <p class="text-gray-600 line-clamp-3">{{ $post->excerpt }}</p>
                                                    @endif

                                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                                        <div class="flex items-center gap-2">
                                                            <i data-lucide="user" class="w-4 h-4"></i>
                                                            <span>{{ $post->author->name }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-4">
                                                            <div class="flex items-center gap-1">
                                                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-1">
                                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                                                <span>{{ $post->views_count }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- All Posts Grid -->
                        <div class="mb-12">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">
                                @if (request('search') || request('category'))
                                    Zoekresultaten
                                @else
                                    Alle Artikelen
                                @endif
                            </h2>

                            <div class="grid md:grid-cols-2 gap-8">
                                @foreach ($posts->skip($posts->currentPage() == 1 ? 2 : 0) as $post)
                                    <article
                                        class="group cursor-pointer bg-white rounded-2xl shadow-sm border hover:shadow-md transition-shadow">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                            <div class="relative overflow-hidden rounded-t-2xl">
                                                @if ($post->featured_image)
                                                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                        alt="{{ $post->title }}"
                                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div
                                                        class="w-full h-48 bg-gradient-to-br from-pink-100 to-orange-100 flex items-center justify-center">
                                                        <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                                    </div>
                                                @endif

                                                @if ($post->category)
                                                    <div class="absolute top-4 left-4">
                                                        <span
                                                            class="px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold rounded-full"
                                                            style="color: #6A0AFC;">
                                                            {{ $post->category->name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-6 space-y-3">
                                                <h3 class="text-lg font-bold text-gray-900 transition-colors line-clamp-2"
                                                    onmouseover="this.style.color='#6A0AFC'"
                                                    onmouseout="this.style.color=''">
                                                    {{ $post->title }}
                                                </h3>

                                                @if ($post->excerpt)
                                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                                                @endif

                                                <div class="flex items-center justify-between text-xs text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="user" class="w-3 h-3"></i>
                                                        <span>{{ $post->author->name }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="calendar" class="w-3 h-3"></i>
                                                            <span>{{ $post->published_at->format('M d') }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                                            <span>{{ $post->views_count }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($posts->hasPages())
                            <div class="flex justify-center">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-lucide="file-text" class="w-12 h-12 text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Geen blog posts gevonden</h3>
                            <p class="text-gray-600 mb-6">
                                @if (request('search') || request('category'))
                                    Probeer je zoekopdracht aan te passen of filter te verwijderen.
                                @else
                                    Er zijn momenteel geen blog posts beschikbaar.
                                @endif
                            </p>
                            @if (request('search') || request('category'))
                                <a href="{{ route('blog.index') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                    Alle posts bekijken
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- Featured Posts -->
                        @if ($featuredPosts->count() > 0)
                            <div class="bg-white rounded-2xl shadow-sm border p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="star" class="w-5 h-5" style="color: #6A0AFC;"></i>
                                    Uitgelicht
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($featuredPosts as $post)
                                        <article class="group">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                                <div class="flex gap-3">
                                                    @if ($post->featured_image)
                                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                            alt="{{ $post->title }}"
                                                            class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                                                    @else
                                                        <div
                                                            class="w-16 h-16 bg-gradient-to-br from-pink-100 to-orange-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                                        </div>
                                                    @endif

                                                    <div class="flex-1">
                                                        <h4 class="font-semibold text-gray-900 text-sm transition-colors line-clamp-2 mb-1"
                                                            onmouseover="this.style.color='#6A0AFC'"
                                                            onmouseout="this.style.color=''">
                                                            {{ $post->title }}
                                                        </h4>
                                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                                            <span>{{ $post->published_at->format('M d') }}</span>
                                                            <span>•</span>
                                                            <span>{{ $post->views_count }} views</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Categories -->
                        @if ($categories->count() > 0)
                            <div class="bg-white rounded-2xl shadow-sm border p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="folder" class="w-5 h-5" style="color: #6A0AFC;"></i>
                                    Categorieën
                                </h3>
                                <div class="space-y-2">
                                    <a href="{{ route('blog.index') }}"
                                        class="block px-3 py-2 rounded-lg text-sm text-gray-700 transition-colors {{ !request('category') ? '' : '' }}"
                                        style="{{ !request('category') ? 'background-color: rgba(106, 10, 252, 0.1); color: #6A0AFC;' : '' }}"
                                        onmouseover="this.style.backgroundColor='rgba(106, 10, 252, 0.1)'; this.style.color='#6A0AFC'"
                                        onmouseout="this.style.backgroundColor=''; this.style.color=''">
                                        Alle Categorieën
                                    </a>
                                    @foreach ($categories as $category)
                                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                            class="block px-3 py-2 rounded-lg text-sm text-gray-700 transition-colors {{ request('category') == $category->slug ? '' : '' }}"
                                            style="{{ request('category') == $category->slug ? 'background-color: rgba(106, 10, 252, 0.1); color: #6A0AFC;' : '' }}"
                                            onmouseover="this.style.backgroundColor='rgba(106, 10, 252, 0.1)'; this.style.color='#6A0AFC'"
                                            onmouseout="this.style.backgroundColor=''; this.style.color=''">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Recent Posts -->
                        @if ($recentPosts->count() > 0)
                            <div class="bg-white rounded-2xl shadow-sm border p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="clock" class="w-5 h-5" style="color: #6A0AFC;"></i>
                                    Recente Posts
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($recentPosts as $post)
                                        <article class="group">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                                <div class="flex gap-3">
                                                    @if ($post->featured_image)
                                                        <img src="{{ asset('storage/' . $post->featured_image) }}"
                                                            alt="{{ $post->title }}"
                                                            class="w-12 h-12 object-cover rounded-lg flex-shrink-0">
                                                    @else
                                                        <div
                                                            class="w-12 h-12 bg-gradient-to-br from-pink-100 to-orange-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                                            <i data-lucide="image" class="w-4 h-4 text-gray-400"></i>
                                                        </div>
                                                    @endif

                                                    <div class="flex-1">
                                                        <h4 class="font-medium text-gray-900 text-sm transition-colors line-clamp-2 mb-1"
                                                            onmouseover="this.style.color='#6A0AFC'"
                                                            onmouseout="this.style.color=''">
                                                            {{ $post->title }}
                                                        </h4>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $post->published_at->format('M d, Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Newsletter Signup -->
                        <div class="rounded-2xl p-6 text-white"
                            style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
                            <div class="text-center">
                                <div
                                    class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="mail" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-lg font-bold mb-2">Blijf op de hoogte</h3>
                                <p class="text-sm text-white/80 mb-4">Ontvang de nieuwste verhalen en updates van creatieve
                                    professionals op Curaçao</p>
                                <form class="space-y-3">
                                    <input type="email" placeholder="Je email adres"
                                        class="w-full px-4 py-2 rounded-lg bg-white border border-white/30 text-white placeholder-white focus:outline-none focus:ring-2 focus:ring-white/50">
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-white rounded-lg font-semibold hover:bg-white/90 transition-colors"
                                        style="color: #6A0AFC;">
                                        Inschrijven
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
