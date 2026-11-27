<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Student Portal' }}</title>

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
            background: var(--surface-cool-gray);
            color: var(--text-dark);
            font-family: var(--font-body);
            font-size: 1rem;
            line-height: 1.6;
        }

        h1, h2, h3 { font-family: var(--font-heading); }
        h1 { font-size: 2.25rem; line-height: 1.2; font-weight: 700; }
        h2 { font-size: 1.5rem; line-height: 1.3; font-weight: 600; }
        h3 { font-size: 1.125rem; line-height: 1.4; font-weight: 600; }

        .portal-sidebar {
            background: var(--bg-royal-blue);
            color: var(--text-on-blue);
            width: 240px;
            min-height: 100vh;
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
            border-radius: var(--radius-lg);
            padding: var(--space-6);
        }

        .btn-accent {
            background: var(--accent-cyan);
            color: var(--text-dark);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
        }
        .btn-accent:hover { background: var(--accent-cyan-hover); color: var(--text-dark); }

        .mono { font-family: var(--font-mono); }
    </style>
</head>
<body>
<div class="d-flex">

    {{-- Side navigation: fixed on desktop, offcanvas on phones --}}
    <nav class="portal-sidebar offcanvas-lg offcanvas-start d-flex flex-column"
         id="portalNav" tabindex="-1" aria-labelledby="portalNavLabel">
        <div class="offcanvas-header d-lg-none">
            <h5 class="offcanvas-title text-white" id="portalNavLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#portalNav" aria-label="Close"></button>
        </div>

        <div class="p-4 d-none d-lg-block">
            <span class="fw-bold" style="font-family: var(--font-heading); font-size: 1.125rem;">Student Portal</span>
        </div>

        @auth
            <ul class="nav flex-column mt-2">
                @if (auth()->user()->role === 'teacher')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('teacher.home') ? 'active' : '' }}"
                           href="{{ route('teacher.home') }}">Home</a>
                    </li>
                @endif
            </ul>

            <div class="mt-auto p-4 small" style="color: var(--text-muted-on-blue);">
                <div class="fw-semibold" style="color: var(--text-on-blue);">{{ auth()->user()->name }}</div>
                <div class="text-capitalize">{{ auth()->user()->role }}</div>
            </div>
        @endauth
    </nav>

    {{-- Main content --}}
    <div class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <button class="btn btn-accent d-lg-none" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#portalNav" aria-controls="portalNav">
                Menu
            </button>
        </div>

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
