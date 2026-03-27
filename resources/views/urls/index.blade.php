@extends('layouts.app')

@section('title', 'Kelola Link - Ringkas.in')

@section('content')
    @php
        $activeKey = isset($key) ? (string) $key : '';
        $totalLinks = $urls->count();
        $totalQr = $urls->whereNotNull('qr_path')->count();
        $totalClicks = $urls->sum('click_count');
    @endphp

    <section class="section-enter max-w-6xl mx-auto">
        <div class="mb-5 text-center">
            <h2 class="text-3xl sm:text-5xl font-bold text-slate-900">Kelola Link</h2>
            <p class="mt-2 text-sm sm:text-xl text-slate-600">Lihat semua tautan yang sudah dihasilkan atau kelola tautan anda!</p>
        </div>

        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-6 surface-hover">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 mb-5 surface-hover">
                <p class="text-lg font-semibold text-slate-800">◉ Filter dengan Delete Key</p>
                <p class="mt-1 text-xs text-slate-500">Masukkan delete key anda untuk melihat dan kelola link anda. Biarkan kosong untuk melihat semua tautan publik.</p>

                <form action="{{ route('urls.search') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="text"
                            id="key"
                            name="key"
                            value="{{ old('key', $activeKey) }}"
                            class="focus-ring w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="Masukkan Delete Key (e.g., akusukamakankabkso)"
                            required
                        >
                        <button type="submit" class="focus-ring interactive-press rounded-xl bg-blue-600 bg-linear-to-r from-blue-600 to-violet-600 px-6 py-2.5 text-sm font-semibold text-white hover:brightness-110 transition">🔍 Cari</button>
                    </div>
                </form>
            </div>

            <div class="grid sm:grid-cols-3 gap-4 mb-5">
                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-500 text-xl">🔗</span>
                        <div>
                            <p class="text-4xl font-bold text-slate-900">{{ $totalLinks }}</p>
                            <p class="text-sm font-semibold text-slate-600">Total Link</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-fuchsia-100 text-fuchsia-600 text-xl">▦</span>
                        <div>
                            <p class="text-4xl font-bold text-slate-900">{{ $totalQr }}</p>
                            <p class="text-sm font-semibold text-slate-600">QR Code</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 text-xl">↗</span>
                        <div>
                            <p class="text-4xl font-bold text-slate-900">{{ $totalClicks }}</p>
                            <p class="text-sm font-semibold text-slate-600">Total Clicks</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($urls->isEmpty())
                <div class="text-center py-10 rounded-2xl border border-dashed border-slate-300 bg-white">
                    <p class="text-slate-500 text-lg mb-4">Belum ada URL yang ditemukan.</p>
                    <a href="{{ route('urls.create') }}" class="inline-block rounded-xl bg-blue-600 bg-linear-to-r from-blue-600 to-violet-600 text-white px-6 py-3 font-semibold hover:brightness-110 transition">
                        Buat URL Pendek
                    </a>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Judul</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Tipe</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Click</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Dibuat</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="links-table-body">
                                @foreach($urls as $url)
                                    @php
                                        $isQr = !empty($url->qr_path);
                                    @endphp
                                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-semibold text-slate-900">{{ \Illuminate\Support\Str::limit($url->original_url, 32) }}</p>
                                            <p class="text-xs text-slate-500 mt-1 break-all">{{ $url->original_url }}</p>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            @if($isQr)
                                                <span class="inline-flex rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-semibold text-fuchsia-700">▦ QR</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">🔗 URL</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 align-top font-semibold text-slate-900">{{ $url->click_count }}</td>
                                        <td class="px-4 py-4 align-top text-slate-600">{{ optional($url->created_at)->format('d-m-Y') ?? 'N/A' }}</td>
                                        <td class="px-4 py-4 align-top">
                                            <form action="{{ route('urls.destroy', $url->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin hapus URL ini?');">
                                                @csrf
                                                @method('DELETE')
                                                @if($activeKey !== '')
                                                    <input type="hidden" name="deletion_key" value="{{ $activeKey }}">
                                                @endif
                                                <button
                                                    type="submit"
                                                    class="delete-btn focus-ring interactive-press rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-sm font-semibold text-rose-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                    {{ $activeKey === '' ? 'disabled' : '' }}
                                                >
                                                    🗑
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>

@push('scripts')
    <script>
        (function () {
            // keep page script block for future interactive enhancements
        })();
    </script>
@endpush
@endsection
