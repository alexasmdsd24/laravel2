{{-- resources/views/admin/admin-layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Dunkin Donuts')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --dunkin-orange: #ff7d00;
            --dunkin-pink: #ff3c7d;
            --dunkin-plum: #a10054;
            --dunkin-cream: #fff7f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Rubik', sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            background: linear-gradient(135deg, var(--dunkin-orange) 0%, var(--dunkin-pink) 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(255, 125, 0, 0.2);
        }

        .admin-brand {
            font-family: 'Fredoka One', cursive;
            font-size: 1.5rem;
            padding: 0 1.5rem 2rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .admin-nav {
            list-style: none;
            padding: 0;
        }

        .admin-nav-item {
            margin: 0.5rem 0;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }

        .admin-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: white;
            color: white;
        }

        .admin-nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            color: white;
            font-weight: 700;
        }

        .admin-nav-link i {
            width: 20px;
            text-align: center;
        }

        .admin-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-topbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dunkin-orange);
        }

        .admin-topbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-main {
            flex: 1;
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--dunkin-orange) 0%, var(--dunkin-pink) 100%);
            color: white;
            border: none;
            border-radius: 1rem 1rem 0 0;
            padding: 1.5rem;
            font-weight: 700;
        }

        .btn-dunkin {
            background: linear-gradient(45deg, var(--dunkin-pink), var(--dunkin-orange));
            color: white;
            border: none;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-dunkin:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }

        .btn-dunkin-outline {
            border: 2px solid var(--dunkin-orange);
            color: var(--dunkin-orange);
            background: transparent;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-dunkin-outline:hover {
            background: var(--dunkin-orange);
            color: white;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-top: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 700;
            color: var(--dunkin-orange);
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge-category {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
        }

        .badge-donuts {
            background: #ffe8cc;
            color: #b86f11;
        }

        .badge-beverages {
            background: #cce5ff;
            color: #115b99;
        }

        .badge-snacks {
            background: #e8ccff;
            color: #5c11b8;
        }

        .badge-bundles {
            background: #ccffe8;
            color: #119955;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dunkin-orange);
        }

        .stat-label {
            color: #666;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--dunkin-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 125, 0, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                position: fixed;
                bottom: 0;
                height: auto;
                display: flex;
                overflow-x: auto;
            }

            .admin-content {
                margin-left: 0;
                margin-bottom: 80px;
            }

            .admin-brand {
                display: none;
            }

            .admin-nav {
                display: flex;
                gap: 0;
            }

            .admin-nav-item {
                margin: 0;
            }

            .admin-nav-link {
                padding: 1rem;
                font-size: 0.9rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <i class="fas fa-crown"></i> Admin
            </div>
            <ul class="admin-nav">
                <li class="admin-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="{{ route('admin.menu.index') }}" class="admin-nav-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        <span>Menu Items</span>
                    </a>
                </li>
                <li class="admin-nav-item">
                    <a href="/" class="admin-nav-link">
                        <i class="fas fa-home"></i>
                        <span>Back to Site</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="admin-content">
            <!-- Topbar -->
            <div class="admin-topbar">
                <div class="admin-topbar-title">
                    @yield('page-title', 'Dashboard')
                </div>
                <div class="admin-topbar-user">
                    <span>{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-dunkin">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="admin-main">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="fas fa-exclamation-triangle"></i> Validation Errors:</strong>
                        <ul class="mb-0" style="margin-top: 0.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
