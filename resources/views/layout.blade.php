{{-- resources/views/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dunkin’ Donuts Kiosk')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dunkin-orange: #ff7d00;
            --dunkin-pink: #ff3c7d;
            --dunkin-plum: #a10054;
            --dunkin-cream: #fff7f1;
        }

        body {
            font-family: 'Rubik', sans-serif;
            background: var(--dunkin-cream);
            color: #391800;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .navbar {
            background-color: var(--dunkin-orange);
            padding: 0.5rem 1.5rem;
            box-shadow: 0 10px 25px rgba(255, 125, 0, 0.35);
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .navbar-brand img {
            height: 52px;
            width: auto;
        }

        .navbar-nav {
            gap: 0.35rem;
        }

        .nav-link {
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.35rem 1.25rem;
            border-radius: 999px;
            transition: background 0.2s, transform 0.2s;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: #fff;
            transform: translateY(-1px);
        }

        .nav-link.active {
            background: rgba(0, 0, 0, 0.2);
            font-weight: 700;
        }

        .cart-pill[data-cart-count],
        .cart-pill span[data-cart-count] {
            font-weight: 700;
        }

        footer {
            background-color: var(--dunkin-orange);
            color: #fff;
            text-align: center;
            padding: 1rem 0;
            font-weight: 500;
            box-shadow: 0 -10px 25px rgba(255, 125, 0, 0.25);
        }

        .btn-dunkin {
            background: linear-gradient(45deg, #ff5a79, #ff7d00);
            color: #fff;
            font-weight: 700;
            border: none;
            transition: transform 0.2s, opacity 0.2s;
        }

        .btn-dunkin:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-outline-dunkin {
            background: transparent;
            color: var(--dunkin-orange);
            border: 2px solid var(--dunkin-orange);
            font-weight: 700;
            transition: all 0.2s;
        }

        .btn-outline-dunkin:hover {
            background: var(--dunkin-orange);
            color: #fff;
            transform: translateY(-1px);
        }

        .dropdown-menu {
            background-color: #fff;
            border: 2px solid var(--dunkin-orange);
            box-shadow: 0 4px 12px rgba(255, 125, 0, 0.15);
        }

        .dropdown-item {
            color: #391800;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--dunkin-cream);
            color: var(--dunkin-orange);
        }

        .dropdown-divider {
            border-color: #e0e0e0;
        }

        @media (max-width: 992px) {
            .navbar-nav {
                gap: 0.5rem;
                padding-top: 0.75rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Dunkin’ Donuts logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-pill {{ request()->routeIs('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                            Cart
                            <span id="cartCountBadge" data-cart-count>{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">My Orders</a></li>
                                @if(Auth::user()->is_admin)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i style="color: var(--dunkin-orange);"></i> <strong>Admin Panel</strong>
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Dunkin’ Donuts Kiosk
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    @yield('kiosk-panel')
    @stack('scripts')
</body>
</html>