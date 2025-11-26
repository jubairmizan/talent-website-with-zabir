<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', config('app.name', 'Curaçao Talents'))</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Lucide Icons for modern SVG icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    /* Custom animations for the landing page */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .animate-fade-in {
      animation: fadeIn 0.8s ease-out;
    }

    .animate-slide-in {
      animation: slideIn 0.6s ease-out;
    }

    /* Typing animation */
    .typing-placeholder::placeholder {
      opacity: 1;
      transition: opacity 0.3s ease;
    }
  </style>
</head>

<body class="font-sans antialiased">
  @yield('content')

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Typing animation for search placeholder
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search-input');
      if (searchInput) {
        const placeholders = [
          'Zoek hier naar creators...',
          'Vind een fotograaf...',
          'Zoek een kunstenaar...',
          'Vind een muzikant...',
          'Zoek een designer...',
          'Vind een danser...'
        ];

        let currentIndex = 0;

        function typeText(text, callback) {
          let charIndex = 0;
          searchInput.placeholder = '';

          const typeInterval = setInterval(() => {
            if (charIndex <= text.length) {
              searchInput.placeholder = text.slice(0, charIndex);
              charIndex++;
            } else {
              clearInterval(typeInterval);
              if (callback) callback();
            }
          }, 100);
        }

        function cyclePlaceholders() {
          typeText(placeholders[currentIndex], () => {
            setTimeout(() => {
              currentIndex = (currentIndex + 1) % placeholders.length;
              cyclePlaceholders();
            }, 2000);
          });
        }

        cyclePlaceholders();
      }
    });

    // Video functionality
    function toggleVideo() {
      const video = document.getElementById('hero-video');
      const playBtn = document.getElementById('play-btn');
      const pauseBtn = document.getElementById('pause-btn');

      if (video.paused) {
        video.play();
        playBtn.style.display = 'none';
        pauseBtn.style.display = 'block';
      } else {
        video.pause();
        playBtn.style.display = 'block';
        pauseBtn.style.display = 'none';
      }
    }

    function expandVideo() {
      const modal = document.getElementById('video-modal');
      const video = document.getElementById('hero-video');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      video.play();
    }

    function closeVideo() {
      const modal = document.getElementById('video-modal');
      const video = document.getElementById('hero-video');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      video.pause();
    }

    // Search functionality
    function handleSearch() {
      const searchQuery = document.getElementById('search-input').value;
      if (searchQuery.trim()) {
        window.location.href = `/talents?search=${encodeURIComponent(searchQuery)}`;
      } else {
        window.location.href = '/talents';
      }
    }

    // Handle Enter key in search
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search-input');
      if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            handleSearch();
          }
        });
      }
    });
  </script>

  <!-- Laravel User Data for JavaScript -->
  @auth
    <script>
      window.Laravel = {
        user: {
          id: {{ auth()->id() }},
          name: "{{ auth()->user()->name }}",
          role: "{{ auth()->user()->role }}"
        }
      };
    </script>
  @endauth
</body>

</html>
