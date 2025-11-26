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
        <h1 class="text-3xl font-bold text-gray-900">Nieuw Portfolio Item</h1>
        <p class="text-gray-600 mt-2">Voeg een nieuw item toe aan je portfolio</p>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('creator.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
              Titel <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
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
              placeholder="Beschrijf je portfolio item...">{{ old('description') }}</textarea>
            @error('description')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- File Upload -->
          <div>
            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
              Bestand <span class="text-red-500">*</span>
            </label>
            <div class="dropzone mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-gray-300 border-dashed rounded-lg hover:border-pink-400 transition-all cursor-pointer bg-gray-50 hover:bg-pink-25">
              <div class="space-y-3 text-center">
                <div class="mx-auto h-16 w-16 text-gray-400">
                  <i data-lucide="upload" class="w-16 h-16"></i>
                </div>
                <div class="space-y-2">
                  <label for="file" class="block cursor-pointer">
                    <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-500 to-orange-500 text-white rounded-md hover:from-pink-600 hover:to-orange-600 transition-colors font-medium">
                      <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                      Kies bestand
                    </span>
                    <input id="file" name="file" type="file" class="sr-only file-input" accept="image/*,video/*" required onchange="updateFileName(this)">
                  </label>
                  <p class="text-sm text-gray-600">of sleep je bestand hierheen</p>
                </div>
                <div class="text-xs text-gray-500 space-y-1">
                  <p><strong>Ondersteunde formaten:</strong> JPG, PNG, GIF, MP4, MOV, AVI</p>
                  <p><strong>Maximale grootte:</strong> 20MB</p>
                </div>
                <div id="file-name" class="text-sm text-gray-900 font-medium hidden bg-white rounded-lg px-3 py-2 border border-gray-200"></div>
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
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('sort_order') border-red-500 @enderror" placeholder="0">
            <p class="mt-1 text-sm text-gray-500">Lagere nummers worden eerst getoond</p>
            @error('sort_order')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Active Status -->
          <div class="flex items-center">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
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
              Portfolio Item Opslaan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function updateFileName(input) {
      const fileName = document.getElementById('file-name');
      const uploadIcon = document.querySelector('[data-lucide="upload"]');

      if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file size (20MB)
        if (file.size > 20 * 1024 * 1024) {
          alert('Bestand is te groot. Maximum grootte is 20MB.');
          input.value = '';
          fileName.classList.add('hidden');
          return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime', 'video/x-msvideo'];
        if (!allowedTypes.includes(file.type)) {
          alert('Bestandstype niet ondersteund. Gebruik JPG, PNG, GIF, MP4, MOV of AVI.');
          input.value = '';
          fileName.classList.add('hidden');
          return;
        }

        fileName.innerHTML = `<i data-lucide="check-circle" class="w-4 h-4 inline mr-1 text-green-500"></i>Geselecteerd: ${file.name} (${formatFileSize(file.size)})`;
        fileName.classList.remove('hidden');

        // Change upload icon to check
        if (uploadIcon) {
          uploadIcon.setAttribute('data-lucide', 'check-circle');
          uploadIcon.classList.add('text-green-500');
        }

        // Re-initialize icons
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }
      } else {
        fileName.classList.add('hidden');
        if (uploadIcon) {
          uploadIcon.setAttribute('data-lucide', 'upload');
          uploadIcon.classList.remove('text-green-500');
        }
        if (typeof lucide !== 'undefined') {
          lucide.createIcons();
        }
      }
    }

    function formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
    });

    // Drag and drop functionality
    const dropZone = document.querySelector('.dropzone');
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
