@extends('admin.layout')

@section('title', 'About Page Settings')
@section('page-title', 'About Page Management')

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
      <ul class="nav nav-tabs mb-4" id="aboutPageTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="hero-mission-tab" data-bs-toggle="tab" data-bs-target="#hero-mission" type="button" role="tab">
            <i class="fas fa-edit me-2"></i>Hero & Mission
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics" type="button" role="tab">
            <i class="fas fa-chart-bar me-2"></i>Statistics
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="values-tab" data-bs-toggle="tab" data-bs-target="#values" type="button" role="tab">
            <i class="fas fa-heart me-2"></i>Values
          </button>
        </li>
      </ul>

      <div class="tab-content" id="aboutPageTabsContent">
        <!-- Hero & Mission Tab -->
        <div class="tab-pane fade show active" id="hero-mission" role="tabpanel">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="fas fa-star me-2"></i>Hero & Mission Section
              </h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.website.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h6 class="border-bottom pb-2 mb-3">Hero Section</h6>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="hero_title" class="form-label">
                      Hero Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('hero_title') is-invalid @enderror" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings->hero_title) }}" required>
                    @error('hero_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="hero_subtitle" class="form-label">
                      Hero Subtitle <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('hero_subtitle') is-invalid @enderror" id="hero_subtitle" name="hero_subtitle" rows="3" required>{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                    @error('hero_subtitle')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="hero_button_text" class="form-label">
                      Hero Button Text <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('hero_button_text') is-invalid @enderror" id="hero_button_text" name="hero_button_text" value="{{ old('hero_button_text', $settings->hero_button_text) }}" required>
                    @error('hero_button_text')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <h6 class="border-bottom pb-2 mb-3 mt-4">Mission Section</h6>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="mission_title" class="form-label">
                      Mission Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('mission_title') is-invalid @enderror" id="mission_title" name="mission_title" value="{{ old('mission_title', $settings->mission_title) }}" required>
                    @error('mission_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="mission_description_1" class="form-label">
                      Mission Description (Paragraph 1) <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('mission_description_1') is-invalid @enderror" id="mission_description_1" name="mission_description_1" rows="4" required>{{ old('mission_description_1', $settings->mission_description_1) }}</textarea>
                    @error('mission_description_1')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="mission_description_2" class="form-label">
                      Mission Description (Paragraph 2) <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('mission_description_2') is-invalid @enderror" id="mission_description_2" name="mission_description_2" rows="3" required>{{ old('mission_description_2', $settings->mission_description_2) }}</textarea>
                    @error('mission_description_2')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="mission_image" class="form-label">
                      Mission Image
                    </label>

                    @if ($settings->mission_image_url)
                      <div class="mb-3">
                        <img src="{{ $settings->mission_image_url }}" alt="Mission Image" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                      </div>
                    @endif

                    <input type="file" class="form-control @error('mission_image') is-invalid @enderror" id="mission_image" name="mission_image" accept="image/*">
                    @error('mission_image')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Or enter an image URL below (max 10MB)</small>
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="mission_image_url" class="form-label">
                      Mission Image URL (Alternative)
                    </label>
                    <input type="url" class="form-control @error('mission_image_url') is-invalid @enderror" id="mission_image_url" name="mission_image_url" value="{{ old('mission_image_url', $settings->mission_image_url) }}"
                      placeholder="https://example.com/image.jpg">
                    @error('mission_image_url')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="text-end">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Statistics Tab -->
        <div class="tab-pane fade" id="statistics" role="tabpanel">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="fas fa-chart-bar me-2"></i>Statistics Section
              </h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.website.about.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <label for="stat_talents_count" class="form-label">
                      Talents Count <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('stat_talents_count') is-invalid @enderror" id="stat_talents_count" name="stat_talents_count" value="{{ old('stat_talents_count', $settings->stat_talents_count) }}" required
                      placeholder="e.g., 500+">
                    @error('stat_talents_count')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="stat_talents_label" class="form-label">
                      Talents Label <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('stat_talents_label') is-invalid @enderror" id="stat_talents_label" name="stat_talents_label" value="{{ old('stat_talents_label', $settings->stat_talents_label) }}" required
                      placeholder="e.g., Geregistreerde Talenten">
                    @error('stat_talents_label')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="stat_projects_count" class="form-label">
                      Projects Count <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('stat_projects_count') is-invalid @enderror" id="stat_projects_count" name="stat_projects_count" value="{{ old('stat_projects_count', $settings->stat_projects_count) }}"
                      required placeholder="e.g., 1,200+">
                    @error('stat_projects_count')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="stat_projects_label" class="form-label">
                      Projects Label <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('stat_projects_label') is-invalid @enderror" id="stat_projects_label" name="stat_projects_label" value="{{ old('stat_projects_label', $settings->stat_projects_label) }}"
                      required placeholder="e.g., Voltooide Projecten">
                    @error('stat_projects_label')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="values_section_title" class="form-label">
                      Values Section Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('values_section_title') is-invalid @enderror" id="values_section_title" name="values_section_title" value="{{ old('values_section_title', $settings->values_section_title) }}"
                      required>
                    @error('values_section_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="values_section_subtitle" class="form-label">
                      Values Section Subtitle <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('values_section_subtitle') is-invalid @enderror" id="values_section_subtitle" name="values_section_subtitle"
                      value="{{ old('values_section_subtitle', $settings->values_section_subtitle) }}" required>
                    @error('values_section_subtitle')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="text-end">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Changes
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Values Tab -->
        <div class="tab-pane fade" id="values" role="tabpanel">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-heart me-2"></i>Value Cards
              </h5>
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addValueModal">
                <i class="fas fa-plus me-2"></i>Add Value
              </button>
            </div>
            <div class="card-body">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>Drag and drop to reorder values. Changes are saved automatically.
              </div>

              <div id="values-list" class="list-group">
                @forelse($values as $value)
                  <div class="list-group-item" data-id="{{ $value->id }}">
                    <div class="d-flex align-items-center">
                      <div class="drag-handle me-3" style="cursor: move;">
                        <i class="fas fa-grip-vertical text-muted"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                          <i class="fas fa-{{ $value->icon }} me-2" style="color: #6A0AFC;"></i>
                          <strong>{{ $value->title }}</strong>
                          <span class="badge {{ $value->is_active ? 'bg-success' : 'bg-secondary' }} ms-2">
                            {{ $value->is_active ? 'Active' : 'Inactive' }}
                          </span>
                        </div>
                        <p class="text-muted mb-0 small">{{ $value->description }}</p>
                      </div>
                      <div class="btn-group ms-3">
                        <button type="button" class="btn btn-sm btn-outline-primary"
                          onclick="editValue({{ $value->id }}, '{{ $value->icon }}', '{{ $value->title }}', '{{ addslashes($value->description) }}', {{ $value->is_active ? 'true' : 'false' }})">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteValue({{ $value->id }}, '{{ $value->title }}')">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="text-center py-5 text-muted">
                    <i class="fas fa-heart fa-3x mb-3 opacity-25"></i>
                    <p>No values added yet. Click "Add Value" to create one.</p>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Value Modal -->
  <div class="modal fade" id="addValueModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('admin.website.about.values.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add New Value</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="add_icon" class="form-label">Icon <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="add_icon" name="icon" required placeholder="e.g., users, target, heart, award">
              <small class="form-text text-muted">Use Lucide icon names (e.g., users, target, heart, award, star)</small>
            </div>
            <div class="mb-3">
              <label for="add_title" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="add_title" name="title" required>
            </div>
            <div class="mb-3">
              <label for="add_description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" id="add_description" name="description" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Value</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Value Modal -->
  <div class="modal fade" id="editValueModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editValueForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title">Edit Value</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_icon" class="form-label">Icon <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="edit_icon" name="icon" required>
              <small class="form-text text-muted">Use Lucide icon names</small>
            </div>
            <div class="mb-3">
              <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="edit_title" name="title" required>
            </div>
            <div class="mb-3">
              <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
              <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active" value="1">
                <label class="form-check-label" for="edit_is_active">
                  Active
                </label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Value</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Value Form (hidden) -->
  <form id="deleteValueForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>

  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script>
    // Initialize Sortable for drag and drop
    document.addEventListener('DOMContentLoaded', function() {
      const valuesList = document.getElementById('values-list');
      if (valuesList && valuesList.children.length > 0) {
        new Sortable(valuesList, {
          animation: 150,
          handle: '.drag-handle',
          onEnd: function() {
            const order = Array.from(valuesList.children).map(item => item.dataset.id);

            fetch('{{ route('admin.website.about.values.reorder') }}', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                  order: order
                })
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  // Show success message
                  showToast('Values reordered successfully!', 'success');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                showToast('Failed to reorder values', 'error');
              });
          }
        });
      }
    });

    function editValue(id, icon, title, description, isActive) {
      const form = document.getElementById('editValueForm');
      form.action = `/admin/website/about/values/${id}`;

      document.getElementById('edit_icon').value = icon;
      document.getElementById('edit_title').value = title;
      document.getElementById('edit_description').value = description;
      document.getElementById('edit_is_active').checked = isActive;

      new bootstrap.Modal(document.getElementById('editValueModal')).show();
    }

    function deleteValue(id, title) {
      if (confirm(`Are you sure you want to delete "${title}"?`)) {
        const form = document.getElementById('deleteValueForm');
        form.action = `/admin/website/about/values/${id}`;
        form.submit();
      }
    }

    function showToast(message, type) {
      // Simple toast notification
      const toast = document.createElement('div');
      toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
      toast.style.zIndex = '9999';
      toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}`;
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.remove();
      }, 3000);
    }
  </script>
@endsection
