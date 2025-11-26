@extends('layouts.landing')

@section('title', 'Discover Talents - Curaçao Talents')

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
            <a href="/" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color='rgb(55, 65, 81)'">
              Home
            </a>
            <a href="/talents" style="color: #6A0AFC;" class="font-medium">
              Discover Talents
            </a>
            {{-- <a href="/blog" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color='rgb(55, 65, 81)'">
              Blog
            </a> --}}
            <a href="/about" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color='rgb(55, 65, 81)'">
              About
            </a>
            <a href="/contact" class="text-gray-700 transition-colors" onmouseover="this.style.color='#6A0AFC'" onmouseout="this.style.color='rgb(55, 65, 81)'">
              Contact
            </a>
          </nav>

          <!-- User Actions -->
          <div class="flex items-center gap-4">
            @guest
              <div class="flex items-center gap-3">
                <a href="/login">
                  <button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-3">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                    Login
                  </button>
                </a>
                <a href="/register">
                  <button
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-9 px-3"
                    style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;" onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
                    onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                    Sign Up
                  </button>
                </a>
              </div>
            @else
              <div class="flex items-center gap-3">
                <span class="text-sm text-gray-600">
                  Welcome,
                  {{ auth()->user()->role === 'admin' ? 'Admin' : (auth()->user()->role === 'creator' ? 'Creator' : 'User') }}
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
            @endguest
          </div>
        </div>
      </div>
    </header>

    <div class="container mx-auto px-6 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Ontdek Talenten</h1>
        <p class="text-xl text-gray-600">Vind de perfecte creator voor jouw project</p>
      </div>

      <!-- Filters -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('talents') }}" id="filter-form">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div class="relative">
              <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
              <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Zoek talenten, diensten..."
                class="flex h-10 w-full rounded-md border border-gray-300 bg-white pl-10 pr-3 py-2 text-sm placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                onchange="document.getElementById('filter-form').submit()" />
            </div>

            <select name="category" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              onchange="document.getElementById('filter-form').submit()">
              @foreach ($categories as $category)
                <option value="{{ $category['value'] }}" {{ $selectedCategory === $category['value'] ? 'selected' : '' }}>
                  {{ $category['label'] }}
                </option>
              @endforeach
            </select>

            {{-- <select name="location" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
              onchange="document.getElementById('filter-form').submit()">
              @foreach ($locations as $location)
                <option value="{{ $location['value'] }}" {{ $selectedLocation === $location['value'] ? 'selected' : '' }}>
                  {{ $location['label'] }}
                </option>
              @endforeach
            </select> --}}

            <div class="flex gap-2">
              <button type="button" onclick="setViewMode('grid')"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-9 px-3 {{ $viewMode === 'grid' ? 'bg-gray-900 text-white' : 'border border-gray-300 bg-white hover:bg-gray-50' }}">
                <i data-lucide="grid-3x3" class="w-4 h-4"></i>
              </button>
              <button type="button" onclick="setViewMode('list')"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-9 px-3 {{ $viewMode === 'list' ? 'bg-gray-900 text-white' : 'border border-gray-300 bg-white hover:bg-gray-50' }}">
                <i data-lucide="list" class="w-4 h-4"></i>
              </button>
            </div>
          </div>

          <input type="hidden" name="view" id="view-mode" value="{{ $viewMode }}">
        </form>

        <div class="flex items-center justify-between">
          <p class="text-sm text-gray-600">
            {{ $filteredTalents->count() }} talenten gevonden
          </p>
          <div class="flex items-center gap-3">
            <a href="{{ route('register') }}?role=talent" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors text-white h-9 px-4"
              style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;" onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
              onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
              <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
              Register as Creator
            </a>
            <button class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-gray-300 bg-white hover:bg-gray-50 h-9 px-3">
              <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
              Meer Filters
            </button>
          </div>
        </div>
      </div>

      <!-- Results -->
      @if ($viewMode === 'grid')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="grid-view">
          @foreach ($filteredTalents as $talent)
            <div class="rounded-lg bg-white group hover:shadow-xl transition-all duration-300 cursor-pointer shadow-md overflow-hidden border border-gray-200">
              <div class="p-0">
                <div class="relative">
                  <a href="/talent/{{ $talent['id'] }}">
                    <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 cursor-pointer" />
                  </a>
                  @if ($talent['verified'])
                    <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-blue-500 text-white absolute top-3 left-3">
                      Geverifieerd
                    </div>
                  @endif
                  @if ($talent['featured'])
                    <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold text-white absolute top-3 right-3" style="background: linear-gradient(to right, #6A0AFC, #B535FF);">
                      Featured
                    </div>
                  @endif
                  @auth
                    @if (auth()->user()->role === 'member')
                      <button onclick="toggleFavorite({{ $talent['creator_profile_id'] }}, this)"
                        class="favorite-btn inline-flex items-center justify-center text-sm font-medium transition-colors h-9 w-9 absolute bottom-3 right-3 bg-white/80 hover:bg-white rounded-full {{ $talent['is_favorited'] ? 'text-red-500' : 'text-gray-700' }}"
                        data-favorited="{{ $talent['is_favorited'] ? 'true' : 'false' }}">
                        <i data-lucide="heart" class="w-4 h-4 {{ $talent['is_favorited'] ? 'fill-current' : '' }}"></i>
                      </button>
                    @endif
                  @else
                    <button onclick="confirmLoginForFavorite()" class="inline-flex items-center justify-center text-sm font-medium transition-colors h-9 w-9 absolute bottom-3 right-3 bg-white/80 hover:bg-white text-gray-700 rounded-full">
                      <i data-lucide="heart" class="w-4 h-4"></i>
                    </button>
                  @endauth
                </div>

                <div class="p-6">
                  <div class="flex items-center gap-2 mb-3">
                    <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                      <img class="aspect-square h-full w-full object-cover" src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}" />
                    </div>
                    <div>
                      <a href="/talent/{{ $talent['id'] }}" class="hover:text-pink-600 transition-colors">
                        <h3 class="font-bold text-gray-900 text-lg cursor-pointer">{{ $talent['name'] }}</h3>
                      </a>
                      <p class="text-gray-600 text-sm">{{ $talent['profession'] }}</p>
                    </div>
                  </div>

                  <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                    <div class="flex items-center gap-1">
                      <i data-lucide="map-pin" class="w-4 h-4"></i>
                      <span>{{ $talent['location'] }}</span>
                    </div>
                    {{-- <div class="flex items-center gap-1">
                      <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                      <span>{{ $talent['rating'] }} ({{ $talent['reviewCount'] }})</span>
                    </div> --}}
                  </div>

                  <div class="flex flex-wrap gap-1 mb-4">
                    @foreach (array_slice($talent['skills'], 0, 3) as $skill)
                      <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold text-white"
                        style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.8), rgba(181, 53, 255, 0.8)); border: 1px solid rgba(106, 15, 252, 0.3);">
                        {{ $skill }}
                      </div>
                    @endforeach
                  </div>

                  <div class="flex items-center justify-between">
                    {{-- <div>
                      <p class="text-sm text-gray-600">Vanaf</p>
                      <p class="text-xl font-bold text-gray-900">€{{ $talent['priceFrom'] }}</p>
                    </div> --}}
                    <a href="/talent/{{ $talent['id'] }}">
                      <button class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors text-white h-10 px-4 py-2" style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;"
                        onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'" onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                        Bekijk Profiel
                      </button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="space-y-4" id="list-view">
          @foreach ($filteredTalents as $talent)
            <div class="rounded-lg border border-gray-200 bg-white shadow-sm hover:shadow-lg transition-shadow">
              <div class="p-6">
                <div class="flex items-center gap-6">
                  <div class="relative">
                    <a href="/talent/{{ $talent['id'] }}">
                      <img src="{{ $talent['profileImage'] }}" alt="{{ $talent['name'] }}" class="w-24 h-24 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity" />
                    </a>
                    @if ($talent['featured'])
                      <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold text-white absolute -top-2 -right-2" style="background: linear-gradient(to right, #6A0AFC, #B535FF);">
                        Featured
                      </div>
                    @endif
                  </div>

                  <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                      <div>
                        <div class="flex items-center gap-2">
                          <a href="/talent/{{ $talent['id'] }}" class="hover:text-pink-600 transition-colors">
                            <h3 class="text-xl font-bold text-gray-900 cursor-pointer">{{ $talent['name'] }}</h3>
                          </a>
                          @if ($talent['verified'])
                            <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-blue-500 text-white">
                              Geverifieerd
                            </div>
                          @endif
                        </div>
                        <p class="text-gray-600">{{ $talent['profession'] }}</p>
                      </div>
                      @auth
                        @if (auth()->user()->role === 'member')
                          <button onclick="toggleFavorite({{ $talent['creator_profile_id'] }}, this)"
                            class="favorite-btn inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-9 px-3 hover:bg-gray-50 {{ $talent['is_favorited'] ? 'text-red-500' : 'text-gray-500' }}"
                            data-favorited="{{ $talent['is_favorited'] ? 'true' : 'false' }}" onmouseover="if(!this.classList.contains('text-red-500')) this.style.color='#6A0AFC'"
                            onmouseout="if(!this.classList.contains('text-red-500')) this.style.color='rgb(107, 114, 128)'">
                            <i data-lucide="heart" class="w-5 h-5 {{ $talent['is_favorited'] ? 'fill-current' : '' }}"></i>
                          </button>
                        @endif
                      @else
                        <button onclick="confirmLoginForFavorite()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors h-9 px-3 text-gray-500 hover:bg-gray-50" onmouseover="this.style.color='#6A0AFC'"
                          onmouseout="this.style.color='rgb(107, 114, 128)'" <i data-lucide="heart" class="w-5 h-5"></i>
                        </button>
                      @endauth
                    </div>

                    <div class="flex items-center gap-4 mb-3 text-sm text-gray-500">
                      <div class="flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <span>{{ $talent['location'] }}</span>
                      </div>
                      <div class="flex items-center gap-1">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <span>{{ $talent['rating'] }} ({{ $talent['reviewCount'] }}
                          reviews)</span>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-1 mb-4">
                      @foreach ($talent['skills'] as $skill)
                        <div class="inline-flex items-center rounded-full border border-gray-300 px-2.5 py-0.5 text-xs font-semibold">
                          {{ $skill }}
                        </div>
                      @endforeach
                    </div>

                    <div class="flex items-center justify-between">
                      <div>
                        <p class="text-sm text-gray-600">Vanaf €{{ $talent['priceFrom'] }}</p>
                      </div>
                      <div class="flex gap-2">
                        @auth
                          @if (auth()->user()->isMember())
                            <button onclick="openChatWithCreator({{ $talent['id'] }}, '{{ $talent['name'] }}')"
                              class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                              <i data-lucide="message-circle" class="w-4 h-4 mr-1"></i>
                              Chat
                            </button>
                          @else
                            <button class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                              Contact
                            </button>
                          @endif
                        @else
                          <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                            Login to Chat
                          </a>
                        @endauth
                        <a href="/talent/{{ $talent['id'] }}">
                          <button class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors text-white h-10 px-4 py-2" style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;"
                            onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'" onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                            Bekijk Profiel
                          </button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      @if ($filteredTalents->count() === 0)
        <div class="text-center py-12">
          <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="search" class="w-12 h-12 text-gray-400"></i>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 mb-2">Geen talenten gevonden</h3>
          <p class="text-gray-600 mb-4">Probeer je zoekopdracht aan te passen of andere filters te gebruiken.</p>
          <button onclick="resetFilters()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
            Reset Filters
          </button>
        </div>
      @endif
    </div>
  </div>

  <script>
    function setViewMode(mode) {
      document.getElementById('view-mode').value = mode;
      document.getElementById('filter-form').submit();
    }

    function resetFilters() {
      window.location.href = '{{ route('talents') }}';
    }

    function toggleFavorite(creatorProfileId, button) {
      // Add loading state
      const originalIcon = button.innerHTML;
      button.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>';
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
            // Update button appearance with proper heart icon
            if (data.is_favorited) {
              button.classList.remove('text-gray-700', 'text-gray-500');
              button.classList.add('text-red-500');
              button.innerHTML = '<i data-lucide="heart" class="w-4 h-4 fill-current"></i>';
              button.setAttribute('data-favorited', 'true');
              button.onmouseover = null;
              button.onmouseout = null;
            } else {
              button.classList.remove('text-red-500');
              button.classList.add('text-gray-700');
              button.innerHTML = '<i data-lucide="heart" class="w-4 h-4"></i>';
              button.setAttribute('data-favorited', 'false');
              button.onmouseover = function() {
                this.style.color = '#6A0AFC';
              };
              button.onmouseout = function() {
                this.style.color = 'rgb(107, 114, 128)';
              };
            }

            // Re-initialize Lucide icons for the updated content
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
            }

            // Show success confirmation
            showToast(data.message, 'success');
          } else {
            button.innerHTML = originalIcon;
            if (typeof lucide !== 'undefined') {
              lucide.createIcons();
            }
            showToast(data.message || 'Error updating favorite', 'error');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          button.innerHTML = originalIcon;
          if (typeof lucide !== 'undefined') {
            lucide.createIcons();
          }
          showToast('Error updating favorite', 'error');
        })
        .finally(() => {
          button.disabled = false;
        });
    }

    // Toast notification function
    function showToast(message, type = 'success') {
      // Remove existing toast if any
      const existingToast = document.getElementById('toast-notification');
      if (existingToast) {
        existingToast.remove();
      }

      // Create toast element
      const toast = document.createElement('div');
      toast.id = 'toast-notification';
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

    // Function to open chat with creator
    function openChatWithCreator(creatorId, creatorName) {
      if (window.openConversation) {
        window.openConversation(creatorId, creatorName);
      } else {
        console.error('Chat system not available');
        showToast('Chat system is loading. Please try again in a moment.', 'error');
      }
    }
  </script>

  @auth
    <!-- Chat Interface for authenticated users -->
    <x-chat-interface />
  @endauth

  </script>
@endsection
