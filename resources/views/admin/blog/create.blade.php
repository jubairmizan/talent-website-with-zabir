@extends('admin.layout')

@section('title', 'Create Blog Post')
@section('page-title', 'Create New Blog Post')

@push('styles')
<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .image-preview {
        width: 200px;
        height: 150px;
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .image-preview:hover {
        border-color: #007bff;
        background: #e3f2fd;
    }
    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    .ck-editor__editable {
        min-height: 400px;
    }
    .slug-preview {
        background: #e9ecef;
        padding: 0.5rem;
        border-radius: 5px;
        font-family: monospace;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card form-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-plus-circle me-2"></i>
                    Create New Blog Post
                </h5>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Posts
                </a>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Basic Information
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    <div class="form-text">The main title of your blog post</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">URL Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
                            <div class="form-text">Leave empty to auto-generate from title</div>
                            <div class="slug-preview mt-2" id="slugPreview" style="display: none;">
                                URL: <span id="slugUrl"></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt</label>
                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3" maxlength="500">{{ old('excerpt') }}</textarea>
                            <div class="form-text">Brief description of the post (max 500 characters)</div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-edit me-2"></i>
                            Content
                        </h6>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <!-- Media & Categories -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-image me-2"></i>
                            Media & Categories
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Featured Image</label>
                                    <div class="image-preview" onclick="document.getElementById('featured_image').click()">
                                        <div class="text-center" id="imagePreviewContent">
                                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">Click to upload image</p>
                                            <small class="text-muted">JPG, PNG, GIF (max 2MB)</small>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control d-none" id="featured_image" name="featured_image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="blog_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="blog_category_id" name="blog_category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="author_id" class="form-label">Author <span class="text-danger">*</span></label>
                                    <select class="form-select" id="author_id" name="author_id" required>
                                        @foreach($authors as $author)
                                            <option value="{{ $author->id }}" {{ (old('author_id') ?? auth()->id()) == $author->id ? 'selected' : '' }}>
                                                {{ $author->name }} ({{ ucfirst($author->role) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Publishing Options -->
                    <div class="form-section">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-cog me-2"></i>
                            Publishing Options
                        </h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Publish Date</label>
                                    <input type="datetime-local" class="form-control" id="published_at" name="published_at" value="{{ old('published_at') }}">
                                    <div class="form-text">Leave empty to publish immediately when status is set to published</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            <strong>Featured Post</strong>
                                            <br>
                                            <small class="text-muted">This post will be highlighted on the homepage</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Cancel
                        </a>
                        <div>
                            <button type="submit" name="action" value="save_draft" class="btn btn-outline-primary me-2">
                                <i class="fas fa-save me-1"></i>
                                Save as Draft
                            </button>
                            <button type="submit" name="action" value="publish" class="btn btn-success">
                                <i class="fas fa-paper-plane me-1"></i>
                                Publish Post
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editor;

    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'bulletedList', 'numberedList', '|',
                'outdent', 'indent', '|',
                'imageUpload', 'blockQuote', 'insertTable', '|',
                'undo', 'redo', '|',
                'alignment', 'fontColor', 'fontBackgroundColor', '|',
                'code', 'codeBlock', 'horizontalLine'
            ],
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageCaption', '|',
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells'
                ]
            },
            ckfinder: {
                uploadUrl: '{{ route("admin.blog.upload-image") }}?_token={{ csrf_token() }}'
            }
        })
        .then(newEditor => {
            editor = newEditor;
            
            // Store editor instance globally for form submission
            window.editorInstance = editor;
            
            // Set minimum height
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
            });
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });

    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        const slugInput = document.getElementById('slug');
        const slugPreview = document.getElementById('slugPreview');
        const slugUrl = document.getElementById('slugUrl');
        
        if (title && !slugInput.value) {
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            slugInput.value = slug;
            slugUrl.textContent = `{{ url('/blog') }}/${slug}`;
            slugPreview.style.display = 'block';
        }
    });

    // Update slug preview when manually editing slug
    document.getElementById('slug').addEventListener('input', function() {
        const slug = this.value;
        const slugPreview = document.getElementById('slugPreview');
        const slugUrl = document.getElementById('slugUrl');
        
        if (slug) {
            slugUrl.textContent = `{{ url('/blog') }}/${slug}`;
            slugPreview.style.display = 'block';
        } else {
            slugPreview.style.display = 'none';
        }
    });

    // Featured image preview
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContent = document.getElementById('imagePreviewContent');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContent.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission handling
    document.getElementById('blogForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default submission
        
        const action = e.submitter.value;
        const statusSelect = document.getElementById('status');
        
        // Update status based on button clicked
        if (action === 'save_draft') {
            statusSelect.value = 'draft';
        } else if (action === 'publish') {
            statusSelect.value = 'published';
        }
        
        // Sync CKEditor data with textarea
        if (window.editorInstance) {
            const editorData = window.editorInstance.getData();
            document.getElementById('content').value = editorData;
            
            // Validate content is not empty for publish action
            if (action === 'publish' && (!editorData || editorData.trim() === '')) {
                alert('Content is required when publishing a post.');
                return false;
            }
        }
        
        // Create hidden input for action
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        this.appendChild(actionInput);
        
        // Submit the form
        this.submit();
    });

    // Character counter for excerpt
    document.getElementById('excerpt').addEventListener('input', function() {
        const maxLength = 500;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;
        
        let helpText = this.nextElementSibling;
        if (remaining < 50) {
            helpText.innerHTML = `Brief description of the post (${remaining} characters remaining)`;
            helpText.className = remaining < 0 ? 'form-text text-danger' : 'form-text text-warning';
        } else {
            helpText.innerHTML = 'Brief description of the post (max 500 characters)';
            helpText.className = 'form-text';
        }
    });

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
@endpush