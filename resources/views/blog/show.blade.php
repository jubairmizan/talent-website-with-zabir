@extends('layouts.landing')

@section('title', $post->title . ' - Blog | Curaçao Talents')

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

        <!-- Breadcrumb -->
        <div class="bg-white border-b">
            <div class="container mx-auto px-6 py-4">
                <nav class="flex items-center gap-2 text-sm text-gray-600">
                    <a href="/" class="transition-colors" onmouseover="this.style.color='#6A0AFC'"
                        onmouseout="this.style.color=''">Home</a>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <a href="{{ route('blog.index') }}" class="transition-colors" onmouseover="this.style.color='#6A0AFC'"
                        onmouseout="this.style.color=''">Blog</a>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    <span class="text-gray-900">{{ $post->title }}</span>
                </nav>
            </div>
        </div>

        <div class="container mx-auto px-6 py-12">
            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                        <!-- Featured Image -->
                        @if ($post->featured_image)
                            <div class="relative h-96 overflow-hidden">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">

                                @if ($post->category)
                                    <div class="absolute top-6 left-6">
                                        <span
                                            class="px-3 py-1 bg-white/90 backdrop-blur-sm text-sm font-semibold rounded-full"
                                            style="color: #6A0AFC;">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @else
                            @if ($post->category)
                                <div class="p-6 pb-0">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full"
                                        style="background-color: rgba(106, 10, 252, 0.1); color: #6A0AFC;">
                                        {{ $post->category->name }}
                                    </span>
                                </div>
                            @endif
                        @endif

                        <div class="p-8">
                            <!-- Post Header -->
                            <header class="mb-8">
                                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                                @if ($post->excerpt)
                                    <p class="text-xl text-gray-600 mb-6">{{ $post->excerpt }}</p>
                                @endif

                                <!-- Post Meta -->
                                <div
                                    class="flex flex-wrap items-center gap-6 text-gray-600 text-sm border-b border-gray-200 pb-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                            style="background: linear-gradient(135deg, #6A0AFC, #B535FF);">
                                            <span
                                                class="text-white text-xs font-bold">{{ substr($post->author->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $post->author->name }}</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                        <span>5 min read</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                        <span>{{ $post->views_count }} views</span>
                                    </div>
                                </div>
                            </header>

                            <!-- Post Content -->
                            <div class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-a:no-underline hover:prose-a:underline"
                                style="color: #6A0AFC;">
                                {!! $post->content !!}
                            </div>

                            <!-- Post Footer -->
                            <footer class="mt-12 pt-8 border-t border-gray-200">
                                <!-- Share Buttons -->
                                <div class="mb-8">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Deel dit artikel:</h4>
                                    <div class="flex gap-3">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            <i data-lucide="facebook" class="w-4 h-4"></i>
                                            Facebook
                                        </a>

                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors">
                                            <i data-lucide="twitter" class="w-4 h-4"></i>
                                            Twitter
                                        </a>

                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                                            target="_blank"
                                            class="flex items-center gap-2 px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                                            <i data-lucide="linkedin" class="w-4 h-4"></i>
                                            LinkedIn
                                        </a>

                                        <button onclick="copyToClipboard('{{ request()->fullUrl() }}')"
                                            class="flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                            <i data-lucide="link" class="w-4 h-4"></i>
                                            Copy Link
                                        </button>
                                    </div>
                                </div>

                                <!-- Author Bio -->
                                <div class="bg-gray-50 rounded-xl p-6">
                                    <div class="flex gap-4">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0"
                                            style="background: linear-gradient(135deg, #6A0AFC, #B535FF);">
                                            <span
                                                class="text-white text-xl font-bold">{{ substr($post->author->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $post->author->name }}
                                            </h4>
                                            <p class="text-gray-600 text-sm mb-3">
                                                @if ($post->author->bio)
                                                    {{ $post->author->bio }}
                                                @else
                                                    Een gepassioneerde schrijver en creatieve professional uit Curaçao die
                                                    verhalen deelt over lokale kunst, cultuur en talent.
                                                @endif
                                            </p>
                                            <div class="flex gap-3">
                                                @if ($post->author->website)
                                                    <a href="{{ $post->author->website }}" target="_blank"
                                                        class="transition-colors" onmouseover="this.style.color='#6A0AFC'"
                                                        onmouseout="this.style.color=''">
                                                        <i data-lucide="globe" class="w-4 h-4"></i>
                                                    </a>
                                                @endif
                                                @if ($post->author->social_links && isset($post->author->social_links['twitter']))
                                                    <a href="{{ $post->author->social_links['twitter'] }}"
                                                        target="_blank" class="transition-colors"
                                                        onmouseover="this.style.color='#6A0AFC'"
                                                        onmouseout="this.style.color=''">
                                                        <i data-lucide="twitter" class="w-4 h-4"></i>
                                                    </a>
                                                @endif
                                                @if ($post->author->social_links && isset($post->author->social_links['instagram']))
                                                    <a href="{{ $post->author->social_links['instagram'] }}"
                                                        target="_blank" class="transition-colors"
                                                        onmouseover="this.style.color='#6A0AFC'"
                                                        onmouseout="this.style.color=''">
                                                        <i data-lucide="instagram" class="w-4 h-4"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </article>

                    <!-- Related Posts -->
                    @if ($relatedPosts->count() > 0)
                        <section class="mt-16">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Gerelateerde Artikelen</h2>
                            <div class="grid md:grid-cols-2 gap-8">
                                @foreach ($relatedPosts as $relatedPost)
                                    <article
                                        class="group cursor-pointer bg-white rounded-2xl shadow-sm border hover:shadow-md transition-shadow">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="block">
                                            <div class="relative overflow-hidden rounded-t-2xl">
                                                @if ($relatedPost->featured_image)
                                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}"
                                                        alt="{{ $relatedPost->title }}"
                                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div
                                                        class="w-full h-48 bg-gradient-to-br from-pink-100 to-orange-100 flex items-center justify-center">
                                                        <i data-lucide="image" class="w-8 h-8 text-gray-400"></i>
                                                    </div>
                                                @endif

                                                @if ($relatedPost->category)
                                                    <div class="absolute top-4 left-4">
                                                        <span
                                                            class="px-3 py-1 bg-white/90 backdrop-blur-sm text-xs font-semibold rounded-full"
                                                            style="color: #6A0AFC;">
                                                            {{ $relatedPost->category->name }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-6 space-y-3">
                                                <h3 class="text-lg font-bold text-gray-900 transition-colors line-clamp-2"
                                                    onmouseover="this.style.color='#6A0AFC'"
                                                    onmouseout="this.style.color=''">
                                                    {{ $relatedPost->title }}
                                                </h3>

                                                @if ($relatedPost->excerpt)
                                                    <p class="text-gray-600 text-sm line-clamp-2">
                                                        {{ $relatedPost->excerpt }}</p>
                                                @endif

                                                <div class="flex items-center justify-between text-xs text-gray-500">
                                                    <div class="flex items-center gap-2">
                                                        <i data-lucide="user" class="w-3 h-3"></i>
                                                        <span>{{ $relatedPost->author->name }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="calendar" class="w-3 h-3"></i>
                                                            <span>{{ $relatedPost->published_at->format('M d') }}</span>
                                                        </div>
                                                        <div class="flex items-center gap-1">
                                                            <i data-lucide="eye" class="w-3 h-3"></i>
                                                            <span>{{ $relatedPost->views_count }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- Table of Contents (if content has headings) -->
                        <div class="bg-white rounded-2xl shadow-sm border p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i data-lucide="list" class="w-5 h-5" style="color: #6A0AFC;"></i>
                                Inhoudsopgave
                            </h3>
                            <div class="space-y-2 text-sm" id="table-of-contents">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Featured Posts -->
                        @if ($featuredPosts->count() > 0)
                            <div class="bg-white rounded-2xl shadow-sm border p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="star" class="w-5 h-5" style="color: #6A0AFC;"></i>
                                    Uitgelicht
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($featuredPosts as $featuredPost)
                                        <article class="group">
                                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="block">
                                                <div class="flex gap-3">
                                                    @if ($featuredPost->featured_image)
                                                        <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                                                            alt="{{ $featuredPost->title }}"
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
                                                            {{ $featuredPost->title }}
                                                        </h4>
                                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                                            <span>{{ $featuredPost->published_at->format('M d') }}</span>
                                                            <span>•</span>
                                                            <span>{{ $featuredPost->views_count }} views</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </article>
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
                                    @foreach ($recentPosts as $recentPost)
                                        <article class="group">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}" class="block">
                                                <div class="flex gap-3">
                                                    @if ($recentPost->featured_image)
                                                        <img src="{{ asset('storage/' . $recentPost->featured_image) }}"
                                                            alt="{{ $recentPost->title }}"
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
                                                            {{ $recentPost->title }}
                                                        </h4>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $recentPost->published_at->format('M d, Y') }}
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
                                <p class="text-sm text-black/80 mb-4">Ontvang de nieuwste verhalen en updates van creatieve
                                    professionals op Curaçao</p>
                                <form class="space-y-3">
                                    <input type="email" placeholder="Je email adres"
                                        class="w-full px-4 py-2 rounded-lg bg-white/20 border border-white/30 text-black placeholder-black/70 focus:outline-none focus:ring-2 focus:ring-white/50">
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

        .prose {
            color: #374151;
        }

        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4,
        .prose h5,
        .prose h6 {
            color: #111827;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .prose h2 {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .prose h3 {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .prose p {
            margin-bottom: 1.25rem;
            line-height: 1.75;
        }

        .prose blockquote {
            border-left: 4px solid #ec4899;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #6b7280;
        }

        .prose ul,
        .prose ol {
            padding-left: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .prose li {
            margin-bottom: 0.5rem;
        }

        .prose img {
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }
    </style>

    <script>
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Copied!';
                button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                button.classList.add('bg-green-600');

                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700');
                }, 2000);
            });
        }

        // Generate table of contents
        document.addEventListener('DOMContentLoaded', function() {
            const toc = document.getElementById('table-of-contents');
            const headings = document.querySelectorAll('.prose h2, .prose h3, .prose h4');

            if (headings.length === 0) {
                toc.innerHTML = '<p class="text-gray-500 text-sm">Geen koppen gevonden</p>';
                return;
            }

            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.id = id;

                const link = document.createElement('a');
                link.href = '#' + id;
                link.className = 'block text-gray-700 transition-colors py-1';
                link.onmouseover = function() {
                    this.style.color = '#6A0AFC';
                };
                link.onmouseout = function() {
                    this.style.color = '';
                };
                link.textContent = heading.textContent;

                // Add indentation for different heading levels
                if (heading.tagName === 'H3') {
                    link.className += ' pl-4';
                } else if (heading.tagName === 'H4') {
                    link.className += ' pl-8';
                }

                toc.appendChild(link);
            });
        });
    </script>
@endsection
