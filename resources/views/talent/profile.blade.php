@extends('layouts.landing')

@section('title', $talent['name'] . ' - ' . $talent['profession'] . ' | Curaçao Talents')

@section('content')
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b sticky top-0 z-50">
      <div class="container mx-auto px-6 py-2">
        <div class="flex items-center justify-between">
          <!-- Logo -->
          <a href="/" class="flex items-center">
            <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-auto object-contain" style="height: 64px;">
          </a>

          <!-- Navigation -->
          <nav class="hidden md:flex items-center gap-8">
            <a href="/" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color=''">
              Home
            </a>
            <a href="/talents" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color=''">
              Discover Talents
            </a>
            {{-- <a href="/blog" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'"
                            onmouseout="this.style.color=''">
                            Blog
                        </a> --}}
            <a href="/about" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color=''">
              About
            </a>
            <a href="/contact" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color=''">
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
                  style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;" onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
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
              <div class="inline-flex items-center rounded-full border border-transparent text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
                {{ $talent['category'] }}
              </div>
              <div class="inline-flex items-center rounded-full border border-transparent bg-blue-600 text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                {{ $talent['level'] }}
              </div>
              <div class="inline-flex items-center rounded-full border border-transparent bg-green-600 text-white px-3 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2">
                {{ $talent['availability'] }}
              </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 text-gray-300">
              <div class="flex items-center gap-2">
                <div class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-full">
                  <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}" class="aspect-square h-full w-full">
                  <span class="flex h-full w-full items-center justify-center rounded-full bg-muted">{{ substr($talent['name'], 0, 2) }}</span>
                </div>
                <div>
                  <div class="text-sm">Door</div>
                  <div class="font-semibold">{{ $talent['name'] }}</div>
                </div>
              </div>
              {{-- <div class="flex items-center gap-1">
                <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                <div>
                  <div class="font-semibold">{{ $talent['rating'] }}</div>
                </div>
              </div> --}}
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

            <!-- View Mode -->
            <div id="description-view">
              <p class="text-gray-300 text-lg leading-relaxed mb-4">
                {{ $talent['description'] }}
              </p>
            </div>

            <!-- Edit Mode -->
            @if ($talent['can_edit'])
              <div id="description-edit" class="hidden mb-4">
                <textarea id="edit-description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Korte beschrijving van jezelf...">{{ $talent['profile_data']['short_bio'] ?? '' }}</textarea>
              </div>
            @endif

            <div class="flex items-center gap-6 text-sm text-gray-400">
              <span>Lid sinds {{ $talent['joinedDate'] }}</span>
              <span>Laatst actief: {{ $talent['lastActive'] }}</span>
            </div>
          </div>

          <!-- Right Column - Profile Image -->
          <div class="lg:col-span-1">
            <div class="relative rounded-lg overflow-hidden shadow-2xl" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);">
              {{-- <video class="w-full h-64 object-cover" controls>
                                <source src="{{ asset('storage/' . $talent['featured_video']) }}" type="video/mp4">
                                <source src="{{ asset('storage/' . $talent['featured_video']) }}" type="video/webm">
                                <source src="{{ asset('storage/' . $talent['featured_video']) }}" type="video/ogg">
                                Your browser does not support the video tag.
                            </video> --}}
              {{-- <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}"
                                class="w-full h-64 object-cover" /> --}}

              @if ($talent['profile_data']['youtube_profile_url'])
                <iframe class="w-full h-64" src="{{ $talent['profile_data']['youtube_profile_url'] }}?autoplay=1&controls=0&loop=1&rel=0&enablejsapi=1" title="YouTube video player" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>
                </iframe>
              @else
                <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}" class="w-full h-64 object-cover" />
              @endif
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
            <div class="grid grid-cols-3 h-10 items-center justify-center rounded-md bg-muted p-1 text-muted-foreground w-full">
              <button id="tab-about" onclick="switchTab('about')"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-background text-foreground shadow-sm">Over
                Talent</button>
              <button id="tab-portfolio" onclick="switchTab('portfolio')"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Portfolio</button>
              <button id="tab-qa" onclick="switchTab('qa')"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Q&A</button>
            </div>

            <!-- Portfolio Tab -->
            <div id="content-portfolio" class="tab-content space-y-6 hidden">
              <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold text-gray-900">Mijn Portfolio</h3>
                <div class="flex gap-2">
                  @if ($talent['can_edit'])
                    <button onclick="openUploadModal()" id="upload-portfolio-btn" class="hidden items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium text-white h-9 px-3"
                      style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);" onmouseover="this.style.background='#6A0AFC'" onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                      <i data-lucide="plus" class="w-4 h-4"></i>
                      Upload Media
                    </button>
                  @endif

                </div>
              </div>
              <div class="grid md:grid-cols-2 gap-6">
                @if (!empty($talent['portfolio']))
                  @foreach ($talent['portfolio'] as $item)
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm overflow-hidden hover:shadow-lg transition-shadow cursor-pointer group" onclick="handlePortfolioClick({{ json_encode($item) }})">
                      <div class="p-0">
                        <div class="relative">
                          <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                          <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                            <i data-lucide="camera" class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                          </div>
                          @if ($talent['can_edit'])
                            <button onclick="event.stopPropagation(); deletePortfolioItem({{ $item['id'] }})"
                              class="portfolio-delete-btn hidden absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-colors">
                              <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                          @endif
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
                @else
                  <div class="col-span-2 text-center py-8">
                    <i data-lucide="folder" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <p class="text-gray-500">Nog geen portfolio items beschikbaar.</p>
                  </div>
                @endif
              </div>
            </div>

            <!-- About Tab -->
            <div id="content-about" class="tab-content space-y-8">
              <!-- About Section -->
              <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Over
                  {{ $talent['name'] ?? 'Deze Talent' }}</h3>

                <!-- View Mode -->
                <div id="about-view" class="prose max-w-none">
                  @if (!empty($talent['about']) && trim($talent['about']) !== '')
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line mb-6">
                      {{ $talent['about'] }}
                    </p>
                  @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                      <div class="flex items-center gap-3 text-gray-500">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <p class="text-sm">Deze talent heeft nog geen persoonlijke beschrijving
                          toegevoegd.</p>
                      </div>
                    </div>
                  @endif

                  @if (!empty($talent['workingProcess']) && trim($talent['workingProcess']) !== '')
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Werkwijze</h4>
                    <p class="text-gray-700 leading-relaxed mb-6">
                      {{ $talent['workingProcess'] }}
                    </p>
                  @endif
                </div>

                <!-- Edit Mode -->
                @if ($talent['can_edit'])
                  <div id="about-edit" class="hidden">
                    <div class="space-y-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Over
                          mij</label>
                        <textarea id="edit-about" rows="6" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Vertel over jezelf, je ervaring en passie...">{{ $talent['profile_data']['about_me'] ?? '' }}</textarea>
                      </div>
                    </div>
                  </div>
                @endif
              </div>

              <!-- Skills and Languages Grid -->
              <div class="grid md:grid-cols-2 gap-8">
                <!-- Skills Section -->
                <div>
                  <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i data-lucide="palette" class="w-5 h-5 text-pink-600"></i>
                    Vaardigheden
                    @if (!empty($talent['skills']) && is_array($talent['skills']) && count($talent['skills']) > 0)
                      <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                        {{ count($talent['skills']) }}
                      </span>
                    @endif
                  </h4>
                  <div class="flex flex-wrap gap-2">
                    @if (!empty($talent['skills']) && is_array($talent['skills']) && count($talent['skills']) > 0)
                      @foreach ($talent['skills'] as $skill)
                        @if (!empty(trim($skill)))
                          <div
                            class="inline-flex items-center rounded-full border border-transparent bg-gradient-to-r from-pink-100 to-orange-100 text-pink-700 px-2.5 py-0.5 text-xs font-semibold transition-colors hover:from-pink-200 hover:to-orange-200 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                            {{ trim($skill) }}
                          </div>
                        @endif
                      @endforeach
                    @else
                      <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-3 text-gray-500">
                          <i data-lucide="palette" class="w-4 h-4"></i>
                          <p class="text-sm">Geen vaardigheden opgegeven.</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Languages Section -->
                <div>
                  <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i data-lucide="globe" class="w-5 h-5 text-pink-600"></i>
                    Talen
                    @if (!empty($talent['languages']) && is_array($talent['languages']) && count($talent['languages']) > 0)
                      <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                        {{ count($talent['languages']) }}
                      </span>
                    @endif
                  </h4>
                  <div class="flex flex-wrap gap-2">
                    @if (!empty($talent['languages']) && is_array($talent['languages']) && count($talent['languages']) > 0)
                      @foreach ($talent['languages'] as $language)
                        @if (!empty(trim($language)))
                          <div
                            class="inline-flex items-center rounded-full border border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            {{ trim($language) }}
                          </div>
                        @endif
                      @endforeach
                    @else
                      <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-3 text-gray-500">
                          <i data-lucide="globe" class="w-4 h-4"></i>
                          <p class="text-sm">Geen talen opgegeven.</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Social Media Section (Edit Mode Only) -->
              @if ($talent['can_edit'])
                <div id="social-media-edit" class="hidden">
                  <h4 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i data-lucide="share-2" class="w-5 h-5 text-pink-600"></i>
                    Social Media Links
                  </h4>
                  <div class="grid md:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                      <input type="url" id="edit-website" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="https://jouwwebsite.com"
                        value="{{ $talent['profile_data']['website_url'] ?? '' }}">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                      <input type="url" id="edit-instagram" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="https://instagram.com/gebruikersnaam" value="{{ $talent['profile_data']['instagram_url'] ?? '' }}">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                      <input type="url" id="edit-facebook" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="https://facebook.com/gebruikersnaam"
                        value="{{ $talent['profile_data']['facebook_url'] ?? '' }}">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                      <input type="url" id="edit-linkedin" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        placeholder="https://linkedin.com/in/gebruikersnaam" value="{{ $talent['profile_data']['linkedin_url'] ?? '' }}">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                      <input type="url" id="edit-youtube" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="https://youtube.com/c/kanaal"
                        value="{{ $talent['profile_data']['youtube_url'] ?? '' }}">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                      <input type="url" id="edit-tiktok" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="https://tiktok.com/@gebruikersnaam"
                        value="{{ $talent['profile_data']['tiktok_url'] ?? '' }}">
                    </div>
                  </div>

                  <!-- Save/Cancel Buttons -->
                  <div class="flex gap-3 pt-4 border-t border-gray-200">
                    <button onclick="saveProfile()" class="text-white font-semibold py-2 px-6 rounded-md transition-colors" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);" onmouseover="this.style.background='#6A0AFC'"
                      onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                      Opslaan
                    </button>
                    <button onclick="cancelEdit()" class="border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-6 rounded-md transition-colors">
                      Annuleren
                    </button>
                  </div>
                </div>
              @endif

              <!-- Education and Awards Grid -->
              <div class="grid md:grid-cols-2 gap-8">
                <!-- Education Section -->
                <div>
                  <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i data-lucide="graduation-cap" class="w-5 h-5 text-pink-600"></i>
                    Opleiding
                    @if (!empty($talent['education']) && is_array($talent['education']) && count($talent['education']) > 0)
                      <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                        {{ count($talent['education']) }}
                      </span>
                    @endif
                  </h4>
                  <div class="space-y-3">
                    @if (!empty($talent['education']) && is_array($talent['education']) && count($talent['education']) > 0)
                      @foreach ($talent['education'] as $edu)
                        @if (is_array($edu) && (!empty($edu['degree']) || !empty($edu['school']) || !empty($edu['year'])))
                          <div class="border-l-2 border-pink-200 pl-4 hover:border-pink-300 transition-colors">
                            @if (!empty($edu['degree']))
                              <div class="font-medium text-gray-900">{{ $edu['degree'] }}
                              </div>
                            @endif
                            @if (!empty($edu['school']))
                              <div class="text-sm text-gray-600">{{ $edu['school'] }}</div>
                            @endif
                            @if (!empty($edu['year']))
                              <div class="text-xs text-gray-500">{{ $edu['year'] }}</div>
                            @endif
                          </div>
                        @endif
                      @endforeach
                    @else
                      <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-3 text-gray-500">
                          <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                          <p class="text-sm">Geen opleiding informatie beschikbaar.</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>

                <!-- Awards Section -->
                <div>
                  <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                    <i data-lucide="trophy" class="w-5 h-5 text-pink-600"></i>
                    Onderscheidingen
                    @if (!empty($talent['awards']) && is_array($talent['awards']) && count($talent['awards']) > 0)
                      <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                        {{ count($talent['awards']) }}
                      </span>
                    @endif
                  </h4>
                  <div class="space-y-2">
                    @if (!empty($talent['awards']) && is_array($talent['awards']) && count($talent['awards']) > 0)
                      @foreach ($talent['awards'] as $award)
                        @if (!empty(trim($award)))
                          <div class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600 flex-shrink-0"></i>
                            <span class="text-sm text-gray-700">{{ trim($award) }}</span>
                          </div>
                        @endif
                      @endforeach
                    @else
                      <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center gap-3 text-gray-500">
                          <i data-lucide="trophy" class="w-4 h-4"></i>
                          <p class="text-sm">Geen onderscheidingen beschikbaar.</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Certifications Section -->
              <div>
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                  <i data-lucide="briefcase" class="w-5 h-5 text-pink-600"></i>
                  Certificeringen
                  @if (!empty($talent['certifications']) && is_array($talent['certifications']) && count($talent['certifications']) > 0)
                    <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                      {{ count($talent['certifications']) }}
                    </span>
                  @endif
                </h4>
                <div class="flex flex-wrap gap-2">
                  @if (!empty($talent['certifications']) && is_array($talent['certifications']) && count($talent['certifications']) > 0)
                    @foreach ($talent['certifications'] as $cert)
                      @if (!empty(trim($cert)))
                        <div
                          class="inline-flex items-center rounded-full border border-transparent bg-blue-100 text-blue-700 hover:bg-blue-200 px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                          {{ trim($cert) }}
                        </div>
                      @endif
                    @endforeach
                  @else
                    <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-4">
                      <div class="flex items-center gap-3 text-gray-500">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                        <p class="text-sm">Geen certificeringen beschikbaar.</p>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>



            <!-- Q&A Tab -->
            <div id="content-qa" class="tab-content space-y-6 hidden">
              <div class="mt-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6">Veelgestelde Vragen</h3>

                <div class="space-y-4">
                  @if (!empty($talent['faqs']))
                    @foreach ($talent['faqs'] as $index => $faq)
                      <div class="faq-item border border-gray-200 rounded-lg">
                        <button type="button" class="faq-button w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors duration-200"
                          data-target="faq-{{ $index }}">
                          <span class="font-medium text-gray-900">{{ $faq['question'] }}</span>
                          <i data-lucide="chevron-down" class="faq-icon w-5 h-5 text-gray-500 transition-transform duration-200"></i>
                        </button>
                        <div id="faq-{{ $index }}" class="faq-content hidden px-6 pb-4">
                          <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] }}</p>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="text-center py-8">
                      <i data-lucide="help-circle" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                      <p class="text-gray-500">Nog geen veelgestelde vragen beschikbaar.</p>
                    </div>
                  @endif
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
                </div>

                <div class="space-y-3 mb-6">
                  <button onclick="openBookingForm()" class="w-full text-white font-semibold py-3 px-4 rounded-md transition-colors" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);"
                    onmouseover="this.style.background='#6A0AFC'" onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                    Boek Nu
                  </button>
                  @auth
                    @if (auth()->user()->role === 'member')
                      <button onclick="toggleTalentFavorite({{ $talent['creator_profile_id'] }}, this)"
                        class="favorite-btn w-full border-2 py-3 px-4 rounded-md flex items-center justify-center gap-2 transition-colors {{ $talent['is_favorited'] ? 'border-red-300 bg-red-50 text-red-600' : 'border-gray-300 hover:bg-gray-50' }}"
                        data-favorited="{{ $talent['is_favorited'] ? 'true' : 'false' }}">
                        <i data-lucide="heart" class="w-4 h-4 {{ $talent['is_favorited'] ? 'fill-current' : '' }}"></i>
                        <span class="favorite-text">{{ $talent['is_favorited'] ? 'Uit Favorieten' : 'Voeg toe aan Favorieten' }}</span>
                      </button>
                    @else
                      <button onclick="alert('Only members can favorite creators')" class="w-full border-2 border-gray-300 hover:bg-gray-50 py-3 px-4 rounded-md flex items-center justify-center gap-2 transition-colors">
                        <i data-lucide="heart" class="w-4 h-4"></i>
                        Voeg toe aan Favorieten
                      </button>
                    @endif
                  @else
                    <button onclick="confirmLoginForProfileFavorite()" class="w-full border-2 border-gray-300 hover:bg-gray-50 py-3 px-4 rounded-md flex items-center justify-center gap-2 transition-colors">
                      <i data-lucide="heart" class="w-4 h-4"></i>
                      Voeg toe aan Favorieten
                    </button>
                  @endauth

                  @if ($talent['can_edit'])
                    <button onclick="toggleEditMode()" id="editToggleBtn" class="w-full border-2 border-blue-300 bg-blue-50 text-blue-600 hover:bg-blue-100 py-3 px-4 rounded-md flex items-center justify-center gap-2 transition-colors">
                      <i data-lucide="edit" class="w-4 h-4"></i>
                      <span>Bewerk Profiel</span>
                    </button>
                  @endif
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

            <!-- Instagram Feed (Hidden) -->
            <div class="hidden rounded-lg border bg-card text-card-foreground shadow-lg">
              <div class="p-6">
                <div class="flex items-center gap-2 mb-4">
                  <i data-lucide="instagram" class="w-5 h-5 text-pink-600"></i>
                  <h3 class="font-semibold text-gray-900">Instagram Feed</h3>
                  <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="ml-auto text-pink-600 hover:text-pink-700">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                  </a>
                </div>

                <div class="grid grid-cols-2 gap-3">
                  @if (!empty($talent['instagramPosts']))
                    @foreach ($talent['instagramPosts'] as $post)
                      <div class="relative group cursor-pointer">
                        <div class="aspect-square overflow-hidden rounded-lg">
                          <img src="{{ $post['image'] }}" alt="Instagram post" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                        </div>

                        <!-- Hover overlay -->
                        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
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
                        <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                          {{ $post['timeAgo'] }}
                        </div>
                      </div>
                    @endforeach
                  @else
                    <div class="col-span-2 text-center py-8">
                      <i data-lucide="instagram" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                      <p class="text-gray-500">Geen Instagram posts beschikbaar.</p>
                    </div>
                  @endif
                </div>

                <div class="mt-4 text-center">
                  <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="text-pink-600 hover:text-pink-700 font-medium text-sm flex items-center justify-center gap-2">
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
                  <button class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Bel Direct
                  </button>
                  <button class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    Email
                  </button>
                  <button class="w-full justify-start border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-md flex items-center gap-2 transition-colors">
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
        <button onclick="closePortfolioModal()" class="absolute top-4 right-4 z-10 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors">
          <i data-lucide="x" class="w-6 h-6 text-gray-600"></i>
        </button>

        <!-- Modal content -->
        <div id="modal-content" class="p-6">
          <!-- Content will be populated by JavaScript -->
        </div>
      </div>
    </div>
  </div>

  <!-- Upload Portfolio Modal -->
  @if ($talent['can_edit'])
    <div id="upload-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
      <div class="bg-white rounded-lg max-w-md w-full">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Upload Portfolio Item</h3>
            <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-600">
              <i data-lucide="x" class="w-6 h-6"></i>
            </button>
          </div>

          <form id="upload-form" class="space-y-4">
            @csrf
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Titel</label>
              <input type="text" id="upload-title" name="title" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Titel van je werk" required>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Beschrijving</label>
              <textarea id="upload-description" name="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Beschrijf je werk..."></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Bestand</label>
              <input type="file" id="upload-file" name="file" accept="image/*,video/*" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent" required>
              <p class="text-xs text-gray-500 mt-1">Ondersteunde formaten: JPG, PNG, GIF, MP4, MOV, AVI (max
                20MB)</p>
            </div>

            <div class="flex gap-3 pt-4">
              <button type="submit" class="flex-1 text-white font-semibold py-2 px-4 rounded-md transition-colors" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);" onmouseover="this.style.background='#6A0AFC'"
                onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
                Upload
              </button>
              <button type="button" onclick="closeUploadModal()" class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-2 px-4 rounded-md transition-colors">
                Annuleren
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  @endif

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
                  <button onclick="contactAboutProject()" class="inline-flex items-center gap-2 px-4 py-2 text-white rounded-md transition-colors" style="background: linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%);" onmouseover="this.style.background='#6A0AFC'" onmouseout="this.style.background='linear-gradient(135deg, #6A0AFC 0%, #B535FF 100%)'">
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
          `Contact over "${selectedPortfolioItem.title}" - bericht functionaliteit zou hier geïmplementeerd worden`
        );
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
          title: {!! json_encode($talent['name'] . ' - ' . $talent['profession']) !!},
          text: {!! json_encode($talent['description']) !!},
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

    function openBookingForm() {
      alert('Boekingsformulier openen - functionaliteit zou hier geïmplementeerd worden');
    }

    function contactTalent() {
      @auth
      @if (auth()->user()->isMember())
        // Get creator ID from the page data
        const creatorId = {{ $creatorProfile->id ?? 'null' }};
        const creatorName = '{{ $creatorProfile->user->name ?? '' }}';

        if (creatorId && window.openConversation) {
          window.openConversation(creatorId, creatorName);
        } else {
          showProfileToast('Chat system is loading. Please try again in a moment.', 'error');
        }
      @else
        showProfileToast('Only members can chat with creators.', 'error');
      @endif
    @else
      window.location.href = '{{ route('login') }}';
    @endauth
    }

    function toggleTalentFavorite(creatorProfileId, button) {
      // Add loading state
      const originalContent = button.innerHTML;
      button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i><span>Loading...</span>';
      button.disabled = true;

      fetch(`/favorites/toggle/${creatorProfileId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update button with proper content structure
            if (data.is_favorited) {
              // Now favorited - show proper filled heart
              button.classList.remove('border-gray-300', 'hover:bg-gray-50');
              button.classList.add('border-red-300', 'bg-red-50', 'text-red-600');
              button.innerHTML =
                '<i data-lucide="heart" class="w-4 h-4 fill-current"></i><span class="favorite-text">Uit Favorieten</span>';
              button.setAttribute('data-favorited', 'true');
            } else {
              // No longer favorited
              button.classList.remove('border-red-300', 'bg-red-50', 'text-red-600');
              button.classList.add('border-gray-300', 'hover:bg-gray-50');
              button.innerHTML =
                '<i data-lucide="heart" class="w-4 h-4"></i><span class="favorite-text">Voeg toe aan Favorieten</span>';
              button.setAttribute('data-favorited', 'false');
            }

            // Re-initialize Lucide icons for the updated content
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
            }

            // Show success confirmation with toast
            showProfileToast(data.message, 'success');
          } else {
            // Restore original content on error
            button.innerHTML = originalContent;
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
            }
            showProfileToast(data.message || 'Error updating favorite', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          button.innerHTML = originalContent;
          if (typeof lucide !== 'undefined') {
            lucide.createIcons();
          }
          showProfileToast('Error updating favorite', 'error');
        })
        .finally(() => {
          button.disabled = false;
        });
    }

    // Toast notification function for profile page
    function showProfileToast(message, type = 'success') {
      // Remove existing toast if any
      const existingToast = document.getElementById('profile-toast-notification');
      if (existingToast) {
        existingToast.remove();
      }

      // Create toast element
      const toast = document.createElement('div');
      toast.id = 'profile-toast-notification';
      toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
      }`;
      toast.innerHTML = `
        <div class="flex items-center gap-2">
          <i data-lucide="${type === 'success' ? 'check-circle' : 'x-circle'}" class="w-4 h-4"></i>
          <span>${message}</span>
        </div>
      `;

      // Add to page
      document.body.appendChild(toast);

      // Initialize lucide icons
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }

      // Animate in
      setTimeout(() => {
        toast.style.transform = 'translateX(0)';
      }, 10);

      // Auto remove after 3 seconds
      setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
          if (toast.parentNode) {
            toast.remove();
          }
        }, 300);
      }, 3000);
    }

    // Confirmation for guest users on profile page
    function confirmLoginForProfileFavorite() {
      if (confirm(
          'Om deze getalenteerde creator aan je favorieten toe te voegen, moet je eerst inloggen. Wil je naar de inlogpagina gaan?'
        )) {
        window.location.href = '/login';
      }
    }

    // Profile editing functionality
    let isEditMode = false;

    function toggleEditMode() {
      isEditMode = !isEditMode;
      const editToggleBtn = document.getElementById('editToggleBtn');
      const uploadBtn = document.getElementById('upload-portfolio-btn');
      const deleteButtons = document.querySelectorAll('.portfolio-delete-btn');

      // Toggle edit elements visibility
      const editElements = [
        'description-edit', 'about-edit', 'social-media-edit'
      ];
      const viewElements = [
        'description-view', 'about-view'
      ];

      if (isEditMode) {
        // Show edit mode
        editElements.forEach(id => {
          const element = document.getElementById(id);
          if (element) element.classList.remove('hidden');
        });
        viewElements.forEach(id => {
          const element = document.getElementById(id);
          if (element) element.classList.add('hidden');
        });

        if (uploadBtn) {
          uploadBtn.classList.remove('hidden');
          uploadBtn.classList.add('inline-flex');
        }
        deleteButtons.forEach(btn => {
          btn.classList.remove('hidden');
          btn.classList.add('flex');
        });

        editToggleBtn.innerHTML = '<i data-lucide="x" class="w-4 h-4"></i><span>Annuleren</span>';
        editToggleBtn.classList.remove('border-blue-300', 'bg-blue-50', 'text-blue-600');
        editToggleBtn.classList.add('border-gray-300', 'bg-gray-50', 'text-gray-600');
      } else {
        // Show view mode
        editElements.forEach(id => {
          const element = document.getElementById(id);
          if (element) element.classList.add('hidden');
        });
        viewElements.forEach(id => {
          const element = document.getElementById(id);
          if (element) element.classList.remove('hidden');
        });

        if (uploadBtn) {
          uploadBtn.classList.add('hidden');
          uploadBtn.classList.remove('inline-flex');
        }
        deleteButtons.forEach(btn => {
          btn.classList.add('hidden');
          btn.classList.remove('flex');
        });

        editToggleBtn.innerHTML = '<i data-lucide="edit" class="w-4 h-4"></i><span>Bewerk Profiel</span>';
        editToggleBtn.classList.add('border-blue-300', 'bg-blue-50', 'text-blue-600');
        editToggleBtn.classList.remove('border-gray-300', 'bg-gray-50', 'text-gray-600');
      }

      // Re-initialize Lucide icons
      if (typeof lucide !== 'undefined') {
        lucide.createIcons();
      }
    }

    function saveProfile() {
      const formData = new FormData();
      formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
      formData.append('_method', 'PUT');

      // Collect form data
      const shortBio = document.getElementById('edit-description')?.value || '';
      const aboutMe = document.getElementById('edit-about')?.value || '';
      const websiteUrl = document.getElementById('edit-website')?.value || '';
      const instagramUrl = document.getElementById('edit-instagram')?.value || '';
      const facebookUrl = document.getElementById('edit-facebook')?.value || '';
      const linkedinUrl = document.getElementById('edit-linkedin')?.value || '';
      const youtubeUrl = document.getElementById('edit-youtube')?.value || '';
      const tiktokUrl = document.getElementById('edit-tiktok')?.value || '';

      formData.append('short_bio', shortBio);
      formData.append('about_me', aboutMe);
      formData.append('website_url', websiteUrl);
      formData.append('instagram_url', instagramUrl);
      formData.append('facebook_url', facebookUrl);
      formData.append('linkedin_url', linkedinUrl);
      formData.append('youtube_url', youtubeUrl);
      formData.append('tiktok_url', tiktokUrl);

      fetch('/creator/profile', {
          method: 'POST',
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showProfileToast('Profiel succesvol bijgewerkt!', 'success');
            // Refresh the page to show updated data
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            showProfileToast(data.message || 'Er is een fout opgetreden', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showProfileToast('Er is een fout opgetreden bij het opslaan', 'error');
        });
    }

    function cancelEdit() {
      toggleEditMode();
    }

    // Portfolio management
    function openUploadModal() {
      document.getElementById('upload-modal').classList.remove('hidden');
      document.getElementById('upload-modal').classList.add('flex');
    }

    function closeUploadModal() {
      document.getElementById('upload-modal').classList.add('hidden');
      document.getElementById('upload-modal').classList.remove('flex');
      document.getElementById('upload-form').reset();
    }

    function deletePortfolioItem(itemId) {
      if (!confirm('Weet je zeker dat je dit portfolio item wilt verwijderen?')) {
        return;
      }

      fetch(`/creator/portfolio/${itemId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showProfileToast('Portfolio item verwijderd!', 'success');
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          } else {
            showProfileToast(data.message || 'Er is een fout opgetreden', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showProfileToast('Er is een fout opgetreden bij het verwijderen', 'error');
        });
    }

    // Handle upload form submission
    document.addEventListener('DOMContentLoaded', function() {
      const uploadForm = document.getElementById('upload-form');
      if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
          e.preventDefault();

          const formData = new FormData(this);
          const submitBtn = this.querySelector('button[type="submit"]');
          const originalText = submitBtn.textContent;

          submitBtn.textContent = 'Uploading...';
          submitBtn.disabled = true;

          fetch('/creator/portfolio', {
              method: 'POST',
              body: formData,
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                showProfileToast('Portfolio item geüpload!', 'success');
                closeUploadModal();
                setTimeout(() => {
                  window.location.reload();
                }, 1500);
              } else {
                showProfileToast(data.message || 'Er is een fout opgetreden', 'error');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              showProfileToast('Er is een fout opgetreden bij het uploaden', 'error');
            })
            .finally(() => {
              submitBtn.textContent = originalText;
              submitBtn.disabled = false;
            });
        });
      }
    });

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
  </script>

  @auth
    <!-- Chat Interface for authenticated users -->
    <x-chat-interface />
  @endauth
@endsection
