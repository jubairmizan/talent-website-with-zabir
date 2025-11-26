@extends('admin.layout')

@section('title', 'Blog Management')
@section('page-title', 'Blog Posts Management')

@push('styles')
  <style>
    .blog-stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 15px;
      transition: transform 0.3s ease;
    }

    .blog-stats-card:hover {
      transform: translateY(-5px);
    }

    .blog-image-preview {
      width: 60px;
      height: 45px;
      background: #f8f9fa;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #dee2e6;
      overflow: hidden;
    }

    .blog-image-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 7px;
    }

    .status-badge {
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
      border-radius: 20px;
    }

    .bulk-actions {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 1rem;
      margin-bottom: 1rem;
      display: none;
    }

    .bulk-actions.show {
      display: block;
    }
  </style>
@endpush

@section('content')
  <!-- Statistics Cards -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card blog-stats-card text-center">
        <div class="card-body">
          <i class="fas fa-blog fa-2x mb-2"></i>
          <h4>{{ number_format($stats['total']) }}</h4>
          <p class="mb-0">Total Posts</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; border-radius: 15px;">
        <div class="card-body">
          <i class="fas fa-eye fa-2x mb-2"></i>
          <h4>{{ number_format($stats['published']) }}</h4>
          <p class="mb-0">Published</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333; border: none; border-radius: 15px;">
        <div class="card-body">
          <i class="fas fa-edit fa-2x mb-2"></i>
          <h4>{{ number_format($stats['draft']) }}</h4>
          <p class="mb-0">Drafts</p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; border: none; border-radius: 15px;">
        <div class="card-body">
          <i class="fas fa-clock fa-2x mb-2"></i>
          <h4>{{ number_format($stats['pending']) }}</h4>
          <p class="mb-0">Pending</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-blog me-2"></i>
            All Blog Posts
          </h5>
          <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            New Post
          </a>
        </div>
        <div class="card-body">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          @endif

          <!-- Search and Filter Form -->
          <form method="GET" action="{{ route('admin.blog.index') }}" class="mb-4">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                  <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search posts...">
                </div>
              </div>
              <div class="col-md-2">
                <select name="status" class="form-select">
                  <option value="">All Status</option>
                  @foreach ($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                      {{ ucfirst($status) }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select name="category" class="form-select">
                  <option value="">All Categories</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <select name="author" class="form-select">
                  <option value="">All Authors</option>
                  @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                      {{ $author->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-filter"></i>
                  </button>
                  <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                  </a>
                </div>
              </div>
            </div>
          </form>

          <!-- Bulk Actions -->
          <div class="bulk-actions" id="bulkActions">
            <form id="bulkActionForm" method="POST" action="{{ route('admin.blog.bulk-action') }}">
              @csrf
              <div class="row align-items-center">
                <div class="col-md-6">
                  <span class="fw-bold">Bulk Actions:</span>
                  <span id="selectedCount">0</span> posts selected
                </div>
                <div class="col-md-6 text-end">
                  <select name="action" class="form-select d-inline-block w-auto me-2" required>
                    <option value="">Choose Action</option>
                    <option value="publish">Publish</option>
                    <option value="draft">Move to Draft</option>
                    <option value="archive">Archive</option>
                    <option value="delete">Delete</option>
                  </select>
                  <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                  <button type="button" class="btn btn-secondary btn-sm" onclick="clearSelection()">Cancel</button>
                </div>
              </div>
            </form>
          </div>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th width="40">
                    <input type="checkbox" id="selectAll" class="form-check-input">
                  </th>
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
                      <input type="checkbox" name="selected_posts[]" value="{{ $post->id }}" class="form-check-input post-checkbox">
                    </td>
                    <td>
                      <div class="d-flex align-items-start">
                        <div class="blog-image-preview me-3">
                          @if ($post->featured_image)
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured">
                          @else
                            <i class="fas fa-image text-muted"></i>
                          @endif
                        </div>
                        <div>
                          <strong>{{ Str::limit($post->title, 50) }}</strong>
                          @if ($post->is_featured)
                            <span class="badge bg-warning ms-1">Featured</span>
                          @endif
                          <br>
                          <small class="text-muted">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 80) }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="avatar me-2" style="width: 32px; height: 32px; background: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                          {{ strtoupper(substr($post->author->name, 0, 1)) }}
                        </div>
                        <div>
                          <small>{{ $post->author->name }}</small>
                          <br>
                          <small class="text-muted">{{ $post->author->role }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-info">{{ $post->category->name }}</span>
                    </td>
                    <td>
                      @switch($post->status)
                        @case('published')
                          <span class="status-badge bg-success text-white">Published</span>
                        @break

                        @case('draft')
                          <span class="status-badge bg-secondary text-white">Draft</span>
                        @break

                        @case('pending')
                          <span class="status-badge bg-warning text-dark">Pending</span>
                        @break

                        @case('archived')
                          <span class="status-badge bg-dark text-white">Archived</span>
                        @break
                      @endswitch
                    </td>
                    <td>
                      <i class="fas fa-eye text-muted me-1"></i>
                      {{ number_format($post->views_count) }}
                    </td>
                    <td>
                      @if ($post->published_at)
                        {{ $post->published_at->format('M d, Y') }}
                        <br>
                        <small class="text-muted">{{ $post->published_at->diffForHumans() }}</small>
                      @else
                        <span class="text-muted">Not published</span>
                      @endif
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.blog.show', $post) }}" class="btn btn-sm btn-outline-info" title="View">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.blog.toggle-featured', $post) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm btn-outline-warning" title="{{ $post->is_featured ? 'Unfeature' : 'Feature' }}">
                            <i class="fas fa-star{{ $post->is_featured ? '' : '-o' }}"></i>
                          </button>
                        </form>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $post->id }}, '{{ addslashes($post->title) }}')" title="Delete">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-center py-4">
                        <i class="fas fa-blog fa-3x text-muted mb-3 d-block"></i>
                        <p class="text-muted">No blog posts found</p>
                        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                          <i class="fas fa-plus me-1"></i>
                          Create Your First Post
                        </a>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            @if ($blogPosts->hasPages())
              <div class="d-flex justify-content-center mt-4">
                {{ $blogPosts->links('pagination.bootstrap') }}
              </div>
            @endif
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
            <p>Are you sure you want to delete the blog post <strong id="deletePostTitle"></strong>?</p>
            <p class="text-danger">
              <i class="fas fa-warning me-1"></i>
              This action cannot be undone and will permanently remove the post and its featured image.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form id="deleteForm" method="POST" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-1"></i>
                Delete Post
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endsection

  @push('scripts')
    <script>
      // Select all functionality
      document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.post-checkbox');
        checkboxes.forEach(checkbox => {
          checkbox.checked = this.checked;
        });
        updateBulkActions();
      });

      // Individual checkbox functionality
      document.querySelectorAll('.post-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
      });

      function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.post-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        if (checkedBoxes.length > 0) {
          bulkActions.classList.add('show');
          selectedCount.textContent = checkedBoxes.length;

          // Update hidden inputs for bulk action form
          const form = document.getElementById('bulkActionForm');
          const existingInputs = form.querySelectorAll('input[name="selected_posts[]"]');
          existingInputs.forEach(input => input.remove());

          checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_posts[]';
            input.value = checkbox.value;
            form.appendChild(input);
          });
        } else {
          bulkActions.classList.remove('show');
        }
      }

      function clearSelection() {
        document.querySelectorAll('.post-checkbox').forEach(checkbox => {
          checkbox.checked = false;
        });
        document.getElementById('selectAll').checked = false;
        updateBulkActions();
      }

      function confirmDelete(postId, postTitle) {
        document.getElementById('deletePostTitle').textContent = postTitle;
        document.getElementById('deleteForm').action = `/admin/blog/${postId}`;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
      }

      // Bulk action form confirmation
      document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
        const action = this.querySelector('select[name="action"]').value;
        if (action === 'delete') {
          if (!confirm('Are you sure you want to delete the selected posts? This action cannot be undone.')) {
            e.preventDefault();
          }
        }
      });

      // Auto-hide alerts after 5 seconds
      setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        });
      }, 5000);
    </script>
  @endpush
