<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ringkas.in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --color-body-bg: #f0f9ff;
            --color-surface: #ffffff;
            --color-primary-start: #7c3aed;
            --color-primary-end: #a855f7;
            --color-logo-ringkas: #2563eb;
            --color-logo-in: #a855f7;
            --color-heading: #111827;
            --color-body-text: #1f2937;
            --color-muted: #6b7280;
            --color-border: #e5e7eb;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        * {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        body {
            background: var(--color-body-bg) !important;
            color: var(--color-body-text);
        }

        .welcome-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 24px;
        }

        .welcome-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }

        .welcome-logo {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .welcome-logo .ringkas {
            color: var(--color-logo-ringkas);
        }

        .welcome-logo .in {
            color: var(--color-logo-in);
        }

        h1 {
            color: var(--color-heading);
            font-weight: 800;
            font-size: clamp(32px, 3.2vw, 36px);
        }

        p {
            color: var(--color-body-text);
        }

        .welcome-muted {
            color: var(--color-muted) !important;
        }

        .welcome-primary {
            background: linear-gradient(to right, var(--color-primary-start), var(--color-primary-end));
            color: #ffffff !important;
            border-radius: 8px;
            font-weight: 700;
        }

        .welcome-surface {
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: #ffffff;
            box-shadow: var(--card-shadow);
        }
    </style>
</head>
<body class="min-h-screen bg-linear-to-br from-sky-50 via-indigo-50 to-violet-100 text-slate-800">
    <div class="welcome-wrap">
        <div class="welcome-card rounded-3xl border border-white/70 bg-white/80 backdrop-blur-md p-6 sm:p-8 shadow-xl">
            <p class="welcome-logo inline-flex rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700"><span class="ringkas">Ringkas</span><span class="in">.in</span></p>
            <h1 class="mt-4 text-4xl sm:text-5xl font-bold text-slate-900">URL Shortener + QR Generator</h1>
            <p class="welcome-muted mt-3 text-slate-600 max-w-2xl">Satu platform untuk merapikan URL panjang, membuat QR code instan, dan mengelola performa link secara profesional.</p>

            <div class="mt-7 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="welcome-surface rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="welcome-muted text-xs uppercase tracking-wide text-slate-500">Home</p>
                    <p class="mt-2 text-lg font-bold">Preview hasil URL & QR</p>
                </div>
                <div class="welcome-surface rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="welcome-muted text-xs uppercase tracking-wide text-slate-500">Short URL</p>
                    <p class="mt-2 text-lg font-bold">Alias check real-time</p>
                </div>
                <div class="welcome-surface rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="welcome-muted text-xs uppercase tracking-wide text-slate-500">Generate QR</p>
                    <p class="mt-2 text-lg font-bold">URL/Text + Download PNG</p>
                </div>
                <div class="welcome-surface rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="welcome-muted text-xs uppercase tracking-wide text-slate-500">Kelola Link</p>
                    <p class="mt-2 text-lg font-bold">Filter key + statistik klik</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('urls.home') }}" class="welcome-primary inline-flex rounded-xl bg-blue-600 bg-linear-to-r from-blue-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white hover:brightness-110 transition">Masuk Aplikasi</a>
                <a href="{{ route('urls.create') }}" class="inline-flex rounded-xl border border-indigo-200 bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition">Buat Short URL</a>
            </div>
        </div>
    </div>
</body>
</html>
