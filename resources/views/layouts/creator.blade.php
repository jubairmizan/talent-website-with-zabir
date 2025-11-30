<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="api-token" content="{{ auth()->user()->createToken('api-token')->plainTextToken }}">
  <meta name="creator-id" content="{{ auth()->user()->id }}">

  <title>@yield('title', 'Creator Dashboard - ' . config('app.name', 'Curaçao Talents'))</title>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Lucide Icons for modern SVG icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

  <style>
    /* Custom animations */
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

    .animate-fadeIn {
      animation: fadeIn 0.6s ease-out forwards;
    }

    .animate-slideIn {
      animation: slideIn 0.6s ease-out forwards;
    }

    /* Custom gradient backgrounds */
    .gradient-bg {
      background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
    }

    .gradient-text {
      background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Smooth transitions */
    * {
      transition: all 0.3s ease;
    }

    /* Upload dropzone styles */
    .dropzone {
      border: 2px dashed #d1d5db;
      border-radius: 0.5rem;
      padding: 2rem;
      text-align: center;
      transition: all 0.3s ease;
    }

    .dropzone.dragover {
      border-color: #ec4899;
      background-color: #fdf2f8;
    }

    /* File input styling */
    .file-input::-webkit-file-upload-button {
      background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      font-weight: 500;
      cursor: pointer;
      margin-right: 1rem;
    }

    .file-input::-webkit-file-upload-button:hover {
      background: linear-gradient(135deg, #db2777 0%, #ea580c 100%);
    }
  </style>

  @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
  <!-- Navigation Header -->
  <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="flex items-center">
            <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
              <span class="text-white font-bold text-sm">CT</span>
            </div>
            <span class="text-xl font-bold gradient-text">Curaçao Talents</span>
          </a>
        </div>

        <!-- Creator Navigation -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="{{ route('creator.dashboard') }}" class="text-gray-700 hover:text-pink-600 transition-colors {{ request()->routeIs('creator.dashboard') ? 'text-pink-600 font-semibold' : '' }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4 inline mr-1"></i>
            Dashboard
          </a>
          <a href="{{ route('creator.portfolio.index') }}" class="text-gray-700 hover:text-pink-600 transition-colors {{ request()->routeIs('creator.portfolio.*') ? 'text-pink-600 font-semibold' : '' }}">
            <i data-lucide="folder" class="w-4 h-4 inline mr-1"></i>
            Portfolio
          </a>
          <a href="{{ route('talent.show', auth()->id()) }}" class="text-gray-700 hover:text-pink-600 transition-colors" target="_blank">
            <i data-lucide="eye" class="w-4 h-4 inline mr-1"></i>
            Bekijk Profiel
          </a>
        </div>

        <!-- User Menu -->
        <div class="flex items-center space-x-4">
          @auth
            <div class="flex items-center space-x-3">
              <div class="text-sm">
                <div class="text-gray-900 font-medium">{{ auth()->user()->name }}</div>
                <div class="text-gray-500 text-xs">Creator</div>
              </div>
              <div class="relative">
                <button onclick="toggleUserMenu()" class="flex items-center justify-center w-8 h-8 bg-gradient-to-r from-pink-500 to-orange-500 rounded-full text-white font-semibold">
                  {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>
                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                  <a href="{{ route('creator.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i data-lucide="user" class="w-4 h-4 inline mr-2"></i>
                    Profiel
                  </a>
                  <a href="{{ route('creator.portfolio.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i data-lucide="folder" class="w-4 h-4 inline mr-2"></i>
                    Portfolio
                  </a>
                  <div class="border-t border-gray-100 my-1"></div>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                      <i data-lucide="log-out" class="w-4 h-4 inline mr-2"></i>
                      Uitloggen
                    </button>
                  </form>
                </div>
              </div>
            </div>
          @endauth

          <!-- Mobile menu button -->
          <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500">
            <i data-lucide="menu" class="w-6 h-6"></i>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-200 mt-4">
        <div class="space-y-2">
          <a href="{{ route('creator.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors {{ request()->routeIs('creator.dashboard') ? 'text-pink-600 font-semibold' : '' }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4 inline mr-2"></i>
            Dashboard
          </a>
          <a href="{{ route('creator.portfolio.index') }}" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors {{ request()->routeIs('creator.portfolio.*') ? 'text-pink-600 font-semibold' : '' }}">
            <i data-lucide="folder" class="w-4 h-4 inline mr-2"></i>
            Portfolio
          </a>
          <a href="{{ route('talent.show', auth()->id()) }}" class="block px-3 py-2 text-gray-700 hover:text-pink-600 transition-colors" target="_blank">
            <i data-lucide="eye" class="w-4 h-4 inline mr-2"></i>
            Bekijk Profiel
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="min-h-screen">
    @if (session('success'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-4">
          <div class="flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
            {{ session('success') }}
          </div>
        </div>
      </div>
    @endif

    @if (session('error'))
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-4">
          <div class="flex items-center">
            <i data-lucide="x-circle" class="w-5 h-5 mr-2"></i>
            {{ session('error') }}
          </div>
        </div>
      </div>
    @endif

    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="text-center">
        <div class="flex items-center justify-center mb-4">
          <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
            <span class="text-white font-bold text-sm">CT</span>
          </div>
          <span class="text-xl font-bold gradient-text">Curaçao Talents</span>
        </div>
        <p class="text-gray-600 text-sm">
          © {{ date('Y') }} Curaçao Talents. Alle rechten voorbehouden.
        </p>
      </div>
    </div>
  </footer>

  <!-- JavaScript -->
  <script>
    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
    });

    // Toggle user menu
    function toggleUserMenu() {
      const menu = document.getElementById('user-menu');
      menu.classList.toggle('hidden');
    }

    // Toggle mobile menu
    function toggleMobileMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }

    // Close menus when clicking outside
    document.addEventListener('click', function(event) {
      const userMenu = document.getElementById('user-menu');
      const mobileMenu = document.getElementById('mobile-menu');

      if (!event.target.closest('.relative') && userMenu) {
        userMenu.classList.add('hidden');
      }

      if (!event.target.closest('button[onclick="toggleMobileMenu()"]') && !event.target.closest('#mobile-menu')) {
        mobileMenu.classList.add('hidden');
      }
    });

    // Toast notification system
    function showToast(message, type = 'success') {
      const toast = document.createElement('div');
      toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
      }`;
      toast.innerHTML = `
        <div class="flex items-center gap-2">
          <i data-lucide="${type === 'success' ? 'check-circle' : 'x-circle'}" class="w-5 h-5"></i>
          <span>${message}</span>
        </div>
      `;

      document.body.appendChild(toast);
      lucide.createIcons();

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

    // File upload progress
    function handleFileUpload(input, callback) {
      const file = input.files[0];
      if (!file) return;

      const maxSize = 20 * 1024 * 1024; // 20MB
      if (file.size > maxSize) {
        showToast('Bestand is te groot. Maximum grootte is 20MB.', 'error');
        input.value = '';
        return;
      }

      const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/mov', 'video/avi'];
      if (!allowedTypes.includes(file.type)) {
        showToast('Bestandstype niet ondersteund.', 'error');
        input.value = '';
        return;
      }

      if (callback) callback(file);
    }

    // Drag and drop file upload
    function setupDropzone(element) {
      if (!element) return;

      element.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
      });

      element.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
      });

      element.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
          const fileInput = this.querySelector('input[type="file"]');
          if (fileInput) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
          }
        }
      });
    }
  </script>

  @stack('scripts')
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
