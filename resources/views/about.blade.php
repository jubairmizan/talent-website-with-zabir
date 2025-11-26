@extends('layouts.landing')

@section('title', 'Over Ons - Curaçao Talents')

@section('content')
  <div class="min-h-screen bg-gray-50">
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
            <a href="/about" style="color: #6A0AFC;" class="font-medium">
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

    <!-- Hero Section -->
    <section class="relative py-20" style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.8) 0%, rgba(150, 30, 255, 0.85) 50%, rgba(181, 53, 255, 0.8) 100%);">
      <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
            {{ $settings->hero_title }}
          </h1>
          <p class="text-xl text-white/90 mb-8">
            {{ $settings->hero_subtitle }}
          </p>
          <a href="/register">
            <button
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white hover:bg-gray-100 h-11 px-8 text-base"
              style="color: #6A0AFC;">
              {{ $settings->hero_button_text }}
            </button>
          </a>
        </div>
      </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
              {{ $settings->mission_title }}
            </h2>
            <p class="text-lg text-gray-600 mb-6">
              {{ $settings->mission_description_1 }}
            </p>
            <p class="text-lg text-gray-600 mb-8">
              {{ $settings->mission_description_2 }}
            </p>
            <div class="grid grid-cols-2 gap-6">
              <div class="text-center">
                <div class="text-3xl font-bold text-pink-600 mb-2">{{ $settings->stat_talents_count }}</div>
                <div class="text-gray-600">{{ $settings->stat_talents_label }}</div>
              </div>
              <div class="text-center">
                <div class="text-3xl font-bold text-orange-500 mb-2">{{ $settings->stat_projects_count }}</div>
                <div class="text-gray-600">{{ $settings->stat_projects_label }}</div>
              </div>
            </div>
          </div>
          <div class="relative">
            <img src="{{ $settings->mission_image_url }}" alt="{{ $settings->mission_title }}" class="rounded-2xl shadow-xl" />
          </div>
        </div>
      </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
      <div class="container mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            {{ $settings->values_section_title }}
          </h2>
          <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            {{ $settings->values_section_subtitle }}
          </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
          @foreach ($values as $value)
            <div class="text-center p-6 bg-white/80 backdrop-blur-sm hover:shadow-lg transition-shadow rounded-lg">
              <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background: linear-gradient(135deg, #6A0AFC, #B535FF);">
                <i data-lucide="{{ $value->icon }}" class="w-8 h-8 text-white"></i>
              </div>
              <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $value->title }}</h3>
              <p class="text-gray-600">{{ $value->description }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Team Section -->
    {{-- <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Ons Team
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Ontmoet de mensen achter Curaçao Talents
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($teamMembers as $member)
                        <div class="text-center p-6 hover:shadow-lg transition-shadow rounded-lg bg-white">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }}"
                                class="w-32 h-32 rounded-full mx-auto mb-4 object-cover" />
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $member['name'] }}</h3>
                            <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium mb-4 text-white"
                                style="background: linear-gradient(135deg, #6A0AFC, #B535FF);">
                                {{ $member['role'] }}
                            </div>
                            <p class="text-gray-600">{{ $member['bio'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section> --}}

    <!-- Contact Info Section -->
    <section class="py-16" style="background: linear-gradient(135deg, #6A0AFC, #B535FF);">
      <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto text-center">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-8">
            Neem Contact Met Ons Op
          </h2>
          <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div class="text-center">
              <i data-lucide="map-pin" class="w-8 h-8 text-white mx-auto mb-3"></i>
              <h3 class="text-xl font-semibold text-white mb-2">Locatie</h3>
              <p class="text-white/90">Willemstad, Curaçao</p>
            </div>
            <div class="text-center">
              <i data-lucide="mail" class="w-8 h-8 text-white mx-auto mb-3"></i>
              <h3 class="text-xl font-semibold text-white mb-2">Email</h3>
              <p class="text-white/90">info@brugkreativo.com</p>
            </div>
            <div class="text-center">
              <i data-lucide="phone" class="w-8 h-8 text-white mx-auto mb-3"></i>
              <h3 class="text-xl font-semibold text-white mb-2">Telefoon</h3>
              <p class="text-white/90">+59995109456</p>
            </div>
          </div>
          <a href="/contact">
            <button
              class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-pink-600 hover:bg-gray-100 h-11 px-8 text-base">
              Stuur Ons Een Bericht
            </button>
          </a>
        </div>
      </div>
    </section>
  </div>
@endsection
