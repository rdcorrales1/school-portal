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
            background: var(--surface-white);
            color: var(--text-dark);
            font-family: var(--font-body);
            font-size: 1rem;
            line-height: 1.6;
        }

        h1, h2, h3 { font-family: var(--font-heading); }
        h1 { font-size: 2.25rem; line-height: 1.2; font-weight: 700; }
        h2 { font-size: 1.5rem; line-height: 1.3; font-weight: 600; }
        h3 { font-size: 1.125rem; line-height: 1.4; font-weight: 600; }

        .text-on-blue { color: var(--text-on-blue); }
        .text-muted-on-blue { color: var(--text-muted-on-blue); }
        .bg-royal-blue { background: var(--bg-royal-blue); }
        .text-muted-token { color: var(--text-muted); }
        .mono { font-family: var(--font-mono); }

        .btn-cyan {
            background: var(--accent-cyan);
            color: var(--text-on-blue);
            border: none;
            border-radius: var(--radius-md);
            min-height: 40px;
            font-weight: 600;
        }
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
        .form-control:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 0.2rem rgba(6, 182, 212, 0.25);
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
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
