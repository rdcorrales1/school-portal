<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Student & Academic Management Portal')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;600&family=Plus+Jakarta+Sans:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-royal-blue: #1E3A8A;
            --surface-white: #FFFFFF;
            --surface-cool-gray: #F1F5F9;
            --accent-cyan: #06B6D4;
            --accent-cyan-hover: #0891B2;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --text-on-blue: #FFFFFF;
            --text-muted-on-blue: #CBD5E1;
            --border-cool-gray: #CBD5E1;
            --status-success: #10B981;
            --status-warning: #F59E0B;
            --status-error: #EF4444;

            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --space-1: 4px;  --space-2: 8px;  --space-3: 12px; --space-4: 16px;
            --space-6: 24px; --space-8: 32px; --space-12: 48px; --space-16: 64px;
            --radius-md: 8px; --radius-lg: 12px; --radius-full: 9999px;
        }

        body {
            background: var(--bg-royal-blue);
            color: var(--text-on-blue);
            font-family: var(--font-body);
            font-size: 1rem;
            line-height: 1.6;
        }

        h1, h2, h3 { font-family: var(--font-heading); }
        h1 { font-size: 2.25rem; line-height: 1.2; font-weight: 700; }
        h2 { font-size: 1.5rem; line-height: 1.3; font-weight: 600; }
        h3 { font-size: 1.125rem; line-height: 1.4; font-weight: 600; }

        /* Side navigation (logged-in pages only) */
        .portal-sidebar {
            background: var(--bg-royal-blue);
            color: var(--text-on-blue);
            border-right: 1px solid color-mix(in srgb, var(--text-on-blue) 15%, transparent);
            width: 240px;
            min-height: 100vh;
        }
        @media (min-width: 992px) {
            /* On desktop the side nav stays in view while the page scrolls */
            .portal-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                overflow-y: auto;
                flex-shrink: 0;
            }
        }
        .portal-sidebar .nav-link {
            color: var(--text-muted-on-blue);
            border-left: 3px solid transparent;
            border-radius: 0;
            padding: var(--space-3) var(--space-6);
        }
        .portal-sidebar .nav-link:hover { color: var(--text-on-blue); }
        .portal-sidebar .nav-link.active {
            background: color-mix(in srgb, var(--accent-cyan) 15%, transparent);
            color: var(--accent-cyan);
            border-left-color: var(--accent-cyan);
        }

        .portal-card {
            background: var(--surface-white);
            color: var(--text-dark);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
            border: 1px solid color-mix(in srgb, var(--border-cool-gray) 60%, transparent);
            box-shadow: 0 1px 3px color-mix(in srgb, var(--text-dark) 6%, transparent);
        }

        /* Page sections (Login right panel) */
        .surface-white { background: var(--surface-white); color: var(--text-dark); }

        /* Table header row: cool gray, muted, small uppercase */
        .portal-card thead th {
            background: var(--surface-cool-gray);
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-cool-gray);
            white-space: nowrap;
        }
        .portal-card tbody td {
            color: var(--text-dark);
            vertical-align: middle;
        }
        .portal-card .table > :not(caption) > * > * {
            padding: var(--space-3) var(--space-4);
        }

        /* Flash message uses the status colors */
        .alert-success {
            background: color-mix(in srgb, var(--status-success) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--status-success) 35%, transparent);
            color: var(--text-dark);
            border-radius: var(--radius-md);
        }

        .text-on-blue { color: var(--text-on-blue); }
        .text-muted-on-blue { color: var(--text-muted-on-blue); }
        .bg-royal-blue { background: var(--bg-royal-blue); }
        .text-muted-token { color: var(--text-muted); }
        /* Muted text is light on the blue page, and gray inside white cards/tables */
        .text-muted { color: var(--text-muted-on-blue) !important; }
        .portal-card .text-muted,
        .feature-card .text-muted { color: var(--text-muted) !important; }
        .portal-card .table { color: var(--text-dark); }
        .mono { font-family: var(--font-mono); }

        .btn-accent, .btn-cyan {
            background: var(--accent-cyan);
            color: var(--text-on-blue);
            border: none;
            border-radius: var(--radius-md);
            min-height: 40px;
            font-weight: 600;
        }
        .btn-accent:hover, .btn-accent:focus,
        .btn-cyan:hover, .btn-cyan:focus {
            background: var(--accent-cyan-hover);
            color: var(--text-on-blue);
        }

        .form-control {
            min-height: 40px;
            background: var(--surface-cool-gray);
            border: 1px solid var(--border-cool-gray);
            border-radius: var(--radius-md);
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 0.2rem color-mix(in srgb, var(--accent-cyan) 25%, transparent);
        }
        .form-select {
            min-height: 40px;
            background-color: var(--surface-cool-gray);
            border: 1px solid var(--border-cool-gray);
            border-radius: var(--radius-md);
        }
        .form-label {
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: var(--space-2);
        }

        .feature-card {
            background: var(--surface-white);
            color: var(--text-dark);
            border-left: 3px solid var(--accent-cyan);
            border-radius: var(--radius-lg);
            padding: var(--space-6);
        }

        .school-year-badge {
            display: inline-block;
            background: var(--accent-cyan);
            color: var(--text-on-blue);
            border-radius: var(--radius-full);
            padding: 2px 10px;
            font-size: 0.875rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
{{-- Logged-in pages get the side navigation. Guests (login page) get full-width content. --}}
<div class="{{ auth()->check() ? 'd-flex' : '' }}">

    @auth
        <nav class="portal-sidebar offcanvas-lg offcanvas-start d-flex flex-column"
             id="portalNav" tabindex="-1" aria-labelledby="portalNavLabel">
            <div class="offcanvas-header d-lg-none">
                <h5 class="offcanvas-title text-white" id="portalNavLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#portalNav" aria-label="Close"></button>
            </div>

            <div class="p-4 d-none d-lg-block">
                <span class="fw-bold" style="font-family: var(--font-heading); font-size: 1.125rem;">Student Portal</span>
            </div>

            <ul class="nav flex-column mt-2">
                @if (auth()->user()->role === 'teacher')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.home') ? 'active' : '' }}"
                           href="{{ route('teacher.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}"
                           href="{{ route('teacher.students.index') }}">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.subjects.*') ? 'active' : '' }}"
                           href="{{ route('teacher.subjects.index') }}">Subjects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.marks.*') ? 'active' : '' }}"
                           href="{{ route('teacher.marks.index') }}">Marks</a>
                    </li>
                @elseif (auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}"
                           href="{{ route('admin.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                @endif
            </ul>

            <div class="mt-auto p-4 small" style="color: var(--text-muted-on-blue);">
                <div class="fw-semibold" style="color: var(--text-on-blue);">{{ auth()->user()->name }}</div>
                <div class="text-capitalize mb-3">{{ auth()->user()->role }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light w-100">Log out</button>
                </form>
            </div>
        </nav>
    @endauth

    <div class="flex-grow-1 {{ auth()->check() ? 'p-3 p-md-4' : '' }}" style="min-width: 0;">
        @auth
            <div class="d-flex align-items-center gap-3 mb-4 d-lg-none">
                <button class="btn btn-accent d-lg-none" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#portalNav" aria-controls="portalNav">
                    Menu
                </button>
            </div>

            <img src="{{ asset('images/school-banner.jpg') }}"
                 alt="Republic of the Philippines, Department of Science and Technology, Philippine Science High School System"
                 class="img-fluid w-100 mb-4"
                 style="border-radius: var(--radius-lg);">
        @endauth

        @if (session('status'))
            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
