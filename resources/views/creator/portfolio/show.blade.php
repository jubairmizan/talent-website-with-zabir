@extends('layouts.creator')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
          <a href="{{ route('creator.portfolio.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Terug naar Portfolio
          </a>

          <div class="flex items-center gap-3">
            <!-- Status Badge -->
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $portfolioItem->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
              {{ $portfolioItem->is_active ? 'Actief' : 'Inactief' }}
            </span>

            <!-- Action Buttons -->
            <a href="{{ route('creator.portfolio.edit', $portfolioItem) }}"
              class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
              <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
              Bewerken
            </a>

            <form action="{{ route('creator.portfolio.destroy', $portfolioItem) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je dit portfolio item wilt verwijderen?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="inline-flex items-center px-3 py-2 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                Verwijderen
              </button>
            </form>
          </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900">{{ $portfolioItem->title }}</h1>
        @if ($portfolioItem->description)
          <p class="text-gray-600 mt-2">{{ $portfolioItem->description }}</p>
        @endif
      </div>

      <!-- Main Content -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Media Display -->
        <div class="relative bg-gray-900">
          @if ($portfolioItem->file_type === 'image')
            <img src="{{ asset('storage/' . $portfolioItem->file_path) }}" alt="{{ $portfolioItem->title }}" class="w-full h-auto max-h-96 object-contain mx-auto">
          @elseif($portfolioItem->file_type === 'video')
            <video controls class="w-full h-auto max-h-96 mx-auto">
              <source src="{{ asset('storage/' . $portfolioItem->file_path) }}" type="{{ $portfolioItem->mime_type }}">
              Je browser ondersteunt geen video tag.
            </video>
          @endif

          <!-- File Type Badge -->
          <div class="absolute top-4 left-4 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-medium">
            @if ($portfolioItem->file_type === 'image')
              <i data-lucide="image" class="w-4 h-4 inline mr-1"></i>
              Afbeelding
            @elseif($portfolioItem->file_type === 'video')
              <i data-lucide="play" class="w-4 h-4 inline mr-1"></i>
              Video
            @endif
          </div>
        </div>

        <!-- Details -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-4">
              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Titel</h3>
                <p class="mt-1 text-lg text-gray-900">{{ $portfolioItem->title }}</p>
              </div>

              @if ($portfolioItem->description)
                <div>
                  <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Beschrijving</h3>
                  <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $portfolioItem->description }}</p>
                </div>
              @endif

              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Status</h3>
                <p class="mt-1">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $portfolioItem->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $portfolioItem->is_active ? 'Actief' : 'Inactief' }}
                  </span>
                </p>
              </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-4">
              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Bestandstype</h3>
                <p class="mt-1 text-gray-900 capitalize">{{ $portfolioItem->file_type }}</p>
              </div>

              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">MIME Type</h3>
                <p class="mt-1 text-gray-900">{{ $portfolioItem->mime_type }}</p>
              </div>

              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Bestandsgrootte</h3>
                <p class="mt-1 text-gray-900">{{ number_format($portfolioItem->file_size / 1024 / 1024, 2) }} MB</p>
              </div>

              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Sorteervolgorde</h3>
                <p class="mt-1 text-gray-900">{{ $portfolioItem->sort_order }}</p>
              </div>

              <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Aangemaakt</h3>
                <p class="mt-1 text-gray-900">{{ $portfolioItem->created_at->format('d M Y, H:i') }}</p>
              </div>

              @if ($portfolioItem->updated_at != $portfolioItem->created_at)
                <div>
                  <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Laatst Bijgewerkt</h3>
                  <p class="mt-1 text-gray-900">{{ $portfolioItem->updated_at->format('d M Y, H:i') }}</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="mt-8 flex justify-center gap-4">
        <a href="{{ route('creator.portfolio.edit', $portfolioItem) }}"
          class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
          <i data-lucide="edit" class="w-5 h-5 mr-2"></i>
          Item Bewerken
        </a>

        <form action="{{ route('creator.portfolio.toggle-status', $portfolioItem) }}" method="POST" class="inline">
          @csrf
          @method('PATCH')
          <button type="submit" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
            @if ($portfolioItem->is_active)
              <i data-lucide="eye-off" class="w-5 h-5 mr-2"></i>
              Deactiveren
            @else
              <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
              Activeren
            @endif
          </button>
        </form>
      </div>
    </div>
  </div>
@endsection
