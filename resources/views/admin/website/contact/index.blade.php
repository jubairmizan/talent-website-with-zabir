@extends('admin.layout')

@section('title', 'Contact Page Settings')
@section('page-title', 'Contact Page Management')

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
      <ul class="nav nav-tabs mb-4" id="contactPageTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="hero-form-tab" data-bs-toggle="tab" data-bs-target="#hero-form" type="button" role="tab">
            <i class="fas fa-edit me-2"></i>Hero & Form
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-info-tab" data-bs-toggle="tab" data-bs-target="#contact-info" type="button" role="tab">
            <i class="fas fa-address-card me-2"></i>Contact Info
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="faqs-tab" data-bs-toggle="tab" data-bs-target="#faqs" type="button" role="tab">
            <i class="fas fa-question-circle me-2"></i>FAQs
          </button>
        </li>
      </ul>

      <div class="tab-content" id="contactPageTabsContent">
        <!-- Hero & Form Tab -->
        <div class="tab-pane fade show active" id="hero-form" role="tabpanel">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="fas fa-star me-2"></i>Hero & Form Section
              </h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.website.contact.update') }}" method="POST">
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
                </div>

                <h6 class="border-bottom pb-2 mb-3 mt-4">Form Section</h6>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="form_section_title" class="form-label">
                      Form Section Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('form_section_title') is-invalid @enderror" id="form_section_title" name="form_section_title" value="{{ old('form_section_title', $settings->form_section_title) }}" required>
                    @error('form_section_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="form_section_subtitle" class="form-label">
                      Form Section Subtitle <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('form_section_subtitle') is-invalid @enderror" id="form_section_subtitle" name="form_section_subtitle" rows="2" required>{{ old('form_section_subtitle', $settings->form_section_subtitle) }}</textarea>
                    @error('form_section_subtitle')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="form_button_text" class="form-label">
                      Form Button Text <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('form_button_text') is-invalid @enderror" id="form_button_text" name="form_button_text" value="{{ old('form_button_text', $settings->form_button_text) }}" required>
                    @error('form_button_text')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <h6 class="border-bottom pb-2 mb-3 mt-4">Success Message</h6>

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="success_title" class="form-label">
                      Success Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('success_title') is-invalid @enderror" id="success_title" name="success_title" value="{{ old('success_title', $settings->success_title) }}" required>
                    @error('success_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="success_message" class="form-label">
                      Success Message <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('success_message') is-invalid @enderror" id="success_message" name="success_message" rows="2" required>{{ old('success_message', $settings->success_message) }}</textarea>
                    @error('success_message')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="success_button_text" class="form-label">
                      Success Button Text <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('success_button_text') is-invalid @enderror" id="success_button_text" name="success_button_text" value="{{ old('success_button_text', $settings->success_button_text) }}"
                      required>
                    @error('success_button_text')
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

        <!-- Contact Info Tab -->
        <div class="tab-pane fade" id="contact-info" role="tabpanel">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">
                <i class="fas fa-address-card me-2"></i>Contact Information
              </h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.website.contact.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                  <div class="col-md-12 mb-4">
                    <label for="contact_info_title" class="form-label">
                      Contact Info Section Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('contact_info_title') is-invalid @enderror" id="contact_info_title" name="contact_info_title" value="{{ old('contact_info_title', $settings->contact_info_title) }}" required>
                    @error('contact_info_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="contact_address" class="form-label">
                      Address
                    </label>
                    <input type="text" class="form-control @error('contact_address') is-invalid @enderror" id="contact_address" name="contact_address" value="{{ old('contact_address', $settings->contact_address) }}"
                      placeholder="e.g., Willemstad, Curaçao">
                    @error('contact_address')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="contact_email" class="form-label">
                      Email
                    </label>
                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" placeholder="info@example.com">
                    @error('contact_email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="contact_phone" class="form-label">
                      Phone
                    </label>
                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" placeholder="+59995109456">
                    @error('contact_phone')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6 mb-4">
                    <label for="faq_section_title" class="form-label">
                      FAQ Section Title <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('faq_section_title') is-invalid @enderror" id="faq_section_title" name="faq_section_title" value="{{ old('faq_section_title', $settings->faq_section_title) }}" required>
                    @error('faq_section_title')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12 mb-4">
                    <label for="contact_hours" class="form-label">
                      Opening Hours
                    </label>
                    <textarea class="form-control @error('contact_hours') is-invalid @enderror" id="contact_hours" name="contact_hours" rows="3" placeholder="Maandag - Vrijdag: 9:00 - 17:00&#10;Weekend: 10:00 - 14:00">{{ old('contact_hours', $settings->contact_hours) }}</textarea>
                    @error('contact_hours')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Use line breaks for multiple lines</small>
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

        <!-- FAQs Tab -->
        <div class="tab-pane fade" id="faqs" role="tabpanel">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-question-circle me-2"></i>FAQ Items
              </h5>
              <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFaqModal">
                <i class="fas fa-plus me-2"></i>Add FAQ
              </button>
            </div>
            <div class="card-body">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>Drag and drop to reorder FAQs. Changes are saved automatically.
              </div>

              <div id="faqs-list" class="list-group">
                @forelse($faqs as $faq)
                  <div class="list-group-item" data-id="{{ $faq->id }}">
                    <div class="d-flex align-items-start">
                      <div class="drag-handle me-3" style="cursor: move;">
                        <i class="fas fa-grip-vertical text-muted"></i>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                          <strong class="flex-grow-1">{{ $faq->question }}</strong>
                          <span class="badge {{ $faq->is_active ? 'bg-success' : 'bg-secondary' }} ms-2">
                            {{ $faq->is_active ? 'Active' : 'Inactive' }}
                          </span>
                        </div>
                        <p class="text-muted mb-0 small">{{ $faq->answer }}</p>
                      </div>
                      <div class="btn-group ms-3">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}', {{ $faq->is_active ? 'true' : 'false' }})">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}')">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                @empty
                  <div class="text-center py-5 text-muted">
                    <i class="fas fa-question-circle fa-3x mb-3 opacity-25"></i>
                    <p>No FAQs added yet. Click "Add FAQ" to create one.</p>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add FAQ Modal -->
  <div class="modal fade" id="addFaqModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('admin.website.contact.faqs.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title">Add New FAQ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="add_question" class="form-label">Question <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="add_question" name="question" required>
            </div>
            <div class="mb-3">
              <label for="add_answer" class="form-label">Answer <span class="text-danger">*</span></label>
              <textarea class="form-control" id="add_answer" name="answer" rows="4" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add FAQ</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit FAQ Modal -->
  <div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editFaqForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title">Edit FAQ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="edit_question" class="form-label">Question <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="edit_question" name="question" required>
            </div>
            <div class="mb-3">
              <label for="edit_answer" class="form-label">Answer <span class="text-danger">*</span></label>
              <textarea class="form-control" id="edit_answer" name="answer" rows="4" required></textarea>
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
            <button type="submit" class="btn btn-primary">Update FAQ</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete FAQ Form (hidden) -->
  <form id="deleteFaqForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
  </form>

  <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
  <script>
    // Initialize Sortable for drag and drop
    document.addEventListener('DOMContentLoaded', function() {
      const faqsList = document.getElementById('faqs-list');
      if (faqsList && faqsList.children.length > 0) {
        new Sortable(faqsList, {
          animation: 150,
          handle: '.drag-handle',
          onEnd: function() {
            const order = Array.from(faqsList.children).map(item => item.dataset.id);

            fetch('{{ route('admin.website.contact.faqs.reorder') }}', {
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
                  showToast('FAQs reordered successfully!', 'success');
                }
              })
              .catch(error => {
                console.error('Error:', error);
                showToast('Failed to reorder FAQs', 'error');
              });
          }
        });
      }
    });

    function editFaq(id, question, answer, isActive) {
      const form = document.getElementById('editFaqForm');
      form.action = `/admin/website/contact/faqs/${id}`;

      document.getElementById('edit_question').value = question;
      document.getElementById('edit_answer').value = answer;
      document.getElementById('edit_is_active').checked = isActive;

      new bootstrap.Modal(document.getElementById('editFaqModal')).show();
    }

    function deleteFaq(id, question) {
      if (confirm(`Are you sure you want to delete "${question}"?`)) {
        const form = document.getElementById('deleteFaqForm');
        form.action = `/admin/website/contact/faqs/${id}`;
        form.submit();
      }
    }

    function showToast(message, type) {
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
