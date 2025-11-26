<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Panel')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root {
      --sidebar-width: 280px;
      --primary-color: #2c3e50;
      --secondary-color: #34495e;
      --accent-color: #3498db;
      --success-color: #27ae60;
      --warning-color: #f39c12;
      --danger-color: #e74c3c;
      --info-color: #17a2b8;
      --light-bg: #f8f9fa;
      --sidebar-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --card-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      --card-shadow-hover: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-bg);
      overflow-x: hidden;
    }

    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
      z-index: 1000;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
    }

    .sidebar-header {
      padding: 2rem 1.5rem 1.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02));
    }

    .sidebar-header h4 {
      color: #ffffff;
      margin: 0;
      font-weight: 700;
      font-size: 1.4rem;
      letter-spacing: 0.5px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .sidebar-header .logo {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      border: 2px solid rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }

    .sidebar-header .logo:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }

    .sidebar-menu {
      padding: 1.5rem 0 2rem;
      overflow-y: auto;
      overflow-x: hidden;
      max-height: calc(100vh - 140px);
    }

    .sidebar-menu .nav-link {
      color: rgba(255, 255, 255, 0.75);
      padding: 0.875rem 1.5rem;
      margin: 0.125rem 0.75rem;
      border-radius: 10px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      align-items: center;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      position: relative;
      overflow: hidden;
    }

    .sidebar-menu .nav-link::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .sidebar-menu .nav-link:hover::before {
      left: 100%;
    }

    .sidebar-menu .nav-link:hover {
      color: #ffffff;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.08));
      transform: translateX(8px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      border-left: 3px solid rgba(102, 126, 234, 0.8);
    }

    .sidebar-menu .nav-link.active {
      color: #ffffff;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
      border-left: 4px solid #ffffff;
      font-weight: 600;
      transform: translateX(4px);
    }

    .sidebar-menu .nav-link.active::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 6px;
      height: 6px;
      background: #ffffff;
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
    }

    .sidebar-menu .nav-link i {
      width: 22px;
      margin-right: 1rem;
      text-align: center;
      font-size: 1.1rem;
      opacity: 0.9;
      transition: all 0.3s ease;
    }

    .sidebar-menu .nav-link:hover i,
    .sidebar-menu .nav-link.active i {
      opacity: 1;
      transform: scale(1.1);
    }

    .sidebar-menu .menu-section {
      padding: 1.5rem 1.5rem 0.75rem;
      color: rgba(255, 255, 255, 0.5);
      font-size: 0.75rem;
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 1.5px;
      margin-top: 2rem;
      position: relative;
    }

    .sidebar-menu .menu-section::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 1.5rem;
      right: 1.5rem;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    }

    .sidebar-menu .menu-section:first-of-type {
      margin-top: 0;
      padding-top: 0;
    }

    /* Main Content */
    .main-content {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      transition: all 0.3s ease;
    }

    /* Top Navbar */
    .top-navbar {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 1rem 1.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 999;
      border-bottom: none;
      backdrop-filter: blur(10px);
      border-radius: 0 0 15px 15px;
    }

    .navbar-brand {
      font-weight: 600;
      color: #ffffff !important;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.9);
      font-weight: 500;
    }

    .navbar-nav .dropdown-toggle::after {
      margin-left: 0.5rem;
    }

    /* Search Bar Styling */
    .search-bar {
      background: rgba(255, 255, 255, 0.15);
      border-radius: 25px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      overflow: hidden;
      transition: all 0.3s ease;
    }

    .search-bar:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .search-input {
      background: transparent;
      border: none;
      color: white;
      padding: 0.5rem 1rem;
    }

    .search-input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .search-input:focus {
      background: transparent;
      color: white;
      box-shadow: none;
    }

    .search-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: white;
      border-radius: 0 25px 25px 0;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
    }

    .search-btn:hover {
      background: rgba(255, 255, 255, 0.3);
      color: white;
    }

    /* User Dropdown Styling */
    .user-dropdown-btn {
      color: white !important;
      padding: 0.5rem;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .user-dropdown-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white !important;
    }

    .user-avatar {
      transition: all 0.3s ease;
      border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .user-avatar:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Sidebar Toggle Button */
    .sidebar-toggle-btn {
      color: white !important;
      padding: 0.5rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .sidebar-toggle-btn:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white !important;
      transform: scale(1.05);
    }

    /* Content Area */
    .content-area {
      padding: 2rem;
    }

    /* Cards */
    .card {
      border: none;
      border-radius: 0.75rem;
      box-shadow: var(--card-shadow);
      transition: all 0.3s ease;
      margin-bottom: 1.5rem;
    }

    .card:hover {
      box-shadow: var(--card-shadow-hover);
      transform: translateY(-2px);
    }

    .card-header {
      background: white;
      border-bottom: 1px solid #f1f3f4;
      font-weight: 600;
      color: var(--primary-color);
      padding: 1.25rem;
      border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    .card-body {
      padding: 1.5rem;
    }

    /* Stats Cards */
    .stats-card {
      background: white;
      border-radius: 0.75rem;
      padding: 1.5rem;
      box-shadow: var(--card-shadow);
      border-left: 4px solid var(--accent-color);
      transition: all 0.3s ease;
      height: 100%;
    }

    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--card-shadow-hover);
    }

    .stats-card .icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: white;
      margin-bottom: 1rem;
    }

    .stats-card.primary {
      border-left-color: var(--accent-color);
    }

    .stats-card.primary .icon {
      background: var(--accent-color);
    }

    .stats-card.success {
      border-left-color: var(--success-color);
    }

    .stats-card.success .icon {
      background: var(--success-color);
    }

    .stats-card.warning {
      border-left-color: var(--warning-color);
    }

    .stats-card.warning .icon {
      background: var(--warning-color);
    }

    .stats-card.danger {
      border-left-color: var(--danger-color);
    }

    .stats-card.danger .icon {
      background: var(--danger-color);
    }

    .stats-card.info {
      border-left-color: var(--info-color);
    }

    .stats-card.info .icon {
      background: var(--info-color);
    }

    .stats-card h3 {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0;
      color: var(--primary-color);
    }

    .stats-card p {
      margin: 0;
      color: #6c757d;
      font-weight: 500;
      font-size: 0.9rem;
    }

    .stats-card .trend {
      font-size: 0.8rem;
      margin-top: 0.5rem;
    }

    .stats-card .trend.up {
      color: var(--success-color);
    }

    .stats-card .trend.down {
      color: var(--danger-color);
    }

    /* Buttons */
    .btn {
      border-radius: 0.5rem;
      font-weight: 500;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--accent-color);
      border-color: var(--accent-color);
    }

    .btn-primary:hover {
      background: #2980b9;
      border-color: #2980b9;
      transform: translateY(-1px);
    }

    .btn-success {
      background: var(--success-color);
      border-color: var(--success-color);
    }

    .btn-warning {
      background: var(--warning-color);
      border-color: var(--warning-color);
    }

    .btn-danger {
      background: var(--danger-color);
      border-color: var(--danger-color);
    }

    /* Tables */
    .table {
      margin-bottom: 0;
    }

    .table th {
      border-top: none;
      font-weight: 600;
      color: var(--primary-color);
      background-color: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
    }

    .table td {
      vertical-align: middle;
      border-bottom: 1px solid #f1f3f4;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(52, 152, 219, 0.05);
    }

    /* Badges */
    .badge {
      font-size: 0.75rem;
      padding: 0.5em 0.75em;
      border-radius: 0.375rem;
      font-weight: 500;
    }

    /* Alerts */
    .alert {
      border: none;
      border-radius: 0.75rem;
      padding: 1rem 1.25rem;
      margin-bottom: 1.5rem;
    }

    .alert-success {
      background-color: rgba(39, 174, 96, 0.1);
      color: var(--success-color);
      border-left: 4px solid var(--success-color);
    }

    .alert-danger {
      background-color: rgba(231, 76, 60, 0.1);
      color: var(--danger-color);
      border-left: 4px solid var(--danger-color);
    }

    .alert-warning {
      background-color: rgba(243, 156, 18, 0.1);
      color: var(--warning-color);
      border-left: 4px solid var(--warning-color);
    }

    .alert-info {
      background-color: rgba(23, 162, 184, 0.1);
      color: var(--info-color);
      border-left: 4px solid var(--info-color);
    }

    /* Progress Bars */
    .progress {
      height: 0.5rem;
      border-radius: 0.25rem;
      background-color: #e9ecef;
    }

    .progress-bar {
      border-radius: 0.25rem;
    }

    /* Breadcrumb */
    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 1.5rem;
    }

    .breadcrumb-item+.breadcrumb-item::before {
      content: ">";
      color: #6c757d;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.25);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .content-area {
        padding: 1rem;
      }

      .stats-card {
        margin-bottom: 1rem;
      }

      .sidebar-menu .nav-link:hover {
        transform: none;
      }

      .sidebar-menu .nav-link.active {
        transform: none;
      }
    }

    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: linear-gradient(180deg, rgba(102, 126, 234, 0.6), rgba(118, 75, 162, 0.6));
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(180deg, rgba(102, 126, 234, 0.8), rgba(118, 75, 162, 0.8));
    }

    /* Animation Classes */
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .slide-in {
      animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
      from {
        transform: translateX(-20px);
        opacity: 0;
      }

      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
  </style>
  @stack('styles')
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo">
        <i class="fas fa-crown"></i>
      </div>
      <h4>Admin Panel</h4>
    </div>

    <nav class="sidebar-menu">
      <ul class="nav flex-column">
        <li class="menu-section">Main Navigation</li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
          </a>
        </li>

        <li class="menu-section">Website Management</li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.website.home*') ? 'active' : '' }}" href="{{ route('admin.website.home.index') }}">
            <i class="fas fa-home"></i>
            Home Page
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.website.about*') ? 'active' : '' }}" href="{{ route('admin.website.about.index') }}">
            <i class="fas fa-info-circle"></i>
            About Page
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.website.contact*') ? 'active' : '' }}" href="{{ route('admin.website.contact.index') }}">
            <i class="fas fa-envelope"></i>
            Contact Page
          </a>
        </li>

        <li class="menu-section">Management</li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
            <i class="fas fa-users"></i>
            Users Management
          </a>
        </li>
        {{-- <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.creators*') ? 'active' : '' }}" href="{{ route('admin.creators') }}">
                        <i class="fas fa-palette"></i>
                        Creators
                    </a>
                </li> --}}
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.blog*') ? 'active' : '' }}" href="{{ route('admin.blog.index') }}">
            <i class="fas fa-blog"></i>
            Blog Posts
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts') }}">
            <i class="fas fa-envelope"></i>
            Contact Messages
          </a>
        </li> --}}

        <li class="menu-section">Account</li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
              <i class="fas fa-sign-out-alt"></i>
              Logout
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg top-navbar">
      <div class="container-fluid">
        <div class="d-flex align-items-center">
          <button class="btn btn-link d-lg-none me-3 sidebar-toggle-btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <h5 class="navbar-brand mb-0">@yield('page-title', 'Dashboard')</h5>
        </div>

        <div class="d-flex align-items-center">
          <!-- Search Bar -->
          <div class="me-3 d-none d-md-block">
            <div class="input-group search-bar">
              <input type="text" class="form-control search-input" placeholder="Search..." style="width: 250px;">
              <button class="btn btn-light search-btn" type="button">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>

          <!-- User Dropdown -->
          <div class="dropdown">
            <button class="btn btn-link dropdown-toggle d-flex align-items-center user-dropdown-btn" type="button" data-bs-toggle="dropdown">
              <div class="me-2 d-none d-sm-block text-end">
                <div class="fw-semibold text-white">{{ Auth::user()->name }}</div>
              </div>
              <div class="rounded-circle bg-white d-flex align-items-center justify-content-center user-avatar" style="width: 40px; height: 40px;">
                <i class="fas fa-user text-primary"></i>
              </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
              </li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
              </li>
              <li><a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2"></i>Help</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Content Area -->
    <div class="content-area">
      <!-- Breadcrumb -->
      @if (isset($breadcrumbs))
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
              @if ($loop->last)
                <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
              @endif
            @endforeach
          </ol>
        </nav>
      @endif

      <!-- Flash Messages -->
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

      @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          {{ session('warning') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <i class="fas fa-info-circle me-2"></i>
          {{ session('info') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <strong>Please fix the following errors:</strong>
          <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <!-- Main Content -->
      <div class="fade-in">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom JS -->
  <script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
      document.getElementById('sidebar').classList.toggle('show');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      const sidebar = document.getElementById('sidebar');
      const sidebarToggle = document.getElementById('sidebarToggle');

      if (window.innerWidth <= 768 &&
        !sidebar.contains(event.target) &&
        !sidebarToggle.contains(event.target) &&
        sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
      }
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        if (alert.querySelector('.btn-close')) {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }
      });
    }, 5000);

    // Add loading state to buttons
    document.querySelectorAll('form').forEach(function(form) {
      form.addEventListener('submit', function() {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        }
      });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
  </script>

  @stack('scripts')
</body>

</html>
