<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ringkas.in - URL Shortener & QR Code Generator')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        glow: '0 12px 40px rgba(99, 102, 241, 0.2)',
                        soft: '0 18px 38px rgba(15, 23, 42, 0.08)',
                    },
                    letterSpacing: {
                        snugger: '-0.02em',
                    },
                },
            },
        };
    </script>
    <style>
        :root {
            --color-body-bg: #f0f9ff;
            --color-surface: #ffffff;
            --color-primary-start: #7c3aed;
            --color-primary-end: #a855f7;
            --color-nav-active-start: #6366f1;
            --color-nav-active-end: #a855f7;
            --color-logo-ringkas: #2563eb;
            --color-logo-in: #a855f7;
            --color-heading: #111827;
            --color-body-text: #1f2937;
            --color-muted: #6b7280;
            --color-input-border: #e5e7eb;
            --color-input-text: #1f2937;
            --color-input-placeholder: #9ca3af;
            --color-table-head: #bfdbfe;
            --color-tag-url-bg: #e0f2fe;
            --color-tag-url-text: #0369a1;
            --color-tag-qr-bg: #f3e8ff;
            --color-tag-qr-text: #7c3aed;
            --color-delete-bg: #fee2e2;
            --color-delete-icon: #ef4444;
            --radius-card: 12px;
            --radius-input: 8px;
            --radius-button: 8px;
            --radius-pill: 9999px;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            --focus-ring: 0 0 0 3px rgba(124, 58, 237, 0.15);
        }

        * {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        body {
            background: var(--color-body-bg) !important;
            color: var(--color-body-text) !important;
        }

        .max-w-7xl {
            max-width: 1100px !important;
        }

        main.max-w-7xl {
            padding-left: 24px !important;
            padding-right: 24px !important;
            padding-top: 24px !important;
            padding-bottom: 32px !important;
        }

        nav {
            background: #ffffff !important;
            border-bottom: 1px solid var(--color-input-border) !important;
            min-height: 64px;
            backdrop-filter: none;
        }

        nav > div.max-w-7xl {
            min-height: 64px;
            display: flex;
            align-items: center;
            max-width: 100% !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
        }

        nav > div.max-w-7xl > div {
            width: 100%;
        }

        .logo-ringkas,
        .logo-in {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .logo-ringkas {
            color: var(--color-logo-ringkas);
        }

        .logo-in {
            color: var(--color-logo-in);
        }

        #main-nav-tabs {
            background: transparent !important;
            padding: 0;
            gap: 4px;
        }

        #main-nav-tabs > a {
            color: var(--color-body-text) !important;
            background: transparent !important;
            border-radius: var(--radius-pill) !important;
            padding: 8px 20px !important;
            font-size: 16px;
            font-weight: 500;
        }

        section .mb-6 > p:last-child {
            font-size: 16px !important;
            color: var(--color-muted) !important;
        }

        #main-nav-tabs > a.text-white {
            color: #ffffff !important;
            background: linear-gradient(to right, var(--color-nav-active-start), var(--color-nav-active-end)) !important;
        }

        h1,
        h2,
        h3,
        h4 {
            color: var(--color-heading) !important;
            font-weight: 800 !important;
        }

        h1,
        h2 {
            font-size: clamp(32px, 3.2vw, 36px) !important;
            line-height: 1.2;
        }

        main > section > h3 {
            font-size: clamp(32px, 3.2vw, 36px) !important;
            line-height: 1.2;
        }

        .glass-card h3,
        .glass-card h4 {
            font-size: 18px !important;
            font-weight: 700 !important;
            line-height: 1.35;
        }

        p,
        li,
        td,
        th,
        label,
        span,
        a,
        button,
        input,
        textarea {
            color: var(--color-body-text);
        }

        label {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #374151 !important;
        }

        label span.text-rose-500 {
            color: #ef4444 !important;
        }

        .text-slate-500,
        .text-slate-600 {
            color: var(--color-muted) !important;
        }

        .text-indigo-600,
        .text-indigo-700,
        .text-indigo-900 {
            color: var(--color-muted) !important;
        }

        .glass-card {
            background: var(--color-surface) !important;
            border: 1px solid var(--color-input-border) !important;
            border-radius: var(--radius-card) !important;
            box-shadow: var(--card-shadow) !important;
        }

        .rounded-2xl,
        .rounded-3xl {
            border-radius: var(--radius-card) !important;
        }

        .border-slate-200,
        .border-slate-300,
        .border-white\/70,
        .border-dashed {
            border-color: var(--color-input-border) !important;
        }

        input[type='text'],
        input[type='url'],
        textarea,
        #key {
            border: 1px solid var(--color-input-border) !important;
            border-radius: var(--radius-input) !important;
            padding: 12px 16px !important;
            font-size: 14px !important;
            color: var(--color-input-text) !important;
            background: #ffffff !important;
            min-height: 44px;
        }

        input::placeholder,
        textarea::placeholder {
            color: var(--color-input-placeholder) !important;
        }

        input:focus,
        textarea:focus,
        input:focus-visible,
        textarea:focus-visible,
        .focus-ring:focus-visible {
            outline: none !important;
            border-color: var(--color-primary-start) !important;
            box-shadow: var(--focus-ring) !important;
        }

        #short-url-form > .flex button[type='submit'],
        #qr-generator-form button[type='submit'],
        form[action$='/manage-links'] button[type='submit'],
        #short-qr-download,
        #qr-result-download,
        #qr-modal-download {
            background: linear-gradient(to right, var(--color-primary-start), var(--color-primary-end)) !important;
            color: #ffffff !important;
            border-radius: var(--radius-button) !important;
            font-weight: 700 !important;
            font-size: 16px !important;
            border: none !important;
            min-height: 52px !important;
        }

        #short-url-form > .flex button[type='submit'],
        #qr-generator-form button[type='submit'] {
            width: 100%;
        }

        .copy-btn {
            background: var(--color-primary-start) !important;
            color: #ffffff !important;
            border-color: transparent !important;
            border-radius: 6px !important;
            padding: 8px !important;
        }

        code {
            background: var(--color-tag-url-bg) !important;
            color: var(--color-tag-url-text) !important;
            border-radius: var(--radius-pill) !important;
            padding: 2px 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
        }

        .qr-view-btn {
            background: var(--color-tag-qr-bg) !important;
            color: var(--color-tag-qr-text) !important;
            border-color: transparent !important;
            border-radius: var(--radius-pill) !important;
            padding: 2px 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
        }

        .delete-btn {
            background: var(--color-delete-bg) !important;
            color: var(--color-delete-icon) !important;
            border-color: transparent !important;
            border-radius: 8px !important;
        }

        thead.bg-slate-100 {
            background: var(--color-table-head) !important;
        }

        thead th {
            color: var(--color-body-text) !important;
            font-weight: 600 !important;
            font-size: 14px !important;
        }

        #links-table-body tr {
            background: #ffffff;
            border-bottom: 1px solid var(--color-input-border) !important;
        }

        #links-table-body tr:hover {
            background: #f9fafb !important;
        }

        #stat-links::before,
        #stat-qr::before,
        #stat-clicks::before {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            margin-right: 10px;
            font-size: 16px;
            vertical-align: middle;
        }

        #stat-links::before {
            content: '\1F517';
            background: #dbeafe;
        }

        #stat-qr::before {
            content: '\25A6';
            background: #f3e8ff;
        }

        #stat-clicks::before {
            content: '\2197';
            background: #dcfce7;
        }

        .text-xs {
            font-size: 12px !important;
        }

        .text-sm {
            font-size: 14px !important;
        }

        .page-enter,
        .section-enter {
            opacity: 1;
            transform: none;
            animation: none;
        }

        .surface-hover {
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .surface-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.12);
        }

        .interactive-press {
            transition: transform 0.15s ease;
        }

        .interactive-press:active {
            transform: translateY(1px);
        }

        @media (max-width: 640px) {
            nav > div.max-w-7xl {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }

            main.max-w-7xl {
                padding-left: 16px !important;
                padding-right: 16px !important;
                padding-top: 16px !important;
                padding-bottom: 24px !important;
            }

            .mobile-snap-nav {
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .mobile-snap-nav::-webkit-scrollbar {
                display: none;
            }

            #main-nav-tabs > a {
                font-size: 16px !important;
                padding: 8px 14px !important;
            }
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen bg-[#e8f1f4] text-slate-800">
    <nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <a href="{{ route('urls.home') }}" class="inline-flex items-end gap-2">
                        <span class="logo-ringkas">Ringkas</span><span class="logo-in">.in</span>
                    </a>
                    <p class="text-sm text-slate-600 sm:text-base">Ringkas URL & Generate QR Code Otomatis</p>
                </div>

                <div class="mobile-snap-nav flex items-center gap-2 rounded-2xl bg-white p-1" id="main-nav-tabs">
                    <a href="{{ route('urls.home') }}" class="focus-ring interactive-press px-4 py-2 text-lg sm:text-2xl leading-none font-semibold rounded-2xl whitespace-nowrap transition {{ request()->routeIs('urls.home') ? 'bg-blue-600 bg-linear-to-r from-blue-600 to-violet-400 text-white' : 'text-slate-900 hover:bg-slate-100' }}">Home</a>
                    <a href="{{ route('urls.create') }}" class="focus-ring interactive-press px-4 py-2 text-lg sm:text-2xl leading-none font-semibold rounded-2xl whitespace-nowrap transition {{ request()->routeIs('urls.create') ? 'bg-blue-600 bg-linear-to-r from-blue-600 to-violet-400 text-white' : 'text-slate-900 hover:bg-slate-100' }}">Short URL</a>
                    <a href="{{ route('urls.qr') }}" class="focus-ring interactive-press px-4 py-2 text-lg sm:text-2xl leading-none font-semibold rounded-2xl whitespace-nowrap transition {{ request()->routeIs('urls.qr') ? 'bg-blue-600 bg-linear-to-r from-blue-600 to-violet-400 text-white' : 'text-slate-900 hover:bg-slate-100' }}">Generate QR</a>
                    <a href="{{ route('urls.index') }}" class="focus-ring interactive-press px-4 py-2 text-lg sm:text-2xl leading-none font-semibold rounded-2xl whitespace-nowrap transition {{ request()->routeIs('urls.index') ? 'bg-blue-600 bg-linear-to-r from-blue-600 to-violet-400 text-white' : 'text-slate-900 hover:bg-slate-100' }}">Kelola Link</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-7 sm:py-8 page-enter">
        @if($message = session('success'))
            <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 shadow-sm">
                {{ $message }}
            </div>
        @endif

        @if($message = session('error'))
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700 shadow-sm">
                {{ $message }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700 shadow-sm">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-10 border-t border-slate-200 bg-white py-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2 text-sm text-slate-600">
            <p>&copy; 2026 Ringkas.in</p>
            <p>Professional URL Shortener & QR Code Generator</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
