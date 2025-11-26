@extends('layouts.creator')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
          <a href="{{ route('creator.portfolio.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
            Terug naar Portfolio
          </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Portfolio Item Bewerken</h1>
        <p class="text-gray-600 mt-2">Bewerk "{{ $portfolioItem->title }}"</p>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('creator.portfolio.update', $portfolioItem) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Current File Preview -->
          <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Huidig Bestand</label>
            <div class="relative w-48 h-32 bg-gray-100 rounded-lg overflow-hidden">
              @if ($portfolioItem->file_type === 'image')
                <img src="{{ asset('storage/' . $portfolioItem->file_path) }}" alt="{{ $portfolioItem->title }}" class="w-full h-full object-cover">
              @elseif($portfolioItem->file_type === 'video')
                @if ($portfolioItem->thumbnail_path)
                  <img src="{{ asset('storage/' . $portfolioItem->thumbnail_path) }}" alt="{{ $portfolioItem->title }}" class="w-full h-full object-cover">
                @else
                  <div class="w-full h-full flex items-center justify-center bg-gray-200">
                    <i data-lucide="play-circle" class="w-8 h-8 text-gray-400"></i>
                  </div>
                @endif
                <div class="absolute top-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                  <i data-lucide="play" class="w-3 h-3 inline mr-1"></i>
                  Video
                </div>
              @endif
            </div>
          </div>

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Titel <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title', $portfolioItem->title) }}"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('title') border-red-500 @enderror" placeholder="Bijv. Summer Wedding Collection"
              required>
            @error('title')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Beschrijving
            </label>
            <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('description') border-red-500 @enderror"
              placeholder="Beschrijf je portfolio item...">{{ old('description', $portfolioItem->description) }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- File Upload (Optional for edit) -->
          <div>
            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
              Nieuw Bestand (optioneel)
            </label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-pink-400 transition-colors">
              <div class="space-y-1 text-center">
                <div class="mx-auto h-12 w-12 text-gray-400">
                  <i data-lucide="upload" class="w-12 h-12"></i>
                </div>
                <div class="flex text-sm text-gray-600">
                  <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-pink-600 hover:text-pink-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-pink-500">
                    <span>Upload een nieuw bestand</span>
                    <input id="file" name="file" type="file" class="sr-only" accept="image/*,video/*" onchange="updateFileName(this)">
                  </label>
                  <p class="pl-1">of sleep en zet neer</p>
                </div>
                <p class="text-xs text-gray-500">
                  PNG, JPG, GIF, MP4, MOV, AVI tot 20MB
                </p>
                <p class="text-xs text-gray-500">
                  Laat leeg om het huidige bestand te behouden
                </p>
                <p id="file-name" class="text-sm text-gray-900 font-medium hidden"></p>
              </div>
            </div>
            @error('file')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Sort Order -->
          <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
              Sorteervolgorde
            </label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $portfolioItem->sort_order) }}" min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('sort_order') border-red-500 @enderror" placeholder="0">
            <p class="mt-1 text-sm text-gray-500">Lagere nummers worden eerst getoond</p>
            @error('sort_order')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Active Status -->
          <div class="flex items-center">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $portfolioItem->is_active) ? 'checked' : '' }} class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
            <label for="is_active" class="ml-2 block text-sm text-gray-700">
              Item actief maken (zichtbaar in portfolio)
            </label>
          </div>

          <!-- Form Actions -->
          <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('creator.portfolio.index') }}"
              class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
              Annuleren
            </a>
            <button type="submit"
              class="px-4 py-2 bg-gradient-to-r from-pink-500 to-orange-500 text-white rounded-md shadow-sm text-sm font-medium hover:from-pink-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
              <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
              Wijzigingen Opslaan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function updateFileName(input) {
      const fileNameElement = document.getElementById('file-name');
      if (input.files && input.files[0]) {
        fileNameElement.textContent = input.files[0].name;
        fileNameElement.classList.remove('hidden');
      } else {
        fileNameElement.classList.add('hidden');
      }
    }

    // Drag and drop functionality
    const dropZone = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('file');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
      e.preventDefault();
      e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
      dropZone.classList.add('border-pink-400', 'bg-pink-50');
    }

    function unhighlight(e) {
      dropZone.classList.remove('border-pink-400', 'bg-pink-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
      const dt = e.dataTransfer;
      const files = dt.files;

      if (files.length > 0) {
        fileInput.files = files;
        updateFileName(fileInput);
      }
    }
  </script>
@endsection
