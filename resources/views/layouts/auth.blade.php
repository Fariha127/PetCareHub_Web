<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PetCareHub')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-green: #198754;
            --brand-green-dark: #146c43;
            --ink: #121c2a;
            --muted: #667085;
            --line: #dfe7e3;
            --wash: #f4faf7;
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
            color: var(--brand-green);
            font-size: 1.55rem;
            font-weight: 700;
            text-decoration: none;
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
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1.5;
        }

        .auth-page {
            min-height: 100vh;
            padding: 64px 16px;
        }

        .has-nav .auth-page {
            min-height: calc(100vh - 94px);
        }

        .auth-grid {
            width: min(1400px, 100%);
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr);
            gap: 32px;
            margin: 0 auto;
            align-items: stretch;
        }

        .auth-panel {
            width: 100%;
            min-height: 560px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 22px 60px rgba(39, 73, 59, .10);
            padding: 64px;
        }

        .eyebrow {
            color: #16665f;
            font-size: 1rem;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .intro-title {
            color: var(--ink);
            font-size: clamp(2.45rem, 4vw, 3.5rem);
            font-weight: 750;
            line-height: 1.18;
            margin-bottom: 24px;
        }

        .form-title {
            color: #061527;
            font-size: clamp(2rem, 3vw, 2.45rem);
            font-weight: 750;
            line-height: 1.2;
            margin-bottom: 32px;
        }

        .intro-copy,
        .auth-note {
            color: var(--muted);
            font-size: 1.25rem;
            line-height: 1.55;
        }

        .feature-list {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.9;
            margin-top: 34px;
            padding-left: 0;
            list-style: none;
        }

        .form-label {
            color: #020b1d;
            font-size: 1.18rem;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select {
            min-height: 49px;
            border-color: #d6dde3;
            border-radius: 7px;
            font-size: 1.12rem;
            padding: 10px 16px;
        }

        .btn-primary {
            background: var(--brand-green);
            border-color: var(--brand-green);
            border-radius: 7px;
            font-size: 1.12rem;
            font-weight: 600;
            min-height: 49px;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--brand-green-dark);
            border-color: var(--brand-green-dark);
        }

        .btn-outline-success {
            border-color: var(--brand-green);
            color: var(--brand-green);
        }

        .btn-outline-success:hover {
            background: var(--brand-green);
            border-color: var(--brand-green);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #88bda1;
            box-shadow: 0 0 0 .22rem rgba(25, 135, 84, .14);
        }

        .link-success {
            color: #087c4a !important;
        }

        @media (max-width: 991.98px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }

            .auth-panel {
                min-height: auto;
                padding: 40px 28px;
            }
        }

        @media (max-width: 575.98px) {
            .auth-page {
                padding: 32px 12px;
            }

            .auth-panel {
                padding: 30px 20px;
            }

            .site-brand {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body class="@hasSection('nav') has-nav @endif">
    @hasSection('nav')
        <nav class="site-nav">
            <div class="container d-flex align-items-center justify-content-between py-4">
                <a class="site-brand" href="{{ url('/') }}">PetCareHub</a>
                <div class="d-flex align-items-center gap-4">
                    <a class="site-link" href="{{ url('/') }}">Home</a>
                    <a class="site-link" href="{{ route('pets.index') }}">Pets</a>
                    <a class="btn btn-outline-success px-3" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary px-3" href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </nav>
    @endif

    <main class="auth-page d-flex align-items-center">
        <div class="auth-grid">
            <section class="auth-panel">
                @yield('intro')
            </section>

            <section class="auth-panel">
                @yield('content')
            </section>
        </div>
    </main>
</body>
</html>
