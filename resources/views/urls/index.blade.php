@extends('layouts.app')

@section('title', 'Kelola Link - Ringkas.in')

@section('content')
    @php
        $activeKey = isset($key) ? (string) $key : '';
        $totalLinks = $urls->count();
        $totalQr = $urls->count();
        $totalClicks = $urls->sum('click_count');
        $maxClicks = max(1, (int) $urls->max('click_count'));
    @endphp

    <section class="section-enter">
        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-8 surface-hover">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-indigo-600">Link Management</p>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-snugger text-slate-900 mt-1">Kelola semua tautan kamu</h2>
                    <p class="text-sm sm:text-base text-slate-600 mt-1.5">Gunakan delete key untuk menampilkan link milikmu dan mengaktifkan tombol hapus secara aman.</p>
                </div>
                <a href="{{ route('urls.create') }}" class="focus-ring interactive-press inline-flex items-center rounded-xl bg-slate-900 text-white text-sm font-semibold px-4 py-2.5 hover:bg-slate-700 transition">+ Buat Link Baru</a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 mb-5 surface-hover">
                <form action="{{ route('urls.search') }}" method="POST" class="space-y-2">
                    @csrf
                    <label for="key" class="block text-sm font-semibold text-slate-700">Filter dengan Delete Key</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="text"
                            id="key"
                            name="key"
                            value="{{ old('key', $activeKey) }}"
                            class="focus-ring w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="Masukkan delete key kamu"
                            required
                        >
                        <button type="submit" class="focus-ring interactive-press rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:brightness-110 transition">Cari</button>
                        <a href="{{ route('urls.index') }}" class="focus-ring interactive-press rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition text-center">Reset</a>
                    </div>
                </form>
                @if($activeKey !== '')
                    <p class="mt-2 text-xs text-slate-600">Filter aktif untuk key: <span class="font-semibold text-slate-800">{{ $activeKey }}</span></p>
                @else
                    <p class="mt-2 text-xs text-slate-500">Masukkan delete key untuk menampilkan link kamu dan mengaktifkan tombol hapus.</p>
                @endif
            </div>

            <div class="grid sm:grid-cols-3 gap-4 mb-5">
                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <p class="text-xs uppercase tracking-wider text-slate-500">Total Link</p>
                    <p id="stat-links" class="mt-2 text-3xl font-bold text-slate-900">{{ $totalLinks }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <p class="text-xs uppercase tracking-wider text-slate-500">QR Code</p>
                    <p id="stat-qr" class="mt-2 text-3xl font-bold text-slate-900">{{ $totalQr }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4 surface-hover">
                    <p class="text-xs uppercase tracking-wider text-slate-500">Total Clicks</p>
                    <p id="stat-clicks" class="mt-2 text-3xl font-bold text-slate-900">{{ $totalClicks }}</p>
                </div>
            </div>

            @if($urls->isEmpty())
                <div class="text-center py-10 rounded-2xl border border-dashed border-slate-300 bg-white">
                    <p class="text-slate-500 text-lg mb-4">Belum ada URL yang dibuat</p>
                    <a href="{{ route('urls.create') }}" class="inline-block rounded-xl bg-linear-to-r from-blue-600 to-violet-600 text-white px-6 py-3 font-semibold hover:brightness-110 transition">
                        Buat URL Pendek Sekarang
                    </a>
                </div>
            @else
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Judul</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Link</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Click</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Dibuat</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="links-table-body">
                                @foreach($urls as $url)
                                    @php
                                        $shortCode = $url->custom_alias ?? $url->short_code;
                                        $shortLink = route('urls.show', $shortCode);
                                        $clickPercent = min(100, (int) round(($url->click_count / $maxClicks) * 100));
                                    @endphp
                                    <tr
                                        class="border-b border-slate-100 hover:bg-slate-50 transition link-row"
                                        data-short-url="{{ $shortLink }}"
                                        data-clicks="{{ $url->click_count }}"
                                    >
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-semibold text-slate-900">{{ \Illuminate\Support\Str::limit($url->original_url, 38) }}</p>
                                            <p class="text-xs text-slate-500 mt-1 break-all">{{ $url->original_url }}</p>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <code class="rounded-lg bg-indigo-50 px-2.5 py-1 text-indigo-700 font-semibold">/{{ $shortCode }}</code>
                                                <button
                                                    type="button"
                                                    class="copy-btn focus-ring interactive-press rounded-lg border border-indigo-200 bg-white px-2.5 py-1 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition"
                                                    data-url="{{ $shortLink }}"
                                                >
                                                    Copy
                                                </button>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <p class="font-semibold text-slate-900 mb-2">{{ $url->click_count }}</p>
                                            <div class="h-2 w-28 rounded-full bg-slate-200 overflow-hidden">
                                                <div class="h-full rounded-full bg-linear-to-r from-blue-500 to-violet-500 click-progress" style="width: {{ $clickPercent }}%;"></div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 align-top text-slate-600">
                                            {{ optional($url->created_at)->format('d-m-Y') ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <div class="flex flex-wrap gap-2">
                                                <button
                                                    type="button"
                                                    class="qr-view-btn focus-ring interactive-press rounded-lg border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 hover:bg-sky-100 transition"
                                                    data-url="{{ $shortLink }}"
                                                >
                                                    QR
                                                </button>

                                                <form action="{{ route('urls.destroy', $url->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin hapus URL ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    @if($activeKey !== '')
                                                        <input type="hidden" name="deletion_key" value="{{ $activeKey }}">
                                                    @endif
                                                    <button
                                                        type="submit"
                                                        class="delete-btn focus-ring interactive-press rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                        {{ $activeKey === '' ? 'disabled' : '' }}
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
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

    <div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 px-4 backdrop-blur-sm">
        <div class="w-full max-w-sm rounded-2xl bg-white p-5 shadow-2xl section-enter">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold text-slate-900">QR Code</h3>
                <button id="close-qr-modal" class="focus-ring interactive-press rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-100">Close</button>
            </div>
            <img id="qr-modal-image" src="" alt="QR Code" class="mx-auto h-56 w-56 rounded-xl border border-slate-200 p-2">
            <a id="qr-modal-download" href="#" download="ringkasin-qr.png" class="focus-ring interactive-press mt-4 block rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:brightness-110 transition">Download QR Code</a>
        </div>
    </div>

@push('scripts')
    <script>
        (function () {
            const qrModal = document.getElementById('qr-modal');
            const qrModalImage = document.getElementById('qr-modal-image');
            const qrModalDownload = document.getElementById('qr-modal-download');
            const closeQrModal = document.getElementById('close-qr-modal');

            const closeModal = () => {
                if (!qrModal) return;
                qrModal.classList.add('hidden');
                qrModal.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            };

            const openModal = () => {
                if (!qrModal) return;
                qrModal.classList.remove('hidden');
                qrModal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
            };

            document.querySelectorAll('.copy-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const shortUrl = button.getAttribute('data-url') || '';
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(shortUrl).then(() => {
                            const previous = button.textContent;
                            button.textContent = 'Copied';
                            setTimeout(() => {
                                button.textContent = previous;
                            }, 1200);
                        });
                    } else {
                        window.prompt('Copy this URL:', shortUrl);
                    }
                });
            });

            document.querySelectorAll('.qr-view-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const url = button.getAttribute('data-url') || '';
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=280x280&ecc=H&data=${encodeURIComponent(url)}`;
                    if (qrModalImage) qrModalImage.src = qrUrl;
                    if (qrModalDownload) qrModalDownload.href = qrUrl;
                    openModal();
                });
            });

            if (closeQrModal && qrModal) {
                closeQrModal.addEventListener('click', closeModal);
            }

            if (qrModal) {
                qrModal.addEventListener('click', (event) => {
                    if (event.target === qrModal) {
                        closeModal();
                    }
                });
            }

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

        })();
    </script>
@endpush
@endsection
