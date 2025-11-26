@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@push('styles')
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --warning-color: #d97706;
            --danger-color: #dc2626;
            --info-color: #0891b2;
            --dark-color: #1e293b;
            --light-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --card-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-primary);
        }

        .dashboard-container {
            animation: fadeInUp 0.6s ease-out;
            padding: 2rem 1.5rem;
            background: var(--bg-color);
            min-height: 100vh;
        }

        @media (min-width: 768px) {
            .dashboard-container {
                padding: 2.5rem 2rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        /* Modern Stats Cards */
        .modern-stats-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            height: 160px;
        }

        .modern-stats-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header-accent {
            height: 4px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: height 0.3s ease;
        }

        .modern-stats-card:hover .card-header-accent {
            height: 6px;
        }

        .blue-accent {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .green-accent {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .orange-accent {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .red-accent {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .card-content {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            height: calc(100% - 40px);
        }

        .icon-container {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .blue-icon {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1d4ed8;
        }

        .green-icon {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        .orange-icon {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #d97706;
        }

        .red-icon {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        .icon-container i {
            font-size: 24px;
            font-weight: 600;
        }

        .modern-stats-card:hover .icon-container {
            transform: scale(1.1) rotate(5deg);
        }

        .stats-info {
            flex: 1;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: #1e293b;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .stats-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .trend-indicator {
            position: absolute;
            bottom: 16px;
            right: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s ease;
        }

        .trend-indicator.positive {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            border: 1px solid #86efac;
        }

        .trend-indicator.negative {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .trend-indicator i {
            font-size: 0.6rem;
        }

        .modern-stats-card:hover .trend-indicator {
            transform: scale(1.05);
        }

        .chart-container {
            position: relative;
            height: 350px;
            background: white;
            border-radius: 20px;
            padding: 1rem;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.06);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12), 0 2px 4px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .card-body {
            padding: 2rem;
        }

        .welcome-card {
            background: var(--primary-gradient);
            border-radius: 25px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        .calendar-widget {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .calendar-date {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .calendar-month {
            font-size: 1.3rem;
            font-weight: 600;
            opacity: 0.9;
        }

        .quick-action-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid transparent;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .quick-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .quick-action-card:hover::before {
            opacity: 1;
        }

        .quick-action-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: var(--card-shadow-hover);
            text-decoration: none;
            color: white;
        }

        .quick-action-card:hover .quick-action-icon,
        .quick-action-card:hover h6,
        .quick-action-card:hover p {
            position: relative;
            z-index: 1;
            color: white;
        }

        .quick-action-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s ease;
        }

        .notification-item {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-radius: 15px;
            margin-bottom: 0.5rem;
        }

        .notification-item:hover {
            background: var(--light-bg);
            transform: translateX(10px);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            background: var(--primary-gradient);
            color: white;
            font-weight: bold;
        }

        .avatar {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            background: var(--light-bg);
            border: none;
            font-weight: 700;
            color: #2c3e50;
            padding: 1rem 1.5rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: var(--light-bg);
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            border: none;
            vertical-align: middle;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .btn {
            border-radius: 25px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-primary {
            border: 2px solid;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-gradient);
            border-color: transparent;
        }

        /* Loading animation for charts */
        .chart-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-left: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1.5rem;
            }

            .quick-action-card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <!-- Key Metrics Row -->
        <div class="row mb-5">
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="modern-stats-card blue-card">
                    <div class="card-header-accent blue-accent"></div>
                    <div class="card-content">
                        <div class="icon-container blue-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-info">
                            <h2 class="stats-number">{{ number_format($stats['total_users']) }}</h2>
                            <p class="stats-label">TOTAL USERS</p>
                        </div>
                    </div>
                    <div class="trend-indicator positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="modern-stats-card green-card">
                    <div class="card-header-accent green-accent"></div>
                    <div class="card-content">
                        <div class="icon-container green-icon">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="stats-info">
                            <h2 class="stats-number">{{ number_format($stats['total_creators']) }}</h2>
                            <p class="stats-label">ACTIVE CREATORS</p>
                        </div>
                    </div>
                    <div class="trend-indicator positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+8%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="modern-stats-card orange-card">
                    <div class="card-header-accent orange-accent"></div>
                    <div class="card-content">
                        <div class="icon-container orange-icon">
                            <i class="fas fa-blog"></i>
                        </div>
                        <div class="stats-info">
                            <h2 class="stats-number">{{ number_format($stats['total_blog_posts']) }}</h2>
                            <p class="stats-label">BLOG POSTS</p>
                        </div>
                    </div>
                    <div class="trend-indicator positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15%</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="modern-stats-card red-card">
                    <div class="card-header-accent red-accent"></div>
                    <div class="card-content">
                        <div class="icon-container red-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="stats-info">
                            <h2 class="stats-number">{{ number_format($stats['pending_contacts']) }}</h2>
                            <p class="stats-label">PENDING CONTACTS</p>
                        </div>
                    </div>
                    <div class="trend-indicator negative">
                        <i class="fas fa-arrow-down"></i>
                        <span>-5%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Row -->
        <div class="row mb-5">
            <div class="col-xl-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                User Growth Analytics
                            </h4>
                            <p class="text-muted mb-0 mt-1">Track your platform's growth over time</p>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active" data-period="7">7
                                Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-period="30">30 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary" data-period="90">90 Days</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-chart-pie me-2 text-success"></i>
                            User Distribution
                        </h4>
                        <p class="text-muted mb-0 mt-1">Breakdown of user types</p>
                    </div>
                    <div class="card-body">
                        <div class="chart-container mb-4">
                            <canvas id="userDistributionChart"></canvas>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded"
                                style="background: rgba(52, 152, 219, 0.1);">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 12px; height: 12px; background: #3498db;"></div>
                                    <span class="fw-semibold">Regular Users</span>
                                </div>
                                <strong
                                    class="text-primary">{{ number_format($stats['total_users'] - $stats['total_creators']) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded"
                                style="background: rgba(39, 174, 96, 0.1);">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 12px; height: 12px; background: #27ae60;"></div>
                                    <span class="fw-semibold">Creators</span>
                                </div>
                                <strong class="text-success">{{ number_format($stats['total_creators']) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 rounded"
                                style="background: rgba(243, 156, 18, 0.1);">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 12px; height: 12px; background: #f39c12;"></div>
                                    <span class="fw-semibold">Admins</span>
                                </div>
                                <strong class="text-warning">{{ number_format(1) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Data Tables -->
        <div class="row">
            <!-- Recent Users -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">
                                <i class="fas fa-user-plus me-2 text-info"></i>
                                Recent Users
                            </h4>
                            <p class="text-muted mb-0 mt-1">Latest registered members</p>
                        </div>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($stats['recent_users']->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stats['recent_users'] as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3"
                                                            style="width: 40px; height: 40px; background: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $user->name }}</div>
                                                            <small class="text-muted">{{ $user->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'creator' ? 'success' : 'primary') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($user->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No recent users found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Contact Messages -->
            <div class="col-xl-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">
                                <i class="fas fa-envelope me-2 text-warning"></i>
                                Recent Messages
                            </h4>
                            <p class="text-muted mb-0 mt-1">Latest contact inquiries</p>
                        </div>
                        <a href="{{ route('admin.contacts') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($stats['recent_contacts']->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Contact</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stats['recent_contacts'] as $contact)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">{{ $contact->name }}</div>
                                                        <small class="text-muted">{{ $contact->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="max-width: 200px;">
                                                        {{ Str::limit($contact->subject, 30) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $contact->status === 'pending' ? 'warning' : ($contact->status === 'resolved' ? 'success' : 'info') }}">
                                                        {{ ucfirst($contact->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $contact->created_at->format('M d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No recent messages found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // User Growth Chart
            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userGrowthCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                    datasets: [{
                        label: 'Users',
                        data: [12, 19, 25, 32, 45, 52, 65],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Creators',
                        data: [2, 4, 6, 8, 12, 15, 18],
                        borderColor: '#27ae60',
                        backgroundColor: 'rgba(39, 174, 96, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // User Distribution Chart
            const userDistributionCtx = document.getElementById('userDistributionChart').getContext('2d');
            new Chart(userDistributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Regular Users', 'Creators', 'Admins'],
                    datasets: [{
                        data: [{{ $stats['total_users'] - $stats['total_creators'] }},
                            {{ $stats['total_creators'] }}, 1
                        ],
                        backgroundColor: ['#3498db', '#27ae60', '#f39c12'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });

        // Update server time every second
        function updateServerTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('serverTime').textContent = timeString;
        }

        setInterval(updateServerTime, 1000);

        // Period selector for charts
        document.querySelectorAll('[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('[data-period]').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                // Here you would typically reload chart data for the selected period
            });
        });

        // Auto-refresh dashboard every 5 minutes
        setTimeout(function() {
            location.reload();
        }, 300000);

        // Add hover effects to stats cards
        document.querySelectorAll('.stats-card').forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Animate progress bars on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progressBars = entry.target.querySelectorAll('.progress-bar');
                    progressBars.forEach(bar => {
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.transition = 'width 1s ease-in-out';
                            bar.style.width = width;
                        }, 100);
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('.progress-card').forEach(card => {
            observer.observe(card);
        });
    </script>
@endpush
