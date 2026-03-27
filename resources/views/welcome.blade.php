<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ringkas.in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-linear-to-br from-sky-50 via-indigo-50 to-violet-100 text-slate-800" style="font-family: 'Space Grotesk', ui-sans-serif, system-ui, sans-serif;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <div class="rounded-3xl border border-white/70 bg-white/80 backdrop-blur-md p-6 sm:p-8 shadow-xl">
            <p class="inline-flex rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">Ringkas.in</p>
            <h1 class="mt-4 text-4xl sm:text-5xl font-bold bg-linear-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">URL Shortener + QR Generator</h1>
            <p class="mt-3 text-slate-600 max-w-2xl">Satu platform untuk merapikan URL panjang, membuat QR code instan, dan mengelola performa link secara profesional.</p>

            <div class="mt-7 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Home</p>
                    <p class="mt-2 text-lg font-bold">Preview hasil URL & QR</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Short URL</p>
                    <p class="mt-2 text-lg font-bold">Alias check real-time</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Generate QR</p>
                    <p class="mt-2 text-lg font-bold">URL/Text + Download PNG</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wide text-slate-500">Kelola Link</p>
                    <p class="mt-2 text-lg font-bold">Filter key + statistik klik</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('urls.home') }}" class="inline-flex rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white hover:brightness-110 transition">Masuk Aplikasi</a>
                <a href="{{ route('urls.create') }}" class="inline-flex rounded-xl border border-indigo-200 bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition">Buat Short URL</a>
            </div>
        </div>
    </div>
</body>
</html>
