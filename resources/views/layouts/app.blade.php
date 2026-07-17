<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PetCareHub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }

        body {
            min-height: 100vh;
            background: var(--wash);
            color: var(--ink);
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        .site-nav {
            background: #fff;
            border-bottom: 1px solid var(--line);
        }

        .site-brand {
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.55rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }

        .site-link {
            color: #5b5f66;
            font-size: 1.05rem;
            text-decoration: none;
        }

        .site-link:hover,
        .site-link.active {
            color: var(--brand-green);
        }

        .site-nav .btn {
            min-height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1.5;
        }

        .btn-primary {
            background: var(--brand-gradient);
            border: none;
            border-radius: 7px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(225, 27, 104, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
 
        .btn-primary:hover,
        .btn-primary:focus {
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
            background: #fdfafb;
            color: var(--brand-pink);
            border-color: rgba(225, 27, 104, 0.15);
            box-shadow: 0 4px 15px rgba(225, 27, 104, 0.04);
        }

        .page-section {
            padding: 64px 0;
        }

        .content-card,
        .pet-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(225, 27, 104, 0.05);
            transition: all 0.3s ease;
        }

        .eyebrow {
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1rem;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: inline-block;
            font-weight: 700;
        }

        .hero-title {
            color: var(--ink);
            font-size: clamp(2.7rem, 5vw, 4.7rem);
            font-weight: 750;
            line-height: 1.08;
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

        .hero-media {
            position: relative;
            min-height: 520px;
        }

        .hero-photo {
            width: 100%;
            height: 520px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 22px 60px rgba(39, 73, 59, .13);
        }

        .floating-panel {
            position: absolute;
            left: 28px;
            right: 28px;
            bottom: 28px;
            background: rgba(255, 255, 255, .94);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 18px 45px rgba(18, 28, 42, .12);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .stat-item {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            padding: 18px;
        }

        .stat-value {
            color: var(--brand-green);
            font-size: 2rem;
            font-weight: 750;
            line-height: 1;
        }

        .feature-tile {
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
            padding: 28px;
            height: 100%;
        }

        .feature-icon {
            width: 44px;
            height: 44px;
            display: inline-grid;
            place-items: center;
            border-radius: 8px;
            background: #e9f7ef;
            color: var(--brand-green);
            font-weight: 750;
            margin-bottom: 18px;
        }

        .pet-preview {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .pet-preview img {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 8px;
        }

        .pet-image {
            width: 100%;
            aspect-ratio: 4 / 3;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
            background: #e9f2ee;
        }

        .pet-detail-image {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 8px;
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

        .form-control,
        .form-select {
            border-color: #d6dde3;
            border-radius: 7px;
            min-height: 46px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #88bda1;
            box-shadow: 0 0 0 .22rem rgba(25, 135, 84, .14);
        }

        .pet-search {
            background: #fff;
            border-left: 4px solid var(--line);
            padding: 18px 24px;
        }

        .pet-search .form-control,
        .pet-search .form-select {
            min-height: 40px;
            font-size: 1rem;
        }

        .pet-search .btn {
            min-height: 40px;
        }

        @media (max-width: 767.98px) {
            .page-section {
                padding: 40px 0;
            }

            .site-brand {
                font-size: 1.3rem;
            }

            .hero-media,
            .hero-photo {
                min-height: auto;
                height: 380px;
            }

            .floating-panel {
                position: static;
                margin-top: 16px;
            }

            .stat-grid,
            .pet-preview {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="site-nav">
        <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3 py-4">
            <a class="site-brand" href="{{ route('home') }}">PetCareHub</a>

            <div class="d-flex flex-wrap align-items-center gap-3 gap-md-4">
                <a class="site-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="site-link {{ request()->routeIs('pets.*') ? 'active' : '' }}" href="{{ route('pets.index') }}">Pets</a>

                @auth
                    <span class="text-secondary small">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</span>
                    <a class="btn btn-outline-success px-3" href="{{ route('dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary px-3">Logout</button>
                    </form>
                @else
                    <a class="btn btn-outline-success px-3" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary px-3" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    @yield('content')
</body>
</html>
