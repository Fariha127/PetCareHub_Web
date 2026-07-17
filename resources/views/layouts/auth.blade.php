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
            
            --ink: #121c2a;
            --muted: #665054;
            --line: #FFE9F0;              /* Soft Pink/Orange border */
            --wash: #FFF9FA;              /* Soft warm wash */
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
            box-shadow: 0 22px 60px rgba(226, 27, 102, .06);
            padding: 64px;
        }

        .intro-panel {
            position: relative;
            overflow: hidden;
        }

        .intro-panel::before {
            content: "";
            position: absolute;
            inset: auto -90px -120px auto;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: rgba(226, 27, 102, .06);
        }

        .eyebrow {
            color: #FF6601;
            font-size: 1rem;
            letter-spacing: .02em;
            text-transform: uppercase;
            margin-bottom: 16px;
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

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .feature-list li::before {
            content: "";
            width: 9px;
            height: 9px;
            flex: 0 0 9px;
            border-radius: 50%;
            background: var(--brand-green);
            box-shadow: 0 0 0 5px rgba(25, 135, 84, .12);
        }

        .auth-visual {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 14px;
            margin-top: 42px;
        }

        .auth-visual img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            border-radius: 8px;
        }

        .auth-visual img:last-child {
            height: 150px;
            margin-top: 38px;
        }

        .auth-chip {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            border: 1px solid #cde5d8;
            border-radius: 999px;
            background: #eefaf3;
            color: #0f6b3d;
            font-weight: 650;
            padding: 8px 14px;
            margin-top: 26px;
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
            background: var(--brand-gradient);
            border: none;
            border-radius: 7px;
            font-size: 1.12rem;
            font-weight: 600;
            min-height: 49px;
            box-shadow: 0 4px 15px rgba(225, 27, 104, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
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

        .form-control:focus,
        .form-select:focus {
            border-color: #fbcfe8;
            box-shadow: 0 0 0 .22rem rgba(226, 27, 102, .14);
        }

        .link-success {
            color: var(--brand-pink) !important;
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
            <section class="auth-panel intro-panel">
                @yield('intro')
            </section>

            <section class="auth-panel">
                @yield('content')
            </section>
        </div>
    </main>
</body>
</html>
