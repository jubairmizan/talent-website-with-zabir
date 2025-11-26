@extends('admin.layout')

@section('title', 'Home Page Settings')
@section('page-title', 'Home Page Management')

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
              <a class="nav-link active" href="{{ route('admin.website.home.index') }}">
                <i class="fas fa-edit me-2"></i>Hero Section
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.website.home.slides') }}">
                <i class="fas fa-images me-2"></i>Background Slides
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Hero Section Settings -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-star me-2"></i>Hero Section Settings
          </h5>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.website.home.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-12 mb-4">
                <label for="hero_title" class="form-label">
                  Hero Title <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('hero_title') is-invalid @enderror" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}" required placeholder="Enter the main hero title">
                @error('hero_title')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">This is the main headline displayed on the homepage.</small>
              </div>

              <div class="col-md-12 mb-4">
                <label for="hero_subtitle" class="form-label">
                  Hero Subtitle <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('hero_subtitle') is-invalid @enderror" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $settings->hero_subtitle) }}" required placeholder="Enter the hero subtitle">
                @error('hero_subtitle')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">The tagline below the main headline.</small>
              </div>

              <div class="col-md-12 mb-4">
                <label for="hero_video_url" class="form-label">
                  Hero Video URL
                </label>
                <input type="url" class="form-control @error('hero_video_url') is-invalid @enderror" id="hero_video_url" name="hero_video_url" value="{{ old('hero_video_url', $settings->hero_video_url) }}"
                  placeholder="https://example.com/video.mp4">
                @error('hero_video_url')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Full URL to the video displayed in the hero section.</small>
              </div>

              <div class="col-md-12 mb-4">
                <label for="search_placeholder_text" class="form-label">
                  Search Placeholder Text <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control @error('search_placeholder_text') is-invalid @enderror" id="search_placeholder_text" name="search_placeholder_text"
                  value="{{ old('search_placeholder_text', $settings->search_placeholder_text) }}" required placeholder="Enter search box placeholder text">
                @error('search_placeholder_text')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Placeholder text shown in the search input box.</small>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Save Changes
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Preview Section -->
      {{-- <div class="card mt-4">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-eye me-2"></i>Preview
          </h5>
        </div>
        <div class="card-body">
          <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Current settings will be displayed on the homepage. Save your changes to update the live site.
          </div>
          <div class="row">
            <div class="col-md-6">
              <h6 class="text-muted mb-2">Hero Title:</h6>
              <h3 class="mb-3">{{ $settings->hero_title }}</h3>
            </div>
            <div class="col-md-6">
              <h6 class="text-muted mb-2">Hero Subtitle:</h6>
              <p class="lead">{{ $settings->hero_subtitle }}</p>
            </div>
            <div class="col-md-6 mt-3">
              <h6 class="text-muted mb-2">Video URL:</h6>
              <p>{{ $settings->hero_video_url ?: 'Not set' }}</p>
            </div>
            <div class="col-md-6 mt-3">
              <h6 class="text-muted mb-2">Search Placeholder:</h6>
              <p>{{ $settings->search_placeholder_text }}</p>
            </div>
          </div>
        </div>
      </div> --}}
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
  </style>
@endsection
