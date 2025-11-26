@extends('admin.layout')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h4>{{ number_format($stats['total_users']) }}</h4>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                    <h4>{{ number_format($stats['active_users']) }}</h4>
                    <p class="text-muted mb-0">Active Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-clock fa-2x text-warning mb-2"></i>
                    <h4>{{ number_format($stats['pending_users']) }}</h4>
                    <p class="text-muted mb-0">Pending Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-2x text-info mb-2"></i>
                    <h4>{{ number_format($stats['new_users_today']) }}</h4>
                    <p class="text-muted mb-0">New Today</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        All Users
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        <!-- Create User Button -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createUserModal">
                            <i class="fas fa-plus me-1"></i>
                            Create User
                        </button>
                        <!-- Search Box -->
                        <form method="GET" action="{{ route('admin.users') }}" class="d-flex">
                            <input type="hidden" name="role" value="{{ $filters['role'] ?? '' }}">
                            <input type="hidden" name="status" value="{{ $filters['status'] ?? '' }}">
                            <div class="input-group" style="width: 250px;">
                                <input type="text" class="form-control" name="search" placeholder="Search users..."
                                    value="{{ $filters['search'] ?? '' }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Role Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>
                                @if (isset($filters['role']) && $filters['role'])
                                    {{ ucfirst($filters['role']) }}s
                                @else
                                    Filter by Role
                                @endif
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ !isset($filters['role']) || !$filters['role'] ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['status' => $filters['status'] ?? '', 'search' => $filters['search'] ?? ''])) }}">All
                                        Users</a></li>
                                <li><a class="dropdown-item {{ ($filters['role'] ?? '') === 'admin' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['role' => 'admin', 'status' => $filters['status'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Admins</a>
                                </li>
                                <li><a class="dropdown-item {{ ($filters['role'] ?? '') === 'creator' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['role' => 'creator', 'status' => $filters['status'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Creators</a>
                                </li>
                                <li><a class="dropdown-item {{ ($filters['role'] ?? '') === 'member' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['role' => 'member', 'status' => $filters['status'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Members</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Status Filter -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-sort me-1"></i>
                                @if (isset($filters['status']) && $filters['status'])
                                    {{ ucfirst($filters['status']) }}
                                @else
                                    Filter by Status
                                @endif
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item {{ !isset($filters['status']) || !$filters['status'] ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['role' => $filters['role'] ?? '', 'search' => $filters['search'] ?? ''])) }}">All
                                        Status</a></li>
                                <li><a class="dropdown-item {{ ($filters['status'] ?? '') === 'active' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['status' => 'active', 'role' => $filters['role'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Active</a>
                                </li>
                                <li><a class="dropdown-item {{ ($filters['status'] ?? '') === 'banned' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['status' => 'banned', 'role' => $filters['role'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Banned</a>
                                </li>
                                <li><a class="dropdown-item {{ ($filters['status'] ?? '') === 'pending' ? 'active' : '' }}"
                                        href="{{ route('admin.users', array_filter(['status' => 'pending', 'role' => $filters['role'] ?? '', 'search' => $filters['search'] ?? ''])) }}">Pending</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Clear Filters Button -->
                        @if (($filters['role'] ?? '') || ($filters['status'] ?? '') || ($filters['search'] ?? ''))
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-1"></i>
                                Clear Filters
                            </a>
                        @endif
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-1">User</th>
                                    <th class="py-1">Email</th>
                                    <th class="py-1">Role</th>
                                    <th class="py-1">Status</th>
                                    <th class="py-1">Joined</th>
                                    {{-- <th class="py-1">Last Active</th> --}}
                                    <th class="py-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="py-1">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-2"
                                                    style="width: 28px; height: 28px; border-radius: 50%; overflow: hidden; flex-shrink: 0;">
                                                    @if ($user->avatar)
                                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                                            alt="{{ $user->name }}"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div
                                                            style="width: 100%; height: 100%; background: var(--accent-color); display: flex; align-items: center; justify-content: center; color: white; font-size: 11px;">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-normal" style="font-size: 0.7rem;">{{ $user->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-1" style="font-size: 0.7rem;">{{ $user->email }}</td>
                                        <td class="py-1">
                                            <span
                                                class="badge badge-sm bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'creator' ? 'success' : 'primary') }}"
                                                style="font-size: 0.65rem;">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="py-1">
                                            <span
                                                class="badge badge-sm bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'pending' ? 'warning' : 'secondary') }}"
                                                style="font-size: 0.65rem;">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td class="py-1 text-muted" style="font-size: 0.65rem;">
                                            {{ $user->created_at->format('M d, Y') }}</td>
                                        {{-- <td class="py-1 text-muted" style="font-size: 0.65rem;">
                      @if ($user->last_login_at)
                        {{ $user->last_login_at->diffForHumans() }}
                      @else
                        Never
                      @endif
                    </td> --}}
                                        <td class="py-1">
                                            <div class="d-flex gap-1 flex-wrap" style="justify-content: flex-end">
                                                <!-- Quick Approve Button for Pending Users -->
                                                @if ($user->status === 'pending')
                                                    <button type="button" class="btn btn-xs btn-success"
                                                        onclick="quickApprove({{ $user->id }})" title="Approve User">
                                                        <i class="fas fa-check" style="font-size: 0.6rem;"></i>
                                                    </button>
                                                @endif

                                                <!-- Status Change Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-xs btn-outline-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" title="Change Status">
                                                        <i class="fas fa-user-cog" style="font-size: 0.6rem;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item small" href="#"
                                                                onclick="quickStatusChange({{ $user->id }}, 'active')">
                                                                <i class="fas fa-check text-success me-1"></i>Active</a>
                                                        </li>
                                                        <li><a class="dropdown-item small" href="#"
                                                                onclick="quickStatusChange({{ $user->id }}, 'pending')">
                                                                <i class="fas fa-clock text-warning me-1"></i>Pending</a>
                                                        </li>
                                                        <li><a class="dropdown-item small" href="#"
                                                                onclick="quickStatusChange({{ $user->id }}, 'banned')">
                                                                <i class="fas fa-ban text-danger me-1"></i>Banned</a></li>
                                                    </ul>
                                                </div>

                                                <!-- Reset Password Button -->
                                                <button type="button" class="btn btn-xs btn-outline-warning"
                                                    onclick="resetPassword({{ $user->id }})" title="Reset Password">
                                                    <i class="fas fa-key" style="font-size: 0.6rem;"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-xs btn-outline-primary"
                                                    onclick="editUser({{ $user->id }})" title="Edit User">
                                                    <i class="fas fa-edit" style="font-size: 0.6rem;"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                @if ($user->id !== auth()->id())
                                                    <button type="button" class="btn btn-xs btn-outline-danger"
                                                        onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')"
                                                        title="Delete User">
                                                        <i class="fas fa-trash" style="font-size: 0.6rem;"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                            <p class="text-muted">No users found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div class="text-muted mb-2 mb-md-0">
                                <small>
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                                    {{ $users->total() }} results
                                </small>
                            </div>
                            <div class="pagination-wrapper">
                                {{ $users->appends(request()->query())->links('pagination.bootstrap') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3 border-top mt-4">
                            <small class="text-muted">
                                @if (request()->hasAny(['search', 'role', 'status']))
                                    No users found matching your criteria. <a href="{{ route('admin.users') }}"
                                        class="text-decoration-none">Clear filters</a>
                                @else
                                    No users available
                                @endif
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editUserForm" enctype="multipart/form-data">
                    <div class="modal-body py-3">
                        <input type="hidden" id="editUserId">

                        <!-- User Basic Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editUserName" class="form-label small">Name</label>
                                    <input type="text" class="form-control form-control-sm" id="editUserName"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editUserEmail" class="form-label small">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="editUserEmail"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="mb-2">
                            <label for="editUserAvatar" class="form-label small">Profile Picture</label>
                            <input type="file" class="form-control form-control-sm" id="editUserAvatar"
                                accept="image/jpeg,image/png,image/jpg,image/gif">
                            <div class="text-muted small mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</div>
                            <div id="currentAvatarPreview" class="mt-2" style="display: none;">
                                <img id="currentAvatarImage" src="" alt="Current avatar" class="img-thumbnail"
                                    style="max-width: 80px; max-height: 80px;">
                                <div class="text-muted small">Current profile picture</div>
                            </div>
                        </div>

                        <!-- Featured Video Upload (for Creators only) -->
                        <div class="mb-2" id="editFeaturedVideoField" style="display: none;">
                            <label for="editFeaturedVideo" class="form-label small">Featured Video</label>
                            <input type="file" class="form-control form-control-sm" id="editFeaturedVideo"
                                accept="video/mp4,video/mov,video/avi,video/wmv">
                            <div class="text-muted small mt-1">Max size: 20MB. Formats: MP4, MOV, AVI, WMV</div>
                            <div id="currentVideoPreview" class="mt-2" style="display: none;">
                                <video id="currentVideoElement" controls style="max-width: 200px; max-height: 120px;">
                                    <source id="currentVideoSource" src="" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <div class="text-muted small">Current featured video</div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="edit_youtube_profile_url" class="form-label small">Youtube Video Url</label>
                            <input type="url" class="form-control form-control-sm" id="edit_youtube_profile_url"
                                placeholder="Youtube Video URL">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editUserRole" class="form-label small">Role</label>
                                    <select class="form-select form-select-sm" id="editUserRole" required
                                        onchange="toggleProfileFields()">
                                        <option value="admin">Admin</option>
                                        <option value="creator">Creator</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="editUserStatus" class="form-label small">Status</label>
                                    <select class="form-select form-select-sm" id="editUserStatus" required>
                                        <option value="active">Active</option>
                                        <option value="banned">Banned</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Creator Profile Fields -->
                        <div id="creatorProfileFields" class="mt-3" style="display: none;">
                            <hr class="my-2">
                            <h6 class="mb-2 text-muted">Creator Profile</h6>

                            <div class="mb-2">
                                <label for="editShortBio" class="form-label small">Short Bio</label>
                                <textarea class="form-control form-control-sm" id="editShortBio" rows="2"
                                    placeholder="Brief description of talents and skills"></textarea>
                            </div>

                            <div class="mb-2">
                                <label for="editAboutMe" class="form-label small">About Me</label>
                                <textarea class="form-control form-control-sm" id="editAboutMe" rows="3" placeholder="Detailed description"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editWebsiteUrl" class="form-label small">Website URL</label>
                                        <input type="url" class="form-control form-control-sm" id="editWebsiteUrl"
                                            placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editBannerImage" class="form-label small">Banner Image</label>
                                        <input type="file" class="form-control form-control-sm" id="editBannerImage"
                                            accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="text-muted small mt-1">Max size: 5MB. Formats: JPG, PNG, GIF</div>
                                        <div id="currentBannerPreview" class="mt-2" style="display: none;">
                                            <img id="currentBannerImage" src="" alt="Current banner"
                                                class="img-thumbnail" style="max-width: 120px; max-height: 60px;">
                                            <div class="text-muted small">Current banner image</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="editResumeCv" class="form-label small">Resume/CV URL</label>
                                <input type="url" class="form-control form-control-sm" id="editResumeCv"
                                    placeholder="Resume/CV file URL">
                            </div>

                            <!-- Social Media Links -->
                            <h6 class="mb-2 text-muted mt-3">Social Media</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editFacebookUrl" class="form-label small">Facebook</label>
                                        <input type="url" class="form-control form-control-sm" id="editFacebookUrl"
                                            placeholder="Facebook profile URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editInstagramUrl" class="form-label small">Instagram</label>
                                        <input type="text" class="form-control form-control-sm" id="editInstagramUrl"
                                            placeholder="@username or URL">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editTwitterUrl" class="form-label small">Twitter</label>
                                        <input type="url" class="form-control form-control-sm" id="editTwitterUrl"
                                            placeholder="Twitter profile URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editLinkedinUrl" class="form-label small">LinkedIn</label>
                                        <input type="url" class="form-control form-control-sm" id="editLinkedinUrl"
                                            placeholder="LinkedIn profile URL">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editYoutubeUrl" class="form-label small">YouTube</label>
                                        <input type="url" class="form-control form-control-sm" id="editYoutubeUrl"
                                            placeholder="YouTube channel URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editTiktokUrl" class="form-label small">TikTok</label>
                                        <input type="url" class="form-control form-control-sm" id="editTiktokUrl"
                                            placeholder="TikTok profile URL">
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Settings -->
                            <h6 class="mb-2 text-muted mt-3">Profile Settings</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editIsActive">
                                        <label class="form-check-label small" for="editIsActive">
                                            Profile is Active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editIsFeatured">
                                        <label class="form-check-label small" for="editIsFeatured">
                                            Featured Creator
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editProfileViews" class="form-label small">Profile Views</label>
                                        <input type="number" class="form-control form-control-sm" id="editProfileViews"
                                            min="0" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editTotalLikes" class="form-label small">Total Likes</label>
                                        <input type="number" class="form-control form-control-sm" id="editTotalLikes"
                                            min="0" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Member Profile Fields -->
                        <div id="memberProfileFields" class="mt-3" style="display: none;">
                            <hr class="my-2">
                            <h6 class="mb-2 text-muted">Member Profile</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editFirstName" class="form-label small">First Name</label>
                                        <input type="text" class="form-control form-control-sm" id="editFirstName"
                                            placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="editLastName" class="form-label small">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" id="editLastName"
                                            placeholder="Last name">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="editMemberBio" class="form-label small">Bio</label>
                                <textarea class="form-control form-control-sm" id="editMemberBio" rows="3"
                                    placeholder="Tell us about yourself"></textarea>
                            </div>

                            <div class="mb-2">
                                <label for="editLocation" class="form-label small">Location</label>
                                <input type="text" class="form-control form-control-sm" id="editLocation"
                                    placeholder="City, Country">
                            </div>

                            <div class="mb-2">
                                <label for="editInterests" class="form-label small">Interests</label>
                                <textarea class="form-control form-control-sm" id="editInterests" rows="2"
                                    placeholder="Your interests and hobbies (comma separated)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createUserForm" enctype="multipart/form-data">
                    <div class="modal-body py-3">
                        <!-- Basic User Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="createUserName" class="form-label small">Name</label>
                                    <input type="text" class="form-control form-control-sm" id="createUserName"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="createUserEmail" class="form-label small">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="createUserEmail"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="createUserPassword" class="form-label small">Password</label>
                                    <input type="password" class="form-control form-control-sm" id="createUserPassword"
                                        required minlength="8">
                                    <div class="form-text small">Password must be at least 8 characters long.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="createUserRole" class="form-label small">Role</label>
                                    <select class="form-select form-select-sm" id="createUserRole" required
                                        onchange="toggleCreateProfileFields()">
                                        <option value="">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="creator">Creator</option>
                                        <option value="member">Member</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="createUserStatus" class="form-label small">Status</label>
                            <select class="form-select form-select-sm" id="createUserStatus" required>
                                <option value="">Select Status</option>
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="mb-2">
                            <label for="createUserAvatar" class="form-label small">Profile Picture</label>
                            <input type="file" class="form-control form-control-sm" id="createUserAvatar"
                                accept="image/jpeg,image/png,image/jpg,image/gif">
                            <div class="text-muted small mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</div>
                        </div>

                        <!-- Featured Video Upload (for Creators only) -->
                        <div class="mb-2" id="createFeaturedVideoField" style="display: none;">
                            <label for="createFeaturedVideo" class="form-label small">Featured Video</label>
                            <input type="file" class="form-control form-control-sm" id="createFeaturedVideo"
                                accept="video/mp4,video/mov,video/avi,video/wmv">
                            <div class="text-muted small mt-1">Max size: 20MB. Formats: MP4, MOV, AVI, WMV</div>
                        </div>

                        <div class="mb-2">
                            <label for="youtube_profile_url" class="form-label small">Youtube Video Url</label>
                            <input type="url" class="form-control form-control-sm" id="youtube_profile_url"
                                placeholder="Youtube Video URL">
                        </div>

                        <!-- Creator Profile Fields -->
                        <div id="createCreatorProfileFields" class="mt-3" style="display: none;">
                            <hr class="my-2">
                            <h6 class="mb-2 text-muted">Creator Profile</h6>

                            <div class="mb-2">
                                <label for="createShortBio" class="form-label small">Short Bio</label>
                                <textarea class="form-control form-control-sm" id="createShortBio" rows="2"
                                    placeholder="Brief description of talents and skills"></textarea>
                            </div>

                            <div class="mb-2">
                                <label for="createAboutMe" class="form-label small">About Me</label>
                                <textarea class="form-control form-control-sm" id="createAboutMe" rows="3" placeholder="Detailed description"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createWebsiteUrl" class="form-label small">Website URL</label>
                                        <input type="url" class="form-control form-control-sm" id="createWebsiteUrl"
                                            placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createBannerImage" class="form-label small">Banner Image</label>
                                        <input type="file" class="form-control form-control-sm" id="createBannerImage"
                                            accept="image/jpeg,image/png,image/jpg,image/gif">
                                        <div class="text-muted small mt-1">Max size: 5MB. Formats: JPG, PNG, GIF</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="createResumeCv" class="form-label small">Resume/CV URL</label>
                                <input type="url" class="form-control form-control-sm" id="createResumeCv"
                                    placeholder="Resume/CV file URL">
                            </div>

                            <!-- Social Media Links -->
                            <h6 class="mb-2 text-muted mt-3">Social Media</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createFacebookUrl" class="form-label small">Facebook</label>
                                        <input type="url" class="form-control form-control-sm" id="createFacebookUrl"
                                            placeholder="Facebook profile URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createInstagramUrl" class="form-label small">Instagram</label>
                                        <input type="text" class="form-control form-control-sm"
                                            id="createInstagramUrl" placeholder="@username or URL">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createTwitterUrl" class="form-label small">Twitter</label>
                                        <input type="url" class="form-control form-control-sm" id="createTwitterUrl"
                                            placeholder="Twitter profile URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createLinkedinUrl" class="form-label small">LinkedIn</label>
                                        <input type="url" class="form-control form-control-sm" id="createLinkedinUrl"
                                            placeholder="LinkedIn profile URL">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createYoutubeUrl" class="form-label small">YouTube</label>
                                        <input type="url" class="form-control form-control-sm" id="createYoutubeUrl"
                                            placeholder="YouTube channel URL">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createTiktokUrl" class="form-label small">TikTok</label>
                                        <input type="url" class="form-control form-control-sm" id="createTiktokUrl"
                                            placeholder="TikTok profile URL">
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Settings -->
                            <h6 class="mb-2 text-muted mt-3">Profile Settings</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="createIsActive" checked>
                                        <label class="form-check-label small" for="createIsActive">
                                            Profile is Active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="createIsFeatured">
                                        <label class="form-check-label small" for="createIsFeatured">
                                            Featured Creator
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Member Profile Fields -->
                        <div id="createMemberProfileFields" class="mt-3" style="display: none;">
                            <hr class="my-2">
                            <h6 class="mb-2 text-muted">Member Profile</h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createFirstName" class="form-label small">First Name</label>
                                        <input type="text" class="form-control form-control-sm" id="createFirstName"
                                            placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="createLastName" class="form-label small">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" id="createLastName"
                                            placeholder="Last name">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="createMemberBio" class="form-label small">Bio</label>
                                <textarea class="form-control form-control-sm" id="createMemberBio" rows="3"
                                    placeholder="Tell us about yourself"></textarea>
                            </div>

                            <div class="mb-2">
                                <label for="createLocation" class="form-label small">Location</label>
                                <input type="text" class="form-control form-control-sm" id="createLocation"
                                    placeholder="City, Country">
                            </div>

                            <div class="mb-2">
                                <label for="createInterests" class="form-label small">Interests</label>
                                <textarea class="form-control form-control-sm" id="createInterests" rows="2"
                                    placeholder="Your interests and hobbies (comma separated)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function editUser(id) {
            // Fetch user data including profile information
            fetch(`/admin/users/${id}/edit`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const user = data.user;

                        // Set basic user data
                        document.getElementById('editUserId').value = user.id;
                        document.getElementById('editUserName').value = user.name;
                        document.getElementById('editUserEmail').value = user.email;
                        document.getElementById('editUserRole').value = user.role;
                        document.getElementById('editUserStatus').value = user.status;

                        // Show current avatar preview if exists
                        if (user.avatar) {
                            document.getElementById('currentAvatarImage').src = '/storage/' + user.avatar;
                            document.getElementById('currentAvatarPreview').style.display = 'block';
                        } else {
                            document.getElementById('currentAvatarPreview').style.display = 'none';
                        }

                        // Show current featured video preview if exists
                        if (user.featured_video) {
                            document.getElementById('currentVideoSource').src = '/storage/' + user.featured_video;
                            document.getElementById('currentVideoElement').load();
                            document.getElementById('currentVideoPreview').style.display = 'block';
                        } else {
                            document.getElementById('currentVideoPreview').style.display = 'none';
                        }

                        // Reset creator profile fields first
                        document.getElementById('edit_youtube_profile_url').value = '';
                        document.getElementById('editShortBio').value = '';
                        document.getElementById('editAboutMe').value = '';
                        document.getElementById('editWebsiteUrl').value = '';
                        document.getElementById('editBannerImage').value = '';
                        document.getElementById('editResumeCv').value = '';
                        document.getElementById('editFacebookUrl').value = '';
                        document.getElementById('editInstagramUrl').value = '';
                        document.getElementById('editTwitterUrl').value = '';
                        document.getElementById('editLinkedinUrl').value = '';
                        document.getElementById('editYoutubeUrl').value = '';
                        document.getElementById('editTiktokUrl').value = '';
                        document.getElementById('editIsActive').checked = false;
                        document.getElementById('editIsFeatured').checked = false;
                        document.getElementById('editProfileViews').value = 0;
                        document.getElementById('editTotalLikes').value = 0;

                        // Set creator profile data if exists
                        if (user.creator_profile) {
                            const profile = user.creator_profile;
                            document.getElementById('editShortBio').value = profile.short_bio || '';
                            document.getElementById('edit_youtube_profile_url').value = profile.youtube_profile_url ||
                                '';
                            document.getElementById('editAboutMe').value = profile.about_me || '';
                            document.getElementById('editWebsiteUrl').value = profile.website_url || '';
                            document.getElementById('editResumeCv').value = profile.resume_cv || '';

                            // Show current banner image preview if exists
                            if (profile.banner_image) {
                                document.getElementById('currentBannerImage').src = '/storage/' + profile.banner_image;
                                document.getElementById('currentBannerPreview').style.display = 'block';
                            } else {
                                document.getElementById('currentBannerPreview').style.display = 'none';
                            }
                            document.getElementById('editFacebookUrl').value = profile.facebook_url || '';
                            document.getElementById('editInstagramUrl').value = profile.instagram_url || '';
                            document.getElementById('editTwitterUrl').value = profile.twitter_url || '';
                            document.getElementById('editLinkedinUrl').value = profile.linkedin_url || '';
                            document.getElementById('editYoutubeUrl').value = profile.youtube_url || '';
                            document.getElementById('editTiktokUrl').value = profile.tiktok_url || '';
                            document.getElementById('editIsActive').checked = profile.is_active;
                            document.getElementById('editIsFeatured').checked = profile.is_featured;
                            document.getElementById('editProfileViews').value = profile.profile_views || 0;
                            document.getElementById('editTotalLikes').value = profile.total_likes || 0;
                        }

                        // Reset member profile fields first
                        document.getElementById('editFirstName').value = '';
                        document.getElementById('editLastName').value = '';
                        document.getElementById('editMemberBio').value = '';
                        document.getElementById('editLocation').value = '';
                        document.getElementById('editInterests').value = '';

                        // Set member profile data if exists
                        if (user.member_profile) {
                            const profile = user.member_profile;
                            document.getElementById('editFirstName').value = profile.first_name || '';
                            document.getElementById('editLastName').value = profile.last_name || '';
                            document.getElementById('editMemberBio').value = profile.bio || '';
                            document.getElementById('editLocation').value = profile.location || '';
                            document.getElementById('editInterests').value = profile.interests || '';
                        }

                        // Show/hide profile fields based on role
                        toggleProfileFields();

                        // Show modal
                        new bootstrap.Modal(document.getElementById('editUserModal')).show();
                    } else {
                        alert(data.message || 'Error loading user data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading user data');
                });
        }

        function toggleProfileFields() {
            const role = document.getElementById('editUserRole').value;
            const creatorFields = document.getElementById('creatorProfileFields');
            const memberFields = document.getElementById('memberProfileFields');
            const featuredVideoField = document.getElementById('editFeaturedVideoField');

            if (role === 'creator') {
                creatorFields.style.display = 'block';
                memberFields.style.display = 'none';
                featuredVideoField.style.display = 'block';
            } else if (role === 'member') {
                creatorFields.style.display = 'none';
                memberFields.style.display = 'block';
                featuredVideoField.style.display = 'none';
            } else {
                creatorFields.style.display = 'none';
                memberFields.style.display = 'none';
                featuredVideoField.style.display = 'none';
            }
        }

        function toggleCreateProfileFields() {
            const role = document.getElementById('createUserRole').value;
            const creatorFields = document.getElementById('createCreatorProfileFields');
            const memberFields = document.getElementById('createMemberProfileFields');
            const featuredVideoField = document.getElementById('createFeaturedVideoField');

            if (role === 'creator') {
                creatorFields.style.display = 'block';
                memberFields.style.display = 'none';
                featuredVideoField.style.display = 'block';
            } else if (role === 'member') {
                creatorFields.style.display = 'none';
                memberFields.style.display = 'block';
                featuredVideoField.style.display = 'none';
            } else {
                creatorFields.style.display = 'none';
                memberFields.style.display = 'none';
                featuredVideoField.style.display = 'none';
            }
        }

        function quickApprove(userId) {
            if (confirm('Are you sure you want to approve this user?')) {
                quickStatusChange(userId, 'active');
            }
        }

        function quickStatusChange(userId, status) {
            fetch(`/admin/users/${userId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error updating user status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating user status');
                });
        }

        function resetPassword(userId) {
            if (confirm(
                    'Are you sure you want to reset this user\'s password? A new password will be generated and sent to their email.'
                )) {
                fetch(`/admin/users/${userId}/reset-password`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Password reset successfully. New password has been sent to the user\'s email.');
                        } else {
                            alert(data.message || 'Error resetting password');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error resetting password');
                    });
            }
        }

        function deleteUser(id, name) {
            if (confirm(`Are you sure you want to delete user "${name}"? This action cannot be undone.`)) {
                fetch(`/admin/users/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Error deleting user');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting user');
                    });
            }
        }

        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Add confirmation dialog
            if (!confirm('Are you sure you want to update this user?')) {
                return;
            }

            const userId = document.getElementById('editUserId').value;
            const role = document.getElementById('editUserRole').value;

            const formData = {
                name: document.getElementById('editUserName').value,
                email: document.getElementById('editUserEmail').value,
                role: role,
                status: document.getElementById('editUserStatus').value
            };

            // Add creator profile data if role is creator
            if (role === 'creator') {
                formData.creator_profile = {
                    short_bio: document.getElementById('editShortBio').value,
                    youtube_profile_url: document.getElementById('edit_youtube_profile_url').value,
                    about_me: document.getElementById('editAboutMe').value,
                    website_url: document.getElementById('editWebsiteUrl').value,
                    resume_cv: document.getElementById('editResumeCv').value,
                    facebook_url: document.getElementById('editFacebookUrl').value,
                    instagram_url: document.getElementById('editInstagramUrl').value,
                    twitter_url: document.getElementById('editTwitterUrl').value,
                    linkedin_url: document.getElementById('editLinkedinUrl').value,
                    youtube_url: document.getElementById('editYoutubeUrl').value,
                    tiktok_url: document.getElementById('editTiktokUrl').value,
                    is_active: document.getElementById('editIsActive').checked,
                    is_featured: document.getElementById('editIsFeatured').checked,
                    profile_views: parseInt(document.getElementById('editProfileViews').value) || 0,
                    total_likes: parseInt(document.getElementById('editTotalLikes').value) || 0
                };
            }

            // Add member profile data if role is member
            if (role === 'member') {
                formData.member_profile = {
                    first_name: document.getElementById('editFirstName').value,
                    last_name: document.getElementById('editLastName').value,
                    bio: document.getElementById('editMemberBio').value,
                    location: document.getElementById('editLocation').value,
                    interests: document.getElementById('editInterests').value
                };
            }

            // Create FormData for file uploads
            const formDataObj = new FormData();

            // Add basic fields
            formDataObj.append('name', formData.name);
            formDataObj.append('email', formData.email);
            formDataObj.append('role', formData.role);
            formDataObj.append('status', formData.status);
            formDataObj.append('_method', 'PUT');

            // Add avatar file if selected
            const avatarFile = document.getElementById('editUserAvatar').files[0];
            if (avatarFile) {
                formDataObj.append('avatar', avatarFile);
            }

            // Add banner image if selected (for creators)
            const bannerFile = document.getElementById('editBannerImage').files[0];
            if (bannerFile) {
                formDataObj.append('banner_image', bannerFile);
            }

            // Add featured video if selected (for creators)
            const featuredVideoFile = document.getElementById('editFeaturedVideo').files[0];
            if (featuredVideoFile) {
                formDataObj.append('featured_video', featuredVideoFile);
            }

            // Add creator profile data if applicable
            if (formData.creator_profile) {
                Object.keys(formData.creator_profile).forEach(key => {
                    let value = formData.creator_profile[key];
                    // Convert boolean values to integers for MySQL
                    if (typeof value === 'boolean') {
                        value = value ? 1 : 0;
                    }
                    formDataObj.append(`creator_profile[${key}]`, value);
                });
            }

            // Add member profile data if applicable
            if (formData.member_profile) {
                Object.keys(formData.member_profile).forEach(key => {
                    formDataObj.append(`member_profile[${key}]`, formData.member_profile[key]);
                });
            }

            fetch(`/admin/users/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    },
                    body: formDataObj
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success alert
                        alert('User updated successfully!');
                        bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
                        location.reload();
                    } else {
                        alert(data.message || 'Error updating user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating user');
                });
        });

        // Handle create user form submission
        document.getElementById('createUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Add confirmation dialog
            if (!confirm('Are you sure you want to create this user?')) {
                return;
            }

            const role = document.getElementById('createUserRole').value;

            const formData = {
                name: document.getElementById('createUserName').value,
                email: document.getElementById('createUserEmail').value,
                password: document.getElementById('createUserPassword').value,
                role: role,
                status: document.getElementById('createUserStatus').value
            };

            // Add creator profile data if role is creator
            if (role === 'creator') {
                formData.creator_profile = {
                    youtube_profile_url: document.getElementById('youtube_profile_url').value,
                    short_bio: document.getElementById('createShortBio').value,
                    about_me: document.getElementById('createAboutMe').value,
                    website_url: document.getElementById('createWebsiteUrl').value,
                    banner_image: document.getElementById('createBannerImage').value,
                    resume_cv: document.getElementById('createResumeCv').value,
                    facebook_url: document.getElementById('createFacebookUrl').value,
                    instagram_url: document.getElementById('createInstagramUrl').value,
                    twitter_url: document.getElementById('createTwitterUrl').value,
                    linkedin_url: document.getElementById('createLinkedinUrl').value,
                    youtube_url: document.getElementById('createYoutubeUrl').value,
                    tiktok_url: document.getElementById('createTiktokUrl').value,
                    is_active: document.getElementById('createIsActive').checked,
                    is_featured: document.getElementById('createIsFeatured').checked,
                    profile_views: 0,
                    total_likes: 0
                };
            }

            // Add member profile data if role is member
            if (role === 'member') {
                formData.member_profile = {
                    first_name: document.getElementById('createFirstName').value,
                    last_name: document.getElementById('createLastName').value,
                    bio: document.getElementById('createMemberBio').value,
                    location: document.getElementById('createLocation').value,
                    interests: document.getElementById('createInterests').value
                };
            }

            // Create FormData for file uploads
            const formDataObj = new FormData();

            // Add basic fields
            formDataObj.append('name', formData.name);
            formDataObj.append('email', formData.email);
            formDataObj.append('password', formData.password);
            formDataObj.append('role', formData.role);
            formDataObj.append('status', formData.status);

            // Add avatar file if selected
            const avatarFile = document.getElementById('createUserAvatar').files[0];
            if (avatarFile) {
                formDataObj.append('avatar', avatarFile);
            }

            // Add banner image if selected (for creators)
            const bannerFile = document.getElementById('createBannerImage').files[0];
            if (bannerFile) {
                formDataObj.append('banner_image', bannerFile);
            }

            // Add featured video if selected (for creators)
            const featuredVideoFile = document.getElementById('createFeaturedVideo').files[0];
            if (featuredVideoFile) {
                formDataObj.append('featured_video', featuredVideoFile);
            }

            // Add creator profile data if applicable
            if (formData.creator_profile) {
                Object.keys(formData.creator_profile).forEach(key => {
                    let value = formData.creator_profile[key];
                    // Convert boolean values to integers for MySQL
                    if (typeof value === 'boolean') {
                        value = value ? 1 : 0;
                    }
                    formDataObj.append(`creator_profile[${key}]`, value);
                });
            }

            // Add member profile data if applicable
            if (formData.member_profile) {
                Object.keys(formData.member_profile).forEach(key => {
                    formDataObj.append(`member_profile[${key}]`, formData.member_profile[key]);
                });
            }

            fetch('/admin/users', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    },
                    body: formDataObj
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success alert
                        alert('User created successfully!');
                        bootstrap.Modal.getInstance(document.getElementById('createUserModal')).hide();
                        // Reset form
                        document.getElementById('createUserForm').reset();
                        // Hide profile fields
                        document.getElementById('createCreatorProfileFields').style.display = 'none';
                        document.getElementById('createMemberProfileFields').style.display = 'none';
                        document.getElementById('createFeaturedVideoField').style.display = 'none';
                        location.reload();
                    } else {
                        alert(data.message || 'Error creating user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error creating user');
                });
        });

        // Image preview functionality
        document.getElementById('editUserAvatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('currentAvatarPreview');
            const image = document.getElementById('currentAvatarImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('editBannerImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('currentBannerPreview');
            const image = document.getElementById('currentBannerImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
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

@push('styles')
    <style>
        .dropdown-item.active {
            background-color: #0d6efd;
            color: white;
        }

        .dropdown-item.active:hover {
            background-color: #0b5ed7;
            color: white;
        }

        .input-group .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .card-header .d-flex {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Custom Pagination Styling */
        .pagination-wrapper .pagination {
            margin-bottom: 0;
            gap: 2px;
        }

        .pagination-wrapper .page-link {
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem !important;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .pagination-wrapper .page-link:hover {
            color: #0d6efd;
            background-color: #e9ecef;
            border-color: #adb5bd;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination-wrapper .page-item.active .page-link {
            color: #fff !important;
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.3);
            font-weight: 500;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: #adb5bd !important;
            background-color: #fff !important;
            border-color: #dee2e6 !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .pagination-wrapper .page-item:first-child .page-link,
        .pagination-wrapper .page-item:last-child .page-link {
            font-weight: 500;
        }

        /* Remove default Bootstrap pagination margins */
        .pagination-wrapper .page-item {
            margin: 0;
        }

        .pagination-wrapper .page-item:not(:first-child) .page-link {
            margin-left: 0;
        }

        /* Responsive pagination */
        @media (max-width: 576px) {
            .pagination-wrapper .page-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.8rem;
            }

            .pagination-wrapper .pagination {
                justify-content: center;
                gap: 1px;
            }

            .pagination-wrapper .page-link .d-none {
                display: none !important;
            }
        }

        /* Border top styling */
        .border-top {
            border-top: 1px solid #e9ecef !important;
        }

        /* Custom button sizes */
        .btn-xs {
            padding: 0.1rem 0.2rem;
            font-size: 0.55rem;
            line-height: 1.1;
            border-radius: 0.15rem;
        }

        .badge-sm {
            font-size: 0.6rem;
            padding: 0.2em 0.4em;
        }

        /* Compact table */
        .table-sm th,
        .table-sm td {
            padding: 0.3rem 0.4rem;
            vertical-align: middle;
        }

        .table-sm th {
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Compact modal */
        .modal-dialog {
            margin: 1rem auto;
        }

        .modal-header,
        .modal-footer {
            padding: 0.75rem 1rem;
        }

        .modal-body {
            padding: 1rem;
        }

        /* Form control sizes */
        .form-control-sm,
        .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            font-size: 0.85rem;
            min-width: 8rem;
        }

        .dropdown-item {
            padding: 0.25rem 0.75rem;
        }

        .dropdown-item.small {
            font-size: 0.8rem;
        }

        /* Action buttons container */
        .d-flex.gap-1 {
            gap: 0.25rem !important;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .card-header .d-flex>* {
                width: 100%;
            }

            .input-group {
                width: 100% !important;
            }

            .btn-xs {
                padding: 0.2rem 0.3rem;
                font-size: 0.65rem;
            }

            .modal-dialog.modal-lg {
                margin: 0.5rem;
                max-width: none;
            }
        }

        /* Statistics cards compact */
        .card-body {
            padding: 1rem;
        }

        .card-body h4 {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .card-body p {
            font-size: 0.85rem;
        }

        .card-body i {
            font-size: 1rem !important;
        }
    </style>
@endpush
