@extends('admin.layout')

@section('title', 'View Blog Post')
@section('page-title', 'Blog Post Preview')

@push('styles')
<style>
    .post-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .post-meta {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .post-content {
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .featured-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    .status-badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
    }
    .meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .meta-item i {
        width: 20px;
        margin-right: 0.5rem;
        color: #6c757d;
    }
    .author-info {
        display: flex;
        align-items: center;
        background: white;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }
    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    .content-preview {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    .content-preview h1, .content-preview h2, .content-preview h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .content-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 1rem 0;
    }
    .content-preview blockquote {
        border-left: 4px solid #007bff;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 5px;
    }
    .action-buttons {
        position: sticky;
        top: 20px;
        background: white;
        padding: 1rem;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .stats-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Post Header -->
        <div class="post-header">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="status-badge bg-{{ $blogPost->status === 'published' ? 'success' : ($blogPost->status === 'pending' ? 'warning' : 'secondary') }}">
                    <i class="fas fa-{{ $blogPost->status === 'published' ? 'check-circle' : ($blogPost->status === 'pending' ? 'clock' : 'edit') }} me-1"></i>
                    {{ ucfirst($blogPost->status) }}
                </span>
                @if($blogPost->is_featured)
                    <span class="badge bg-warning">
                        <i class="fas fa-star me-1"></i>
                        Featured
                    </span>
                @endif
            </div>
            <h1 class="mb-3">{{ $blogPost->title }}</h1>
            @if($blogPost->excerpt)
                <p class="lead mb-0">{{ $blogPost->excerpt }}</p>
            @endif
        </div>

        <!-- Featured Image -->
        @if($blogPost->featured_image)
            <img src="{{ asset('storage/' . $blogPost->featured_image) }}" alt="{{ $blogPost->title }}" class="featured-image">
        @endif

        <!-- Post Meta -->
        <div class="post-meta">
            <div class="row">
                <div class="col-md-6">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $blogPost->author->name ?? 'Unknown Author' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-folder"></i>
                        <span>{{ $blogPost->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>
                            @if($blogPost->published_at)
                                Published: {{ $blogPost->published_at->format('M d, Y \a\t g:i A') }}
                            @else
                                Created: {{ $blogPost->created_at ? $blogPost->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="meta-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ $blogPost->views_count ?? 0 }} views</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-link"></i>
                        <span>{{ $blogPost->slug }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span>Last updated: {{ $blogPost->updated_at ? $blogPost->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Content -->
        <div class="post-content">
            <div class="content-preview">
                {!! $blogPost->content !!}
            </div>
        </div>

        <!-- Author Info -->
        @if($blogPost->author)
        <div class="author-info">
            @if($blogPost->author->avatar)
                <img src="{{ asset('storage/' . $blogPost->author->avatar) }}" alt="{{ $blogPost->author->name }}" class="author-avatar">
            @else
                <div class="author-avatar bg-primary d-flex align-items-center justify-content-center text-white">
                    {{ strtoupper(substr($blogPost->author->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h6 class="mb-1">{{ $blogPost->author->name }}</h6>
                <p class="text-muted mb-1">{{ ucfirst($blogPost->author->role) }}</p>
                @if($blogPost->author->email)
                    <small class="text-muted">{{ $blogPost->author->email }}</small>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Action Buttons -->
        <div class="action-buttons">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-cog me-2"></i>
                Actions
            </h6>
            
            <div class="d-grid gap-2">
                <a href="{{ route('admin.blog.edit', $blogPost) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    Edit Post
                </a>
                
                @if($blogPost->status === 'published')
                    <a href="{{ url('/blog/' . $blogPost->slug) }}" target="_blank" class="btn btn-success">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View Live Post
                    </a>
                @endif
                
                <form action="{{ route('admin.blog.toggle-featured', $blogPost) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-{{ $blogPost->is_featured ? 'warning' : 'outline-warning' }} w-100">
                        <i class="fas fa-star me-2"></i>
                        {{ $blogPost->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}
                    </button>
                </form>
                
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash me-2"></i>
                    Delete Post
                </button>
                
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Posts
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-card">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-chart-bar me-2"></i>
                Statistics
            </h6>
            
            <div class="text-center mb-3">
                <div class="stat-number">{{ $blogPost->views_count ?? 0 }}</div>
                <small class="text-muted">Total Views</small>
            </div>
            
            <hr>
            
            <div class="row text-center">
                <div class="col-6">
                    <div class="fw-bold">{{ $blogPost->created_at ? $blogPost->created_at->format('M d') : 'N/A' }}</div>
                    <small class="text-muted">Created</small>
                </div>
                <div class="col-6">
                    <div class="fw-bold">{{ $blogPost->updated_at ? $blogPost->updated_at->format('M d') : 'N/A' }}</div>
                    <small class="text-muted">Updated</small>
                </div>
            </div>
        </div>

        <!-- SEO Info -->
        <div class="stats-card">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-search me-2"></i>
                SEO Information
            </h6>
            
            <div class="mb-2">
                <small class="text-muted">Title Length:</small>
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-{{ strlen($blogPost->title) > 60 ? 'danger' : (strlen($blogPost->title) > 50 ? 'warning' : 'success') }}" 
                         style="width: {{ min(100, (strlen($blogPost->title) / 60) * 100) }}%"></div>
                </div>
                <small class="text-muted">{{ strlen($blogPost->title) }}/60 characters</small>
            </div>
            
            @if($blogPost->excerpt)
            <div class="mb-2">
                <small class="text-muted">Excerpt Length:</small>
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-{{ strlen($blogPost->excerpt) > 160 ? 'danger' : (strlen($blogPost->excerpt) > 140 ? 'warning' : 'success') }}" 
                         style="width: {{ min(100, (strlen($blogPost->excerpt) / 160) * 100) }}%"></div>
                </div>
                <small class="text-muted">{{ strlen($blogPost->excerpt) }}/160 characters</small>
            </div>
            @endif
            
            <div class="mb-2">
                <small class="text-muted">Content Length:</small>
                <div>{{ str_word_count(strip_tags($blogPost->content)) }} words</div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this blog post?</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action cannot be undone. The post "{{ $blogPost->title }}" will be permanently deleted.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit();">
                    <i class="fas fa-trash me-1"></i>
                    Delete Post
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="{{ route('admin.blog.destroy', $blogPost) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    // Delete confirmation
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush