@extends('layouts.app')

@section('title', 'Home - Ringkas.in')

@section('content')
    @php
        $preview = $urls->first();
        $shortCode = $preview ? ($preview->custom_alias ?? $preview->short_code) : 'abc123xyz';
        $previewShortLink = $preview ? route('urls.show', $shortCode) : 'ringkas.in/abc123xyz';
        $previewOriginal = $preview ? $preview->original_url : 'https://www.example.com/very-long-url/with/many/parameters';
        $previewDate = $preview && $preview->created_at ? $preview->created_at->translatedFormat('d F Y') : '26 Maret 2026';
    @endphp

    <section class="section-enter">
        <div class="text-center">
            <h2 class="text-4xl md:text-6xl font-bold tracking-tight text-black">Ayo Pendekkan URLmu dengan Ringkasin!</h2>
            <p class="mt-3 text-base sm:text-xl leading-snug text-slate-800 max-w-6xl mx-auto">Buat tautan pendek dan kode QR yang mudah diingat secara instan. Tidak perlu masuk, sepenuhnya gratis, dan siap digunakan segera!</p>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-3">
            <article class="glass-card p-5 sm:p-6 section-enter">
                <div class="flex items-center gap-3">
                    <svg class="h-9 w-9 text-black" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5v14l7-7-7-7zM13 5v14l7-7-7-7z"/></svg>
                    <h3 class="text-3xl md:text-5xl font-bold text-black">Sangat Cepat</h3>
                </div>
                <p class="mt-3 text-base leading-snug text-slate-600">Buat URL pendek dan kode QR dalam hitungan detik. Tidak perlu pendaftaran atau langkah yang rumit.</p>
            </article>

            <article class="glass-card p-5 sm:p-6 section-enter">
                <div class="flex items-center gap-3">
                    <svg class="h-9 w-9 text-black" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z"/></svg>
                    <h3 class="text-3xl md:text-5xl font-bold text-black">Custom Alias</h3>
                </div>
                <p class="mt-3 text-base leading-snug text-slate-600">Pilih kode pendek custom Anda sendiri atau biarkan kami menghasilkan kode unik untuk Anda secara otomatis.</p>
            </article>

            <article class="glass-card p-5 sm:p-6 section-enter">
                <div class="flex items-center gap-3">
                    <svg class="h-9 w-9 text-black" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l6-6 4 4 6-8"/><path stroke-linecap="round" stroke-linejoin="round" d="M20 10V4h-6"/></svg>
                    <h3 class="text-3xl md:text-5xl font-bold text-black">Klik Track</h3>
                </div>
                <p class="mt-3 text-base leading-snug text-slate-600">Pantau berapa kali tautan yang dipendekkan diklik dengan statistik publik.</p>
            </article>
        </div>

        <h3 class="mt-7 text-center text-4xl md:text-6xl font-bold text-black">Apa yang kamu dapatkan?</h3>

        <div class="mt-6 grid gap-5 lg:grid-cols-2">
            <article class="glass-card p-5 sm:p-6">
                <h4 class="flex items-center gap-2 text-3xl md:text-5xl font-bold text-black">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14H7a5 5 0 010-10h3m4 0h3a5 5 0 010 10h-3m-7 0h8"/></svg>
                    Hasil URL Pendek
                </h4>

                <p class="mt-4 text-lg md:text-2xl text-slate-500">Original URL:</p>
                <p class="mt-1 break-all text-lg md:text-2xl text-slate-800 underline decoration-1">{{ $previewOriginal }}</p>

                <p class="mt-5 text-lg md:text-2xl text-slate-500">URL Pendek:</p>
                <p class="mt-1 break-all text-lg md:text-2xl text-slate-800">{{ $previewShortLink }}</p>

                <p class="mt-8 flex items-center gap-2 text-base md:text-xl text-slate-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                    Dibuat pada : {{ $previewDate }}
                </p>
            </article>

            <article class="glass-card p-5 sm:p-6 text-center">
                <h4 class="flex items-center gap-2 text-3xl md:text-5xl font-bold text-black">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="6" height="6"/><rect x="15" y="3" width="6" height="6"/><rect x="3" y="15" width="6" height="6"/><path d="M15 15h2v2h-2zM19 15h2v2h-2zM15 19h2v2h-2zM19 19h2v2h-2z"/></svg>
                    Hasil QR Code
                </h4>

                <div class="mt-4 grid place-items-center">
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=188x188&ecc=H&data={{ urlencode($previewShortLink) }}"
                        alt="Preview QR"
                        class="h-48 w-48 rounded-md border border-slate-300 bg-white p-2"
                    >
                </div>

                <p class="mt-3 text-base md:text-xl text-slate-500">Kode QR berkualitas tinggi siap diunduh</p>
            </article>
        </div>
    </section>
@endsection
