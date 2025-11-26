@extends('layouts.landing')

@section('title', 'Home - Curaçao Talents')

@section('content')
  <div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b sticky top-0 z-50">
      <div class="container mx-auto px-6 py-2">
        <div class="flex items-center justify-between">
          <!-- Logo -->
          <a href="/" class="flex items-center">
            <img src="{{ asset('images/brug-logo.png') }}" alt="Brug Kreativo" class="w-auto object-contain" style="height: 65px;">
          </a>

          <!-- Navigation -->
          <nav class="hidden md:flex items-center gap-8">
            <a href="/" class="text-gray-700 hover:text-purple-600 transition-colors">
              Home
            </a>
            <a href="/talents" class="text-gray-700 hover:text-purple-600 transition-colors">
              Discover Talents
            </a>
            {{-- <a href="/blog" class="text-gray-700 hover:text-purple-600 transition-colors">
                            Blog
                        </a> --}}
            <a href="/about" class="text-gray-700 hover:text-purple-600 transition-colors">
              About
            </a>
            <a href="/contact" class="text-gray-700 hover:text-purple-600 transition-colors">
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

    <!-- Hero Section with Dynamic Background -->
    <section class="relative min-h-screen overflow-hidden flex items-center">
      <!-- Dynamic Background Slideshow -->
      <div class="absolute inset-0 overflow-hidden">
        <!-- Background Images -->
        @foreach ($slides as $index => $slide)
          <div class="bg-slideshow absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ $slide->image_url }}'); opacity: {{ $index === 0 ? '1' : '0' }}; transition: opacity 1s ease-in-out; z-index: {{ 1 + $index }};">
          </div>
        @endforeach

        <!-- Overlay for better text readability -->
        <div class="absolute inset-0 bg-black/20" style="z-index: 10;"></div>

        <!-- Gradient overlay to match Brug Kreativo colors -->
        <div class="absolute inset-0 bg-gradient-to-br" style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.3) 0%, rgba(181, 53, 255, 0.2) 50%, rgba(181, 53, 255, 0.3) 100%); z-index: 11;">
        </div>

        <!-- Geometric shapes overlay with Brug Kreativo colors -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" style="z-index: 12;">
          <!-- Large geometric shapes -->
          <div class="absolute top-20 left-20 w-32 h-40 rounded-2xl transform rotate-12" style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.6), rgba(150, 30, 255, 0.6));">
          </div>
          <div class="absolute top-40 right-32 w-24 h-24 rounded-full" style="background: linear-gradient(135deg, rgba(181, 53, 255, 0.6), rgba(106, 15, 252, 0.6));">
          </div>
          <div class="absolute bottom-32 left-40 w-20 h-28 rounded-xl transform -rotate-12" style="background: linear-gradient(135deg, rgba(150, 30, 255, 0.6), rgba(181, 53, 255, 0.6));">
          </div>
          <div class="absolute top-60 left-1/3 w-28 h-28 rounded-2xl transform rotate-45" style="background: linear-gradient(135deg, rgba(181, 53, 255, 0.6), rgba(200, 80, 255, 0.6));">
          </div>

          <!-- Additional shapes for depth -->
          <div class="absolute bottom-20 right-20 w-36 h-24 rounded-2xl transform -rotate-6" style="background: linear-gradient(135deg, rgba(150, 30, 255, 0.6), rgba(181, 53, 255, 0.6));">
          </div>
          <div class="absolute top-1/3 right-1/4 w-16 h-16 rounded-full" style="background: linear-gradient(135deg, rgba(181, 53, 255, 0.6), rgba(106, 15, 252, 0.6));">
          </div>

          <!-- Curved lines with Brug Kreativo colors -->
          <svg class="absolute inset-0 w-full h-full opacity-30" viewBox="0 0 1200 800">
            <path d="M0,400 Q300,200 600,400 T1200,400" stroke="rgba(106, 15, 252, 0.4)" stroke-width="3" fill="none" />
            <path d="M0,300 Q400,100 800,300 T1200,300" stroke="rgba(181, 53, 255, 0.4)" stroke-width="3" fill="none" />
          </svg>
        </div>

        <!-- Image indicators -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-2">
          @foreach ($slides as $index => $slide)
            <button class="{{ $index === 0 ? 'h-2 rounded-full transition-all duration-300 bg-white w-8' : 'w-2 h-2 rounded-full transition-all duration-300 bg-white/50 hover:bg-white/75' }}" onclick="setBackgroundImage({{ $index }})"></button>
          @endforeach
        </div>
      </div>

      <div class="relative z-20 container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 leading-tight drop-shadow-lg animate-fade-in" style="z-index: 25; position: relative;">
            {{ $settings->hero_title }}
          </h1>
          <p class="text-2xl text-white/90 mb-12 font-medium drop-shadow-md animate-slide-in" style="z-index: 25; position: relative;">
            {{ $settings->hero_subtitle }}
          </p>

          <!-- Dynamic Search Box -->
          <div class="mb-16 animate-fade-in" style="z-index: 30; position: relative;">
            <div class="relative max-w-2xl mx-auto">
              <div class="bg-black/80 backdrop-blur-sm rounded-full p-2 shadow-2xl border border-white/20">
                <div class="flex items-center gap-4 px-4">
                  <i data-lucide="search" class="w-6 h-6 text-white flex-shrink-0"></i>
                  <input type="text" id="search-input" placeholder="{{ $settings->search_placeholder_text }}" class="flex-1 bg-transparent text-white placeholder-gray-300 outline-none border-none text-lg py-3 min-w-0 typing-placeholder"
                    autocomplete="off" style="outline: none; box-shadow: none;" />
                  <a href="{{ route('register') }}?role=talent" class="text-gray-400 text-sm hidden md:block hover:text-white transition-colors cursor-pointer">
                    meld je aan als creator
                  </a>
                </div>
              </div>

              <!-- Search Suggestions Dropdown -->
              <div id="search-suggestions" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-50 hidden" style="z-index: 35;">
                <div id="suggestions-list" class="max-h-96 overflow-y-auto text-left">
                  <!-- Suggestions will be populated by JavaScript -->
                </div>
                <div id="suggestions-loading" class="p-4 text-center text-gray-500 hidden">
                  <div class="inline-block animate-spin rounded-full h-4 w-4 mr-2" style="border: 2px solid #f3f4f6; border-top: 2px solid #6A0AFC;"></div>
                  Zoeken...
                </div>
                <div id="suggestions-empty" class="p-4 text-center text-gray-500 hidden">
                  Geen creators gevonden
                </div>
              </div>
            </div>
          </div>

          <!-- Expanding Video -->
          <div class="mb-16 animate-fade-in" style="z-index: 25; position: relative;">
            <!-- Compact Video Preview -->
            <div class="relative group cursor-pointer">
              <div class="relative w-full max-w-md mx-auto bg-black rounded-2xl overflow-hidden shadow-2xl">
                <video id="hero-video" class="w-full h-64 object-cover" muted loop playsinline preload="metadata">
                  @if ($settings->hero_video_url)
                    <source src="{{ $settings->hero_video_url }}" type="video/mp4" />
                  @endif
                  Your browser does not support the video tag.
                </video>

                <!-- Main Control Overlay -->
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/20 transition-colors" onclick="handleVideoClick()">
                  <div class="text-center text-white">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                      <i data-lucide="play" id="main-play-btn" class="w-8 h-8 ml-1"></i>
                      <i data-lucide="pause" id="main-pause-btn" class="w-8 h-8" style="display: none;"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Ontdek Curaçao Talents</h3>
                    <p class="text-sm opacity-90" id="video-instruction">Klik om video af te spelen</p>
                  </div>
                </div>

                <!-- Sound Control Button -->
                <button onclick="event.stopPropagation(); toggleMute();" class="absolute bottom-4 right-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors">
                  <i data-lucide="volume-x" id="hero-mute-btn" class="w-4 h-4"></i>
                  <i data-lucide="volume-2" id="hero-unmute-btn" class="w-4 h-4" style="display: none;"></i>
                </button>

                <!-- Expand Button -->
                <button onclick="event.stopPropagation(); expandVideo();" class="absolute bottom-4 left-4 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors">
                  <i data-lucide="maximize-2" class="w-4 h-4"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Expanded Video Modal -->
    <div id="video-modal" class="fixed inset-0 z-50 bg-black/90 items-center justify-center p-4 hidden">
      <div class="relative w-full max-w-6xl mx-auto">
        <!-- Close Button -->
        <button onclick="closeVideo()" class="absolute -top-12 right-0 text-white hover:bg-white/10 rounded-full p-2 z-10 transition-colors">
          <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <!-- Video Container -->
        <div class="relative bg-black rounded-lg overflow-hidden shadow-2xl">
          <video id="modal-video" class="w-full h-auto max-h-[80vh] object-contain" controls preload="metadata">
            @if ($settings->hero_video_url)
              <source src="{{ $settings->hero_video_url }}" type="video/mp4" />
            @endif
            Your browser does not support the video tag.
          </video>

          <!-- Video Title Overlay (only when paused) -->
          <div id="modal-title-overlay" class="absolute top-4 left-4 text-white bg-black/50 rounded-lg p-4 backdrop-blur-sm">
            <h3 class="text-xl font-semibold mb-1">Welkom bij Curaçao Talents</h3>
            <p class="text-sm opacity-90">Ontdek de creatieve kracht van ons eiland</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Additional JavaScript for background slideshow control
    let currentImageIndex = 0;

    function setBackgroundImage(index) {
      const backgroundElements = document.querySelectorAll('.bg-slideshow');
      const indicators = document.querySelectorAll('.bottom-8 button');

      // Hide all backgrounds
      backgroundElements.forEach((bg, i) => {
        bg.style.opacity = i === index ? '1' : '0';
      });

      // Update indicators
      indicators.forEach((indicator, i) => {
        if (i === index) {
          indicator.className = 'h-2 rounded-full transition-all duration-300 bg-white w-8';
        } else {
          indicator.className =
            'w-2 h-2 rounded-full transition-all duration-300 bg-white/50 hover:bg-white/75';
        }
      });

      currentImageIndex = index;
    }

    // Auto slideshow functionality  
    function autoChangeBackground() {
      const backgroundElements = document.querySelectorAll('.bg-slideshow');
      if (backgroundElements.length > 1) {
        const nextIndex = (currentImageIndex + 1) % backgroundElements.length;
        setBackgroundImage(nextIndex);
      }
    }

    // Start auto slideshow
    document.addEventListener('DOMContentLoaded', function() {
      const backgroundElements = document.querySelectorAll('.bg-slideshow');

      if (backgroundElements.length > 1) {
        setInterval(autoChangeBackground, 5000);
      }
    });

    function toggleMute() {
      const video = document.getElementById('hero-video');
      const muteBtn = document.getElementById('mute-btn');
      const unmuteBtn = document.getElementById('unmute-btn');

      video.muted = !video.muted;

      if (video.muted) {
        muteBtn.style.display = 'block';
        unmuteBtn.style.display = 'none';
      } else {
        muteBtn.style.display = 'none';
        unmuteBtn.style.display = 'block';
      }
    }

    // Search autocomplete functionality
    let searchTimeout;
    let currentSelectedIndex = -1;

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search-input');
      const suggestionsContainer = document.getElementById('search-suggestions');
      const suggestionsList = document.getElementById('suggestions-list');
      const loadingIndicator = document.getElementById('suggestions-loading');
      const emptyMessage = document.getElementById('suggestions-empty');

      searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        currentSelectedIndex = -1;

        if (query.length < 2) {
          hideSuggestions();
          return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          fetchSuggestions(query);
        }, 300);
      });

      searchInput.addEventListener('keydown', function(e) {
        const suggestions = suggestionsList.querySelectorAll('.suggestion-item');

        switch (e.key) {
          case 'ArrowDown':
            e.preventDefault();
            currentSelectedIndex = Math.min(currentSelectedIndex + 1, suggestions.length - 1);
            updateSelection(suggestions);
            break;
          case 'ArrowUp':
            e.preventDefault();
            currentSelectedIndex = Math.max(currentSelectedIndex - 1, -1);
            updateSelection(suggestions);
            break;
          case 'Enter':
            e.preventDefault();
            if (currentSelectedIndex >= 0 && suggestions[currentSelectedIndex]) {
              suggestions[currentSelectedIndex].click();
            }
            break;
          case 'Escape':
            hideSuggestions();
            searchInput.blur();
            break;
        }
      });

      // Hide suggestions when clicking outside
      document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
          hideSuggestions();
        }
      });

      async function fetchSuggestions(query) {
        showLoading();

        try {
          const response = await fetch(`/api/creators/search?q=${encodeURIComponent(query)}`);
          const suggestions = await response.json();

          hideLoading();

          if (suggestions.length === 0) {
            showEmpty();
          } else {
            displaySuggestions(suggestions);
          }
        } catch (error) {
          console.error('Error fetching suggestions:', error);
          hideLoading();
          showEmpty();
        }
      }

      function displaySuggestions(suggestions) {
        suggestionsList.innerHTML = suggestions.map((suggestion, index) => `
          <div class="suggestion-item p-4 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0 transition-colors flex items-center gap-3" data-url="${suggestion.url}">
            <img src="${suggestion.image}" alt="${suggestion.name}" class="w-12 h-12 rounded-full object-cover flex-shrink-0" onerror="this.src='/images/default-avatar.svg'">
            <div class="flex-1 min-w-0">
              <div class="font-medium text-gray-900 truncate">${suggestion.name}</div>
              <div class="text-sm text-gray-500 truncate">${suggestion.profession}</div>
              <div class="text-xs truncate" style="color: #6A0AFC;">${suggestion.category}</div>
            </div>
            <i data-lucide="arrow-right" class="w-4 h-4 text-gray-400 flex-shrink-0"></i>
          </div>
        `).join('');

        // Reinitialize Lucide icons for the new content
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }

        // Add click handlers
        suggestionsList.querySelectorAll('.suggestion-item').forEach(item => {
          item.addEventListener('click', function() {
            window.location.href = this.dataset.url;
          });
        });

        showSuggestions();
      }

      function updateSelection(suggestions) {
        suggestions.forEach((item, index) => {
          if (index === currentSelectedIndex) {
            item.classList.add('bg-gray-50');
          } else {
            item.classList.remove('bg-gray-50');
          }
        });
      }

      function showSuggestions() {
        suggestionsContainer.classList.remove('hidden');
        emptyMessage.classList.add('hidden');
        loadingIndicator.classList.add('hidden');
      }

      function hideSuggestions() {
        suggestionsContainer.classList.add('hidden');
        currentSelectedIndex = -1;
      }

      function showLoading() {
        suggestionsContainer.classList.remove('hidden');
        loadingIndicator.classList.remove('hidden');
        emptyMessage.classList.add('hidden');
        suggestionsList.innerHTML = '';
      }

      function hideLoading() {
        loadingIndicator.classList.add('hidden');
      }

      function showEmpty() {
        emptyMessage.classList.remove('hidden');
        suggestionsList.innerHTML = '';
        showSuggestions();
      }
    });

    // Video functionality
    let heroVideo, modalVideo;
    let isVideoPlaying = false;

    document.addEventListener('DOMContentLoaded', function() {
      heroVideo = document.getElementById('hero-video');
      modalVideo = document.querySelector('#video-modal video');

      // Ensure hero video loads and plays properly
      if (heroVideo) {
        heroVideo.addEventListener('loadeddata', function() {
          // Video is loaded and ready
          updateVideoState(false); // Start in paused state
        });

        // Handle video play/pause events
        heroVideo.addEventListener('play', function() {
          updateVideoState(true);
        });

        heroVideo.addEventListener('pause', function() {
          updateVideoState(false);
        });

        // Handle video error
        heroVideo.addEventListener('error', function(e) {
          console.error('Video error:', e);
        });
      }
    });

    // Handle main video click (play/pause)
    function handleVideoClick() {
      if (!heroVideo) return;

      if (heroVideo.paused) {
        heroVideo.play().then(() => {
          updateVideoState(true);
        }).catch(e => {
          console.log('Play prevented:', e);
        });
      } else {
        heroVideo.pause();
        updateVideoState(false);
      }
    }

    // Update video button states and instruction text
    function updateVideoState(playing) {
      const playBtn = document.getElementById('main-play-btn');
      const pauseBtn = document.getElementById('main-pause-btn');
      const instruction = document.getElementById('video-instruction');

      isVideoPlaying = playing;

      if (playing) {
        if (playBtn) playBtn.style.display = 'none';
        if (pauseBtn) pauseBtn.style.display = 'block';
        if (instruction) instruction.textContent = 'Klik om te pauzeren';
      } else {
        if (playBtn) playBtn.style.display = 'block';
        if (pauseBtn) pauseBtn.style.display = 'none';
        if (instruction) instruction.textContent = 'Klik om video af te spelen';
      }
    }

    // Expand video to modal
    function expandVideo() {
      const modal = document.getElementById('video-modal');
      const modalVideo = modal.querySelector('video');
      const titleOverlay = document.getElementById('modal-title-overlay');

      // Show modal
      modal.classList.remove('hidden');
      modal.classList.add('flex');

      // Copy video source and current time
      if (heroVideo && modalVideo) {
        modalVideo.currentTime = heroVideo.currentTime;
        // Pause hero video
        heroVideo.pause();
        updateVideoState(false);

        // Load and setup modal video
        modalVideo.load();
        modalVideo.muted = false; // Unmute in modal for better experience

        // Add event listeners for modal video
        modalVideo.addEventListener('play', function() {
          if (titleOverlay) titleOverlay.style.display = 'none';
        });

        modalVideo.addEventListener('pause', function() {
          if (titleOverlay) titleOverlay.style.display = 'block';
        });

        // Start playing after load
        modalVideo.addEventListener('loadeddata', function playOnce() {
          this.play().catch(e => {
            console.log('Modal video autoplay prevented:', e);
          });
          this.removeEventListener('loadeddata', playOnce);
        });
      }

      // Prevent body scroll
      document.body.style.overflow = 'hidden';
    }

    // Close video modal
    function closeVideo() {
      const modal = document.getElementById('video-modal');
      const modalVideo = modal.querySelector('video');

      // Hide modal
      modal.classList.add('hidden');
      modal.classList.remove('flex');

      // Pause modal video and reset
      if (modalVideo) {
        modalVideo.pause();
        modalVideo.currentTime = 0;
      }

      // Reset title overlay
      const titleOverlay = document.getElementById('modal-title-overlay');
      if (titleOverlay) titleOverlay.style.display = 'block';

      // Don't auto-resume hero video, let user control it

      // Restore body scroll
      document.body.style.overflow = '';
    }

    // Toggle video play/pause (simplified - only for hero video now)
    function toggleVideo() {
      // This function is now only used for hero video
      handleVideoClick();
    }

    // Enhanced mute toggle function (simplified)
    function toggleMute() {
      // Only for hero video now, modal uses native controls
      if (!heroVideo) return;

      const muteBtn = document.getElementById('hero-mute-btn');
      const unmuteBtn = document.getElementById('hero-unmute-btn');

      heroVideo.muted = !heroVideo.muted;

      if (heroVideo.muted) {
        if (muteBtn) muteBtn.style.display = 'block';
        if (unmuteBtn) unmuteBtn.style.display = 'none';
      } else {
        if (muteBtn) muteBtn.style.display = 'none';
        if (unmuteBtn) unmuteBtn.style.display = 'block';
      }
    }

    // Close modal when clicking outside video
    document.addEventListener('click', function(e) {
      const modal = document.getElementById('video-modal');
      const videoContainer = modal?.querySelector('.relative');

      if (modal && !modal.classList.contains('hidden') &&
        !videoContainer?.contains(e.target) &&
        e.target === modal) {
        closeVideo();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const modal = document.getElementById('video-modal');
        if (modal && !modal.classList.contains('hidden')) {
          closeVideo();
        }
      }
    });
  </script>
@endsection
