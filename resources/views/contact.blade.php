@extends('layouts.landing')

@section('title', 'Contact - Curaçao Talents')

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
            <a href="/contact" style="color: #6A0AFC;" class="font-medium">
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

    <!-- Success Message -->
    @if (session('success'))
      <div class="container mx-auto px-6 py-20">
        <div class="max-w-md mx-auto text-center shadow-xl bg-white rounded-lg">
          <div class="p-8">
            <i data-lucide="check-circle" class="w-16 h-16 text-green-500 mx-auto mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $settings->success_title }}</h2>
            <p class="text-gray-600 mb-4">
              {{ $settings->success_message }}
            </p>
            <a href="/contact">
              <button
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-11 px-8 text-base"
                style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;" onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
                onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                {{ $settings->success_button_text }}
              </button>
            </a>
          </div>
        </div>
      </div>
    @else
      <!-- Hero Section -->
      <section class="relative py-20" style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.85) 0%, rgba(150, 30, 255, 0.85) 50%, rgba(181, 53, 255, 0.85) 100%);">
        <div class="container mx-auto px-6">
          <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
              {{ $settings->hero_title }}
            </h1>
            <p class="text-xl text-white mb-8">
              {{ $settings->hero_subtitle }}
            </p>
          </div>
        </div>
      </section>

      <!-- Contact Section -->
      <section class="py-16">
        <div class="container mx-auto px-6">
          <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
              <div class="shadow-xl bg-white rounded-lg">
                <div class="p-6 border-b border-border">
                  <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-2">
                    <i data-lucide="message-circle" class="w-6 h-6" style="color: #6A0AFC"></i>
                    {{ $settings->form_section_title }}
                  </h2>
                  <p class="text-gray-600">
                    {{ $settings->form_section_subtitle }}
                  </p>
                </div>
                <div class="p-6">
                  <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                      <div class="space-y-2">
                        <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Naam
                          *</label>
                        <input id="name" name="name" type="text" placeholder="Je volledige naam" required
                          class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                      </div>
                      <div class="space-y-2">
                        <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Email
                          *</label>
                        <input id="email" name="email" type="email" placeholder="je@email.com" required
                          class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                      </div>
                    </div>

                    <div class="space-y-2">
                      <label for="category" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Categorie</label>
                      <select id="category" name="category"
                        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="">Selecteer een categorie</option>
                        <option value="general">Algemene Vraag</option>
                        <option value="support">Technische Ondersteuning</option>
                        <option value="business">Zakelijke Samenwerking</option>
                        <option value="creator">Creator Support</option>
                        <option value="feedback">Feedback</option>
                        <option value="other">Anders</option>
                      </select>
                    </div>

                    <div class="space-y-2">
                      <label for="subject" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Onderwerp
                        *</label>
                      <input id="subject" name="subject" type="text" placeholder="Waar gaat je bericht over?" required
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" />
                    </div>

                    <div class="space-y-2">
                      <label for="message" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Bericht
                        *</label>
                      <textarea id="message" name="message" placeholder="Vertel ons meer over je vraag of opmerking..." rows="6" required
                        class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"></textarea>
                    </div>

                    <button type="submit"
                      class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 text-white h-10 px-4 py-2 w-full"
                      style="background: linear-gradient(to right, #6A0AFC, #B535FF); transition: all 0.3s ease;" onmouseover="this.style.background='linear-gradient(to right, #5A00E6, #A025F0)'"
                      onmouseout="this.style.background='linear-gradient(to right, #6A0AFC, #B535FF)'">
                      <i data-lucide="send" class="w-4 h-4 mr-2"></i>
                      {{ $settings->form_button_text }}
                    </button>
                  </form>
                </div>
              </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
              <div class="p-6 bg-white rounded-lg border border-border">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $settings->contact_info_title }}</h3>
                <div class="space-y-4">
                  @if ($settings->contact_address)
                    <div class="flex items-start gap-3">
                      <i data-lucide="map-pin" class="w-5 h-5 mt-1" style="color: #6A0AFC"></i>
                      <div>
                        <h4 class="font-semibold text-gray-900">Adres</h4>
                        <p class="text-gray-600">{{ $settings->contact_address }}</p>
                      </div>
                    </div>
                  @endif
                  @if ($settings->contact_email)
                    <div class="flex items-start gap-3">
                      <i data-lucide="mail" class="w-5 h-5 mt-1" style="color: #6A0AFC"></i>
                      <div>
                        <h4 class="font-semibold text-gray-900">Email</h4>
                        <p class="text-gray-600">{{ $settings->contact_email }}</p>
                      </div>
                    </div>
                  @endif
                  @if ($settings->contact_phone)
                    <div class="flex items-start gap-3">
                      <i data-lucide="phone" class="w-5 h-5 mt-1" style="color: #6A0AFC"></i>
                      <div>
                        <h4 class="font-semibold text-gray-900">Telefoon</h4>
                        <p class="text-gray-600">{{ $settings->contact_phone }}</p>
                      </div>
                    </div>
                  @endif
                  @if ($settings->contact_hours)
                    <div class="flex items-start gap-3">
                      <i data-lucide="clock" class="w-5 h-5 mt-1" style="color: #6A0AFC"></i>
                      <div>
                        <h4 class="font-semibold text-gray-900">Openingstijden</h4>
                        <p class="text-gray-600" style="white-space: pre-line;">{{ $settings->contact_hours }}</p>
                      </div>
                    </div>
                  @endif
                </div>
              </div>

              <div class="p-6 rounded-lg border border-border" style="background: linear-gradient(135deg, rgba(106, 15, 252, 0.05), rgba(181, 53, 255, 0.03));">
                <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $settings->faq_section_title }}</h3>
                <div class="space-y-3">
                  @foreach ($faqs as $faq)
                    <details class="group">
                      <summary class="font-semibold text-gray-900 cursor-pointer hover:text-pink-600" style="color: inherit;">
                        {{ $faq->question }}
                      </summary>
                      <p class="text-gray-600 mt-2 pl-4">
                        {{ $faq->answer }}
                      </p>
                    </details>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif
  </div>
@endsection
