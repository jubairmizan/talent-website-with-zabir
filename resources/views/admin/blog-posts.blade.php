@extends('admin.layout')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts Management')

@push('styles')
<style>
    .stats-cards {
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        border: none;
    }
    .stat-card.success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    }
    .stat-card.warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .stat-card.info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .search-filters {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .table-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .post-thumbnail {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
    }
    .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .action-btn {
        padding: 0.25rem 0.5rem;
        margin: 0 0.1rem;
        border-radius: 5px;
        font-size: 0.8rem;
    }
    .bulk-actions {
        background: #e3f2fd;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
    }
</style>
@endpush

@section('content')
<!-- Statistics Cards -->
<div class="row stats-cards">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
            <div>Total Posts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card success">
            <div class="stat-number">{{ $stats['published'] ?? 0 }}</div>
            <div>Published</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card warning">
            <div class="stat-number">{{ $stats['draft'] ?? 0 }}</div>
            <div>Drafts</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card info">
            <div class="stat-number">{{ $stats['pending'] ?? 0 }}</div>
            <div>Pending</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Search and Filters -->
        <div class="search-filters">
            <form method="GET" action="{{ route('admin.blog.index') }}" id="filterForm">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search Posts</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search by title, content, or author...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="updated_at" {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Updated Date</option>
                            <option value="published_at" {{ request('sort') === 'published_at' ? 'selected' : '' }}>Published Date</option>
                            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                            <option value="views_count" {{ request('sort') === 'views_count' ? 'selected' : '' }}>Views</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-1"></i>
                                Filter
                            </button>
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-blog me-2"></i>
                    Blog Posts
                    @if($blogPosts->total() > 0)
                        <span class="badge bg-primary ms-2">{{ $blogPosts->total() }}</span>
                    @endif
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        New Post
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Post</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Published</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogPosts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start">
                                        <div class="me-3" style="width: 60px; height: 45px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1px solid #dee2e6;">
                                            @if($post->featured_image)
                                                <img src="{{ $post->featured_image }}" alt="Featured" style="width: 100%; height: 100%; object-fit: cover; border-radius: 7px;">
                                            @else
                                                <i class="fas fa-image text-muted"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <strong>{{ Str::limit($post->title, 50) }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 80) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($post->author && $post->author->avatar)
                                            <img src="{{ asset('storage/' . $post->author->avatar) }}" alt="Author" class="author-avatar me-2">
                                        @else
                                            <div class="author-avatar me-2 bg-primary d-flex align-items-center justify-content-center text-white">
                                                {{ $post->author ? strtoupper(substr($post->author->name, 0, 1)) : 'U' }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $post->author->name ?? 'Unknown' }}</div>
                                            <small class="text-muted">{{ $post->author ? ucfirst($post->author->role) : 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                </td>
                                <td>
                                    <span class="status-badge bg-{{ $post->status === 'published' ? 'success' : ($post->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $post->views_count ?? 0 }}</span>
                                </td>
                                <td>
                                    @if($post->published_at)
                                        <span title="{{ $post->published_at->format('M d, Y \a\t g:i A') }}">
                                            {{ $post->published_at->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">Not published</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.blog.show', $post) }}" class="btn btn-sm btn-outline-info action-btn" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-outline-primary action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger action-btn" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($blogPosts->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $blogPosts->firstItem() }} to {{ $blogPosts->lastItem() }} of {{ $blogPosts->total() }} results
                        </div>
                        <div>
                            {{ $blogPosts->appends(request()->query())->links('pagination.bootstrap') }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No blog posts found</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'status', 'category']))
                            Try adjusting your search criteria or <a href="{{ route('admin.blog.index') }}">clear filters</a>.
                        @else
                            Get started by creating your first blog post.
                        @endif
                    </p>
                    @if(!request()->hasAny(['search', 'status', 'category']))
                        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Create First Post
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <input type="hidden" name="post_ids" id="bulkPostIds">
</form>
@endsection

@push('scripts')
<script>
    // Select All functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.post-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    document.querySelectorAll('.post-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActions();
            
            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.post-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
            const selectAllCheckbox = document.getElementById('selectAll');
            
            if (checkedCheckboxes.length === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (checkedCheckboxes.length === allCheckboxes.length) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        });
    });

    // Update bulk actions visibility and count
    function updateBulkActions() {
        const checkedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        
        if (checkedCheckboxes.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = `${checkedCheckboxes.length} post${checkedCheckboxes.length > 1 ? 's' : ''} selected`;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    // Bulk action handler
    function bulkAction(action) {
        const checkedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
        
        if (checkedCheckboxes.length === 0) {
            alert('Please select at least one post.');
            return;
        }

        let confirmMessage = '';
        switch (action) {
            case 'publish':
                confirmMessage = `Are you sure you want to publish ${checkedCheckboxes.length} post(s)?`;
                break;
            case 'draft':
                confirmMessage = `Are you sure you want to move ${checkedCheckboxes.length} post(s) to draft?`;
                break;
            case 'delete':
                confirmMessage = `Are you sure you want to delete ${checkedCheckboxes.length} post(s)? This action cannot be undone.`;
                break;
        }

        if (confirm(confirmMessage)) {
            const postIds = Array.from(checkedCheckboxes).map(cb => cb.value);
            
            document.getElementById('bulkActionType').value = action;
            document.getElementById('bulkPostIds').value = JSON.stringify(postIds);
            
            const form = document.getElementById('bulkActionForm');
            form.action = '{{ route("admin.blog.bulk-action") }}';
            form.submit();
        }
    }

    // Auto-submit filter form on change
    document.querySelectorAll('#status, #category, #sort').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Search with debounce
    let searchTimeout;
    document.getElementById('search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });

    // Auto-hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush