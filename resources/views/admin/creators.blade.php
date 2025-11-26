@extends('admin.layout')

@section('title', 'Creator Management')
@section('page-title', 'Creator Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-palette me-2"></i>
                        All Creators
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>
                                Filter by Category
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.creators') }}">All Categories</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['category' => 'graphic-design']) }}">Graphic
                                        Design</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['category' => 'web-development']) }}">Web
                                        Development</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['category' => 'photography']) }}">Photography</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['category' => 'writing']) }}">Writing</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i>
                                Sort by
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['sort' => 'newest']) }}">Newest First</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['sort' => 'oldest']) }}">Oldest First</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('admin.creators', ['sort' => 'portfolio_count']) }}">Most Portfolio
                                        Items</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.creators', ['sort' => 'name']) }}">Name
                                        A-Z</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
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
                                    <th>Creator</th>
                                    <th>Email</th>
                                    <th>Category</th>
                                    <th>Portfolio Items</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($creators as $creator)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3"
                                                    style="width: 40px; height: 40px; background: var(--success-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                                    {{ strtoupper(substr($creator->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $creator->name }}</strong>
                                                    @if ($creator->creatorProfile && $creator->creatorProfile->bio)
                                                        <br>
                                                        <small
                                                            class="text-muted">{{ Str::limit($creator->creatorProfile->bio, 50) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $creator->email }}</td>
                                        <td>
                                            @if ($creator->creatorProfile && $creator->creatorProfile->talent_category)
                                                <span class="badge bg-info">
                                                    {{ ucfirst(str_replace('-', ' ', $creator->creatorProfile->talent_category)) }}
                                                </span>
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span
                                                    class="badge bg-primary me-2">{{ $creator->portfolio_items_count ?? 0 }}</span>
                                                @if (($creator->portfolio_items_count ?? 0) > 0)
                                                    <a href="#" class="btn btn-sm btn-outline-secondary"
                                                        onclick="viewPortfolio({{ $creator->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $creator->status === 'active' ? 'success' : ($creator->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($creator->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $creator->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if ($creator->creatorProfile)
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                        onclick="viewCreatorDetails({{ $creator->id }})"
                                                        title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                @endif

                                                @if ($creator->status === 'active')
                                                    <form action="{{ route('admin.users.toggle-status', $creator) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning"
                                                            title="Deactivate Creator">
                                                            <i class="fas fa-pause"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.users.toggle-status', $creator) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-success"
                                                            title="Activate Creator">
                                                            <i class="fas fa-play"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-palette fa-3x text-muted mb-3 d-block"></i>
                                            <p class="text-muted">No creators found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($creators->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $creators->links('pagination.bootstrap') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-palette fa-2x text-success mb-2"></i>
                    <h4>{{ number_format($stats['total_creators']) }}</h4>
                    <p class="text-muted mb-0">Total Creators</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-check fa-2x text-primary mb-2"></i>
                    <h4>{{ number_format($stats['active_creators']) }}</h4>
                    <p class="text-muted mb-0">Active Creators</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-images fa-2x text-info mb-2"></i>
                    <h4>{{ number_format($stats['total_portfolio_items']) }}</h4>
                    <p class="text-muted mb-0">Portfolio Items</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                    <h4>{{ number_format($stats['avg_portfolio_per_creator'], 1) }}</h4>
                    <p class="text-muted mb-0">Avg Portfolio/Creator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Creator Details Modal -->
    <div class="modal fade" id="creatorDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user me-2"></i>
                        Creator Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="creatorDetailsContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Modal -->
    <div class="modal fade" id="portfolioModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-images me-2"></i>
                        Portfolio Items
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="portfolioContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function viewCreatorDetails(creatorId) {
            const modal = new bootstrap.Modal(document.getElementById('creatorDetailsModal'));
            const content = document.getElementById('creatorDetailsContent');

            // Show loading spinner
            content.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

            modal.show();

            // Simulate loading creator details (replace with actual AJAX call)
            setTimeout(() => {
                content.innerHTML = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="avatar mb-3" style="width: 100px; height: 100px; background: var(--success-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 36px; margin: 0 auto;">
                            C
                        </div>
                        <h5>Creator Name</h5>
                        <p class="text-muted">creator@example.com</p>
                    </div>
                    <div class="col-md-8">
                        <h6>Bio</h6>
                        <p>Professional graphic designer with 5+ years of experience...</p>

                        <h6>Skills</h6>
                        <div class="mb-3">
                            <span class="badge bg-primary me-1">Photoshop</span>
                            <span class="badge bg-primary me-1">Illustrator</span>
                            <span class="badge bg-primary me-1">InDesign</span>
                        </div>

                        <h6>Contact Information</h6>
                        <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                        <p><i class="fas fa-globe me-2"></i> www.portfolio.com</p>
                    </div>
                </div>
            `;
            }, 1000);
        }

        function viewPortfolio(creatorId) {
            const modal = new bootstrap.Modal(document.getElementById('portfolioModal'));
            const content = document.getElementById('portfolioContent');

            // Show loading spinner
            content.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;

            modal.show();

            // Simulate loading portfolio items (replace with actual AJAX call)
            setTimeout(() => {
                content.innerHTML = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h6>Portfolio Item 1</h6>
                                <p class="text-muted small">Graphic Design</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h6>Portfolio Item 2</h6>
                                <p class="text-muted small">Web Design</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h6>Portfolio Item 3</h6>
                                <p class="text-muted small">Logo Design</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            }, 1000);
        }

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
