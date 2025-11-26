@extends('layouts.creator')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Mijn Portfolio</h1>
          <p class="text-gray-600 mt-2">Beheer je portfolio items en showcase je werk</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('creator.dashboard') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Terug naar Dashboard
          </a>
          <a href="{{ route('creator.portfolio.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-orange-500 text-white rounded-md shadow-sm text-sm font-medium hover:from-pink-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Nieuw Item Toevoegen
          </a>
        </div>
      </div>

      <!-- Success/Error Messages -->
      @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
          {{ session('error') }}
        </div>
      @endif

      <!-- Portfolio Grid -->
      @if ($portfolioItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
          @foreach ($portfolioItems as $item)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden group hover:shadow-lg transition-shadow">
              <!-- Image/Video Preview -->
              <div class="relative aspect-video bg-gray-100">
                @if ($item->file_type === 'image')
                  <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                @elseif($item->file_type === 'video')
                  @if ($item->thumbnail_path)
                    <img src="{{ asset('storage/' . $item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                  @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                      <i data-lucide="play-circle" class="w-12 h-12 text-gray-400"></i>
                    </div>
                  @endif
                  <div class="absolute top-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                    <i data-lucide="play" class="w-3 h-3 inline mr-1"></i>
                    Video
                  </div>
                @endif

                <!-- Status Badge -->
                <div class="absolute top-2 left-2">
                  @if ($item->is_active)
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">Actief</span>
                  @else
                    <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-medium">Inactief</span>
                  @endif
                </div>

                <!-- Action Overlay -->
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                  <div class="flex gap-2">
                    <a href="{{ route('creator.portfolio.show', $item) }}" class="bg-white/90 hover:bg-white text-gray-800 p-2 rounded-full transition-colors" title="Bekijken">
                      <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ route('creator.portfolio.edit', $item) }}" class="bg-white/90 hover:bg-white text-gray-800 p-2 rounded-full transition-colors" title="Bewerken">
                      <i data-lucide="edit" class="w-4 h-4"></i>
                    </a>
                    <form action="{{ route('creator.portfolio.toggle-status', $item) }}" method="POST" class="inline">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="bg-white/90 hover:bg-white text-gray-800 p-2 rounded-full transition-colors" title="{{ $item->is_active ? 'Deactiveren' : 'Activeren' }}">
                        <i data-lucide="{{ $item->is_active ? 'eye-off' : 'eye' }}" class="w-4 h-4"></i>
                      </button>
                    </form>
                    <form action="{{ route('creator.portfolio.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je dit item wilt verwijderen?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="bg-red-500/90 hover:bg-red-500 text-white p-2 rounded-full transition-colors" title="Verwijderen">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>

              <!-- Content -->
              <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $item->title }}</h3>
                @if ($item->description)
                  <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $item->description }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-gray-500">
                  <span>{{ $item->created_at->format('d M Y') }}</span>
                  <span class="capitalize">{{ $item->file_type }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
          {{ $portfolioItems->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-12">
          <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Geen portfolio items</h3>
          <p class="text-gray-600 mb-6">Je hebt nog geen portfolio items toegevoegd. Begin met het uploaden van je eerste werk!</p>
          <a href="{{ route('creator.portfolio.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-orange-500 text-white rounded-md shadow-sm text-sm font-medium hover:from-pink-600 hover:to-orange-600">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
            Eerste Item Toevoegen
          </a>
        </div>
      @endif
    </div>
  </div>

  <style>
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
  </style>
@endsection
