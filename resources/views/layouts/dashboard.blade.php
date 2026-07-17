<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard | PetCareHub')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-pink: #e11b68;
            --brand-orange: #ff6f00;
            --brand-purple: #701a75;
            --brand-pink-dark: #6b0e23;
            
            --brand-green: var(--brand-pink);
            --brand-green-dark: var(--brand-pink-dark);
            --brand-green-light: var(--brand-orange);
            
            --brand-gradient: linear-gradient(135deg, var(--brand-pink), var(--brand-orange));
            --brand-gradient-hover: linear-gradient(135deg, var(--brand-pink-dark), #e65c00);
            --brand-gradient-purple: linear-gradient(135deg, var(--brand-purple), var(--brand-pink));
            
            --ink: #1f0207;
            --muted: #6b5860;
            --line: rgba(225, 27, 104, 0.12); /* Soft transparent pink border */
            --wash: #fdfafb;                  /* Warm pink wash */
            --sidebar-width: 260px;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--wash);
            color: var(--ink);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            margin: 0;
        }

        /* ── Top Nav ── */
        .dash-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 64px;
            background: #fff;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1050;
        }

        .dash-brand {
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.4rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }

        .dash-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dash-role-badge {
            background: #FFF0F4;
            color: #E21B66;
            font-size: .8rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid #FFE9F0;
        }

        /* ── Sidebar ── */
        .dash-sidebar {
            position: fixed;
            top: 64px;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid var(--line);
            overflow-y: auto;
            padding: 24px 0;
            z-index: 1040;
            transition: transform .25s ease;
        }

        .dash-sidebar .nav-section {
            padding: 0 16px;
            margin-bottom: 8px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #97a3b0;
        }

        .dash-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: var(--muted);
            font-size: .95rem;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all .15s;
        }

        .dash-sidebar .nav-link:hover {
            color: var(--brand-green);
            background: var(--wash);
        }

        .dash-sidebar .nav-link.active {
            color: var(--brand-green);
            background: #FFF0F4;
            border-left-color: var(--brand-green);
            font-weight: 600;
        }

        .dash-sidebar .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }

        .sidebar-divider {
            border-top: 1px solid var(--line);
            margin: 16px 0;
        }

        /* ── Main Content ── */
        .dash-main {
            margin-left: var(--sidebar-width);
            margin-top: 64px;
            padding: 32px;
            min-height: calc(100vh - 64px);
        }

        /* ── Cards ── */
        .stat-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.02);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px -4px rgba(0,0,0,.06), 0 4px 6px -2px rgba(0,0,0,.03);
            border-color: #E21B66;
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 750;
            line-height: 1.1;
        }

        .stat-card .stat-label {
            color: var(--muted);
            font-size: .88rem;
            margin-top: 4px;
        }

        .content-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.02);
        }

        /* ── Status badges ── */
        .badge-pending {
            background: #fff6f0;
            color: #ff6601;
            border: 1px solid #ffe2d1;
        }
 
        .badge-approved {
            background: #FFF0F4;
            color: #E21B66;
            border: 1px solid #FFE9F0;
        }
 
        .badge-rejected {
            background: #fff5f5;
            color: #d8213c;
            border: 1px solid #ffd1d1;
        }

        /* ── Table ── */
        .table th {
            font-size: .82rem;
            font-weight: 650;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6b7a8d;
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
            font-size: .92rem;
        }

        /* ── Forms ── */
        .form-control, .form-select {
            border-color: #d6dde3;
            border-radius: 7px;
            min-height: 44px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #fbcfe8;
            box-shadow: 0 0 0 .22rem rgba(226, 27, 102, .14);
        }

        .btn-primary {
            background: var(--brand-gradient);
            border: none;
            border-radius: 7px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(225, 27, 104, 0.25);
            transition: all 0.3s ease;
        }
 
        .btn-primary:hover, .btn-primary:focus {
            background: var(--brand-gradient-hover);
            box-shadow: 0 6px 20px rgba(225, 27, 104, 0.4);
            transform: translateY(-1px);
        }

        .btn-outline-success {
            border-color: var(--brand-pink);
            color: var(--brand-pink);
            transition: all 0.3s ease;
        }
 
        .btn-outline-success:hover {
            background: var(--brand-gradient);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 12px rgba(225, 27, 104, 0.2);
        }

        .btn-success {
            background: var(--brand-gradient);
            border: none;
            border-radius: 7px;
            color: #fff !important;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(225, 27, 104, 0.25);
            transition: all 0.3s ease;
        }

        .btn-success:hover,
        .btn-success:focus {
            background: var(--brand-gradient-hover);
            box-shadow: 0 6px 20px rgba(225, 27, 104, 0.4);
            transform: translateY(-1px);
            color: #fff !important;
        }

        .alert-success {
            background: #FFF0F4;
            color: #e11b68;
            border-color: #FFE9F0;
            box-shadow: 0 4px 12px rgba(225, 27, 104, 0.05);
        }

        .page-title {
            font-size: 1.6rem;
            font-weight: 750;
            color: var(--ink);
        }

        /* ── Hamburger toggle ── */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--ink);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.3);
            z-index: 1035;
        }

        /* ── Pet Browse / Details Styles ── */
        .pet-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05), 0 1px 2px rgba(0,0,0,.02);
            transition: all 0.25s ease;
        }

        .pet-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,.08);
            border-color: #a7f3d0;
        }

        .pet-image {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
            background: #e9f2ee;
        }

        .pet-detail-image {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 12px;
            background: #e9f2ee;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 5px 12px;
            font-size: .9rem;
            font-weight: 650;
            background: #e9f7ef;
            color: #0f6b3d;
        }

        .status-pill.adopted {
            background: #eef2f7;
            color: #596273;
        }

        .pet-search {
            background: #fff;
            border-left: 4px solid var(--brand-green);
            padding: 18px 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .pet-search .form-control,
        .pet-search .form-select {
            min-height: 40px;
            font-size: 1rem;
        }

        .pet-search .btn {
            min-height: 40px;
        }

        .eyebrow {
            color: #047857;
            font-size: 1rem;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 16px;
            font-weight: 600;
        }

        .section-title {
            color: var(--ink);
            font-size: clamp(2rem, 3vw, 2.8rem);
            font-weight: 750;
            line-height: 1.18;
        }

        .muted-copy {
            color: var(--muted);
            font-size: 1.18rem;
            line-height: 1.6;
        }

        @media (max-width: 991.98px) {
            .sidebar-toggle {
                display: inline-flex;
            }

            .dash-sidebar {
                transform: translateX(-100%);
            }

            .dash-sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }

            .dash-main {
                margin-left: 0;
            }
        }

        @media (max-width: 575.98px) {
            .dash-main {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Top bar -->
    <header class="dash-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>
            <a class="dash-brand" href="{{ route('home') }}">PetCareHub</a>
        </div>
        <div class="dash-user-info">
            <span class="dash-role-badge">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</span>
            <span class="d-none d-sm-inline text-secondary">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
            </form>
        </div>
    </header>

    <!-- Sidebar overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="dash-sidebar" id="dashSidebar">
        <div class="nav-section">Navigation</div>

        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid-1x2"></i> Overview
        </a>

        <a class="nav-link {{ request()->routeIs('dashboard.profile*') ? 'active' : '' }}" href="{{ route('dashboard.profile') }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>

        @if(auth()->user()->isAdopter())
            <a class="nav-link {{ request()->routeIs('dashboard.my-posts*') ? 'active' : '' }}" href="{{ route('dashboard.my-posts') }}">
                <i class="bi bi-chat-heart"></i> My Help Posts
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.requests') ? 'active' : '' }}" href="{{ route('dashboard.requests') }}">
                <i class="bi bi-file-earmark-text"></i> My Requests
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.my-pets') ? 'active' : '' }}" href="{{ route('dashboard.my-pets') }}">
                <i class="bi bi-heart-fill"></i> My Pets
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.my-events') ? 'active' : '' }}" href="{{ route('dashboard.my-events') }}">
                <i class="bi bi-calendar2-check"></i> My Events
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.appointments*') ? 'active' : '' }}" href="{{ route('dashboard.appointments.index') }}">
                <i class="bi bi-calendar-check-fill"></i> My Appointments
            </a>
            <a class="nav-link {{ request()->routeIs('pets.index') ? 'active' : '' }}" href="{{ route('pets.index') }}">
                <i class="bi bi-search-heart"></i> Browse Pets
            </a>
        @endif

        @if(auth()->user()->isShelterStaff())
            <div class="sidebar-divider"></div>
            <div class="nav-section">Management</div>
            <a class="nav-link {{ request()->routeIs('pets.index') ? 'active' : '' }}" href="{{ route('pets.index') }}">
                <i class="bi bi-card-list"></i> All Pets
            </a>
            <a class="nav-link {{ request()->routeIs('pets.create') ? 'active' : '' }}" href="{{ route('pets.create') }}">
                <i class="bi bi-plus-circle"></i> Add Pet
            </a>
            <a class="nav-link {{ request()->routeIs('events*') ? 'active' : '' }}" href="{{ route('events.index') }}">
                <i class="bi bi-calendar-event"></i> Manage Events
            </a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.adoption') }}">
                <i class="bi bi-bar-chart-line"></i> Reports
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.manage-posts*') ? 'active' : '' }}" href="{{ route('dashboard.manage-posts.index') }}">
                <i class="bi bi-shield-check"></i> Review Help Posts
            </a>
        @endif

        @if(auth()->user()->isVet())
            <div class="sidebar-divider"></div>
            <div class="nav-section">Veterinary</div>
            <a class="nav-link {{ request()->routeIs('pets.index') ? 'active' : '' }}" href="{{ route('pets.index') }}">
                <i class="bi bi-card-list"></i> All Pets
            </a>
            <a class="nav-link {{ request()->routeIs('dashboard.appointments.vet-index*') ? 'active' : '' }}" href="{{ route('dashboard.appointments.vet-index') }}">
                <i class="bi bi-calendar3"></i> Appointments
            </a>
        @endif

        <div class="sidebar-divider"></div>
        <a class="nav-link" href="{{ route('home') }}">
            <i class="bi bi-house"></i> Back to Home
        </a>
    </aside>

    <!-- Main content -->
    <main class="dash-main">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('dashSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }
    </script>
</body>
</html>
