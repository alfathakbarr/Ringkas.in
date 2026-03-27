@extends('layouts.app')

@section('title', 'Kelola Link - Ringkas.in')

@section('content')
    @php
        $totalLinks = $urls->count();
        $totalQr = $urls->count();
        $totalClicks = $urls->sum('click_count');
        $maxClicks = max(1, (int) $urls->max('click_count'));
    @endphp

    <section class="section-enter">
        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                <div>
                    <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-indigo-600">Link Management</p>
                    <h2 class="text-3xl sm:text-4xl font-bold tracking-snugger text-slate-900 mt-1">Kelola semua tautan kamu</h2>
                    <p class="text-sm sm:text-base text-slate-600 mt-1.5">Gunakan delete key untuk menampilkan link milikmu dan mengaktifkan tombol hapus secara aman.</p>
                </div>
                <a href="{{ route('urls.create') }}" class="inline-flex items-center rounded-xl bg-slate-900 text-white text-sm font-semibold px-4 py-2.5 hover:bg-slate-700 transition">+ Buat Link Baru</a>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 mb-5">
                <label for="delete-key-filter" class="block text-sm font-semibold text-slate-700 mb-2">Filter dengan Delete Key</label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        id="delete-key-filter"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Masukkan delete key kamu"
                    >
                    <button id="clear-filter" type="button" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">Clear</button>
                </div>
                <p id="filter-hint" class="mt-2 text-xs text-slate-500">Delete akan aktif saat key cocok dengan data baris.</p>
            </div>

            <div class="grid sm:grid-cols-3 gap-4 mb-5">
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wider text-slate-500">Total Link</p>
                    <p id="stat-links" class="mt-2 text-3xl font-bold text-slate-900">{{ $totalLinks }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    <p class="text-xs uppercase tracking-wider text-slate-500">QR Code</p>
                    <p id="stat-qr" class="mt-2 text-3xl font-bold text-slate-900">{{ $totalQr }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
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
                                        $rowDeleteKey = (string) ($url->deletion_key ?? '');
                                    @endphp
                                    <tr
                                        class="border-b border-slate-100 hover:bg-slate-50 transition link-row"
                                        data-delete-key="{{ strtolower($rowDeleteKey) }}"
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
                                                    class="copy-btn rounded-lg border border-indigo-200 bg-white px-2.5 py-1 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 transition"
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
                                                    class="qr-view-btn rounded-lg border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-semibold text-sky-700 hover:bg-sky-100 transition"
                                                    data-url="{{ $shortLink }}"
                                                >
                                                    QR
                                                </button>

                                                <form action="{{ route('urls.destroy', $url->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin hapus URL ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="delete-btn rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                        disabled
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

    <div id="qr-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
        <div class="w-full max-w-sm rounded-2xl bg-white p-5 shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold text-slate-900">QR Code</h3>
                <button id="close-qr-modal" class="rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-100">Close</button>
            </div>
            <img id="qr-modal-image" src="" alt="QR Code" class="mx-auto h-56 w-56 rounded-xl border border-slate-200 p-2">
            <a id="qr-modal-download" href="#" download="ringkasin-qr.png" class="mt-4 block rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:brightness-110 transition">Download QR Code</a>
        </div>
    </div>

@push('scripts')
    <script>
        (function () {
            const rows = Array.from(document.querySelectorAll('.link-row'));
            const filterInput = document.getElementById('delete-key-filter');
            const clearFilter = document.getElementById('clear-filter');
            const hint = document.getElementById('filter-hint');
            const statLinks = document.getElementById('stat-links');
            const statQr = document.getElementById('stat-qr');
            const statClicks = document.getElementById('stat-clicks');

            const qrModal = document.getElementById('qr-modal');
            const qrModalImage = document.getElementById('qr-modal-image');
            const qrModalDownload = document.getElementById('qr-modal-download');
            const closeQrModal = document.getElementById('close-qr-modal');

            const applyFilter = () => {
                const key = (filterInput?.value || '').trim().toLowerCase();
                let visibleCount = 0;
                let visibleClicks = 0;

                rows.forEach((row) => {
                    const rowKey = row.dataset.deleteKey || '';
                    const matches = key.length > 0 ? rowKey === key : true;
                    row.classList.toggle('hidden', !matches);

                    const deleteBtn = row.querySelector('.delete-btn');
                    if (deleteBtn) {
                        deleteBtn.disabled = !(key.length > 0 && matches);
                    }

                    if (matches) {
                        visibleCount += 1;
                        visibleClicks += Number(row.dataset.clicks || 0);
                    }
                });

                if (statLinks) statLinks.textContent = String(visibleCount);
                if (statQr) statQr.textContent = String(visibleCount);
                if (statClicks) statClicks.textContent = String(visibleClicks);

                if (hint) {
                    hint.textContent = key.length > 0
                        ? 'Filter aktif. Hanya data dengan delete key yang cocok ditampilkan dan bisa dihapus.'
                        : 'Delete akan aktif saat key cocok dengan data baris.';
                }
            };

            if (filterInput) {
                filterInput.addEventListener('input', applyFilter);
            }

            if (clearFilter) {
                clearFilter.addEventListener('click', () => {
                    if (filterInput) filterInput.value = '';
                    applyFilter();
                });
            }

            document.querySelectorAll('.copy-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const shortUrl = button.getAttribute('data-url') || '';
                    navigator.clipboard.writeText(shortUrl).then(() => {
                        const previous = button.textContent;
                        button.textContent = 'Copied';
                        setTimeout(() => {
                            button.textContent = previous;
                        }, 1200);
                    });
                });
            });

            document.querySelectorAll('.qr-view-btn').forEach((button) => {
                button.addEventListener('click', () => {
                    const url = button.getAttribute('data-url') || '';
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=280x280&ecc=H&data=${encodeURIComponent(url)}`;
                    if (qrModalImage) qrModalImage.src = qrUrl;
                    if (qrModalDownload) qrModalDownload.href = qrUrl;
                    if (qrModal) qrModal.classList.remove('hidden');
                    if (qrModal) qrModal.classList.add('flex');
                });
            });

            if (closeQrModal && qrModal) {
                closeQrModal.addEventListener('click', () => {
                    qrModal.classList.add('hidden');
                    qrModal.classList.remove('flex');
                });
            }

            if (qrModal) {
                qrModal.addEventListener('click', (event) => {
                    if (event.target === qrModal) {
                        qrModal.classList.add('hidden');
                        qrModal.classList.remove('flex');
                    }
                });
            }

            applyFilter();
        })();
    </script>
@endpush
@endsection
