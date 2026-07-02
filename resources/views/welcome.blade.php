<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetCareHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f6f8f5;
            color: #243026;
        }

        .navbar {
            border-bottom: 1px solid #dfe7dc;
            background: rgba(246, 248, 245, .92);
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #2f6f4e;
            color: #fff;
            font-weight: 700;
        }

        .hero {
            min-height: calc(100vh - 74px);
            display: grid;
            align-items: center;
            padding: 56px 0;
        }

        .feature-card {
            border: 1px solid #dfe7dc;
            border-radius: 8px;
            background: #fff;
        }

        .btn-primary {
            background: #2f6f4e;
            border-color: #2f6f4e;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: #285d43;
            border-color: #285d43;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-semibold" href="{{ url('/') }}">
                <span class="brand-mark">PCH</span>
                PetCareHub
            </a>

            <div class="d-flex gap-2">
                @auth
                    <a class="btn btn-outline-success" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="btn btn-outline-success" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <p class="text-success fw-semibold mb-2">Pet Adoption & Veterinary Care</p>
                    <h1 class="display-5 fw-bold mb-3">Manage pets, adoptions, and care from one clean dashboard.</h1>
                    <p class="lead text-secondary mb-4">
                        Start with role-based access for adopters, shelter staff, and veterinarians.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-primary btn-lg" href="{{ route('register') }}">Create account</a>
                        <a class="btn btn-outline-success btn-lg" href="{{ route('login') }}">Login</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="feature-card p-4 h-100">
                                <h2 class="h5">Shelter Staff</h2>
                                <p class="text-secondary mb-0">Prepare pet records and adoption approvals.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="feature-card p-4 h-100">
                                <h2 class="h5">Veterinarian</h2>
                                <p class="text-secondary mb-0">Track appointments, vaccines, and treatments.</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="feature-card p-4 h-100">
                                <h2 class="h5">User / Adopter</h2>
                                <p class="text-secondary mb-0">Browse pets and submit adoption requests as the system grows.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
