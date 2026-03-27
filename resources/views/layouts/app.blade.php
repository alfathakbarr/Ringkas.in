<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ringkas.in - URL Shortener & QR Code Generator')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Space Grotesk', 'ui-sans-serif', 'system-ui', 'sans-serif'],
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
        .glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(8px);
        }

        .ringkas-grid {
            background-image:
                linear-gradient(to right, rgba(99, 102, 241, 0.08) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(99, 102, 241, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .page-enter {
            animation: ringkasFade 0.5s ease-out;
        }

        .surface-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .surface-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.1);
            border-color: rgba(99, 102, 241, 0.28);
        }

        .interactive-press {
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .interactive-press:active {
            transform: translateY(1px) scale(0.99);
        }

        .focus-ring:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .section-enter {
            opacity: 0;
            transform: translateY(10px);
            animation: ringkasSectionEnter 0.55s ease-out forwards;
        }

        .section-enter:nth-child(2) {
            animation-delay: 0.08s;
        }

        .section-enter:nth-child(3) {
            animation-delay: 0.16s;
        }

        @keyframes ringkasFade {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes ringkasSectionEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 640px) {
            .mobile-snap-nav {
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .mobile-snap-nav::-webkit-scrollbar {
                display: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .page-enter,
            .section-enter {
                animation: none;
                opacity: 1;
                transform: none;
            }

            .surface-hover,
            .interactive-press {
                transition: none;
            }
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen bg-linear-to-br from-sky-50 via-indigo-50 to-violet-100 text-slate-800 ringkas-grid">
    <div class="fixed inset-0 -z-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-16 -left-10 h-64 w-64 rounded-full bg-cyan-300/28 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-16 h-72 w-72 rounded-full bg-violet-400/26 blur-3xl"></div>
    </div>

    <nav class="sticky top-0 z-40 border-b border-white/60 bg-white/78 backdrop-blur-xl shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <a href="{{ route('urls.home') }}" class="inline-flex items-end gap-2">
                        <span class="text-3xl font-bold tracking-snugger leading-none bg-linear-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">Ringkas.in</span>
                    </a>
                    <p class="text-[11px] text-slate-500">Ringkas URL & Generate QR Code Otomatis</p>
                </div>

                <div class="mobile-snap-nav flex items-center gap-2 rounded-2xl border border-slate-200 bg-white p-1 shadow-sm" id="main-nav-tabs">
                    <a href="{{ route('urls.home') }}" class="focus-ring interactive-press px-3 py-1.5 text-sm font-semibold rounded-xl whitespace-nowrap transition {{ request()->routeIs('urls.home') ? 'bg-linear-to-r from-blue-500 to-violet-500 text-white shadow-glow' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Home</a>
                    <a href="{{ route('urls.create') }}" class="focus-ring interactive-press px-3 py-1.5 text-sm font-semibold rounded-xl whitespace-nowrap transition {{ request()->routeIs('urls.create') ? 'bg-linear-to-r from-blue-500 to-violet-500 text-white shadow-glow' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Short URL</a>
                    <a href="{{ route('urls.qr') }}" class="focus-ring interactive-press px-3 py-1.5 text-sm font-semibold rounded-xl whitespace-nowrap transition {{ request()->routeIs('urls.qr') ? 'bg-linear-to-r from-blue-500 to-violet-500 text-white shadow-glow' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Generate QR</a>
                    <a href="{{ route('urls.index') }}" class="focus-ring interactive-press px-3 py-1.5 text-sm font-semibold rounded-xl whitespace-nowrap transition {{ request()->routeIs('urls.index') ? 'bg-linear-to-r from-blue-500 to-violet-500 text-white shadow-glow' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">Kelola Link</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 page-enter">
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

    <footer class="mt-10 border-t border-white/70 bg-white/70 py-5 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-2 text-sm text-slate-500">
            <p>&copy; 2026 Ringkas.in</p>
            <p>Professional URL Shortener & QR Code Generator</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
