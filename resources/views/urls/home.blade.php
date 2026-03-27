@extends('layouts.app')

@section('title', 'Home - Ringkas.in')

@section('content')
    @php
        $preview = $urls->first();
        $totalLinks = $urls->count();
        $totalClicks = $urls->sum('click_count');
    @endphp

    <section class="section-enter mb-7">
        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-8">
            <div class="grid lg:grid-cols-2 gap-7 items-start">
                <div>
                    <p class="inline-flex items-center rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-semibold tracking-widest text-indigo-700">Homepage</p>
                    <h2 class="mt-4 text-3xl sm:text-5xl leading-tight font-bold tracking-snugger text-slate-900">Ayo Pendekkan URLmu dengan Ringkasin!</h2>
                    <p class="mt-3 text-sm sm:text-base text-slate-600">Buat tautan pendek dan QR code dalam hitungan detik, tampil premium, dan mudah dibagikan ke siapa pun.</p>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <p class="text-base font-bold text-slate-900">Sangat Cepat</p>
                            <p class="mt-1 text-xs text-slate-500">URL panjang langsung jadi short link</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <p class="text-base font-bold text-slate-900">Custom Alias</p>
                            <p class="mt-1 text-xs text-slate-500">Cek alias tersedia secara real-time</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <p class="text-base font-bold text-slate-900">Klik Track</p>
                            <p class="mt-1 text-xs text-slate-500">Pantau klik semua link kamu</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('urls.create') }}" class="inline-flex items-center justify-center rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-300/40 hover:brightness-105 transition">Buka Short URL Page</a>
                        <a href="{{ route('urls.qr') }}" class="inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-white px-5 py-2.5 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition">Buka QR Page</a>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                        <p class="text-sm text-slate-500">Preview Hasil URL Pendek</p>
                        @if($preview)
                            <p class="mt-2 text-sm sm:text-base text-slate-900 font-semibold break-all">{{ route('urls.show', $preview->custom_alias ?? $preview->short_code) }}</p>
                            <p class="mt-2 text-xs text-slate-500">Dibuat {{ optional($preview->created_at)->format('d M Y') ?? 'tanpa tanggal' }}</p>
                        @else
                            <p class="mt-2 text-slate-600">Belum ada data. Buat URL pertama kamu.</p>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                        <p class="text-sm text-slate-500">Preview Hasil QR</p>
                        @if($preview)
                            <img
                                src="https://api.qrserver.com/v1/create-qr-code/?size=168x168&ecc=H&data={{ urlencode(route('urls.show', $preview->custom_alias ?? $preview->short_code)) }}"
                                alt="Preview QR"
                                class="mt-3 h-32 w-32 rounded-lg border border-slate-200"
                            >
                        @else
                            <div class="mt-3 h-32 w-32 rounded-lg border border-dashed border-slate-300 grid place-content-center text-xs text-slate-400">No QR yet</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-enter">
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="glass-card rounded-2xl border border-white/70 p-5 shadow-soft">
                <p class="text-xs uppercase tracking-widest text-slate-500">Total Link</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalLinks }}</p>
            </div>
            <div class="glass-card rounded-2xl border border-white/70 p-5 shadow-soft">
                <p class="text-xs uppercase tracking-widest text-slate-500">Total Clicks</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalClicks }}</p>
            </div>
        </div>
    </section>
@endsection
