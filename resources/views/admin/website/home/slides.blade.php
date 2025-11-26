@extends('admin.layout')

@section('title', 'Background Slides Management')
@section('page-title', 'Background Slides Management')

@section('content')
  <div class="content-area">
    <div class="container-fluid">
      <!-- Success Message -->
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <!-- Error Messages -->
      @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i>
          <strong>Please fix the following errors:</strong>
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <!-- Navigation Tabs -->
      <div class="card mb-4">
        <div class="card-body p-0">
          <ul class="nav nav-tabs border-0" role="tablist">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.website.home.index') }}">
                <i class="fas fa-edit me-2"></i>Hero Section
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('admin.website.home.slides') }}">
                <i class="fas fa-images me-2"></i>Background Slides
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Add New Slide -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>Add New Slide
          </h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.website.home.slides.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                @error('image')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Upload an image (JPEG, PNG, WebP). Max size: 5MB</small>
              </div>

              <div class="col-md-6 mb-3">
                <label for="image_url" class="form-label">Or Image URL</label>
                <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" placeholder="https://example.com/image.jpg">
                @error('image_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Or provide a full URL to an external image</small>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">
              <i class="fas fa-plus me-2"></i>Add Slide
            </button>
          </form>
        </div>
      </div>

      <!-- Existing Slides -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-images me-2"></i>Background Slides ({{ $slides->count() }})
          </h5>
          @if ($slides->count() > 0)
            <small class="text-muted">Drag to reorder</small>
          @endif
        </div>
        <div class="card-body">
          @if ($slides->count() === 0)
            <div class="text-center py-5">
              <i class="fas fa-images fa-3x text-muted mb-3"></i>
              <p class="text-muted">No slides added yet. Add your first slide above!</p>
            </div>
          @else
            <div class="row" id="slides-container">
              @foreach ($slides as $slide)
                <div class="col-md-4 mb-4" data-slide-id="{{ $slide->id }}">
                  <div class="card slide-card">
                    <div class="position-relative">
                      <img src="{{ $slide->image_url }}" class="card-img-top" alt="Slide {{ $slide->order }}" style="height: 200px; object-fit: cover;">

                      <!-- Status Badge -->
                      <span class="badge position-absolute top-0 start-0 m-2 {{ $slide->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                      </span>

                      <!-- Drag Handle -->
                      <div class="drag-handle position-absolute top-0 end-0 m-2 bg-dark text-white px-2 py-1 rounded" style="cursor: move;">
                        <i class="fas fa-grip-vertical"></i>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Order: {{ $slide->order }}</span>
                        <div class="btn-group btn-group-sm">
                          <!-- Toggle Active -->
                          <form action="{{ route('admin.website.home.slides.toggle', $slide) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $slide->is_active ? 'warning' : 'success' }}" title="{{ $slide->is_active ? 'Deactivate' : 'Activate' }}">
                              <i class="fas fa-{{ $slide->is_active ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                          </form>

                          <!-- Delete -->
                          <form action="{{ route('admin.website.home.slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this slide?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Delete">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>

      <div class="mt-3">
        <a href="{{ route('admin.website.home.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to Hero Section
        </a>
      </div>
    </div>
  </div>

  <style>
    .nav-tabs .nav-link {
      color: var(--secondary-color);
      border: none;
      border-bottom: 3px solid transparent;
      padding: 1rem 1.5rem;
    }

    .nav-tabs .nav-link:hover {
      border-bottom-color: var(--accent-color);
      background: transparent;
    }

    .nav-tabs .nav-link.active {
      color: var(--accent-color);
      border-bottom-color: var(--accent-color);
      background: transparent;
      font-weight: 600;
    }

    .slide-card {
      transition: all 0.3s ease;
    }

    .slide-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .drag-handle {
      cursor: move;
      user-select: none;
    }

    .sortable-ghost {
      opacity: 0.4;
    }

    .sortable-chosen {
      background: #f8f9fa;
    }
  </style>

  <!-- SortableJS for drag and drop -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const slidesContainer = document.getElementById('slides-container');

      if (slidesContainer && slidesContainer.children.length > 0) {
        new Sortable(slidesContainer, {
          animation: 150,
          handle: '.drag-handle',
          ghostClass: 'sortable-ghost',
          chosenClass: 'sortable-chosen',
          onEnd: function(evt) {
            // Get all slide IDs in new order
            const slides = [];
            document.querySelectorAll('[data-slide-id]').forEach((el, index) => {
              slides.push({
                id: parseInt(el.dataset.slideId),
                order: index + 1
              });
            });

            // Send AJAX request to update order
            fetch('{{ route('admin.website.home.slides.reorder') }}', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                  slides: slides
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  // Show success message
                  const alertDiv = document.createElement('div');
                  alertDiv.className = 'alert alert-success alert-dismissible fade show';
                  alertDiv.innerHTML = `
                                <i class="fas fa-check-circle me-2"></i>${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                  document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.card'));

                  // Auto dismiss after 3 seconds
                  setTimeout(() => {
                    alertDiv.remove();
                  }, 3000);
                }
              })
              .catch(error => {
                console.error('Error:', error);
                alert('Failed to update slide order. Please try again.');
              });
          }
        });
      }
    });
  </script>
@endsection
