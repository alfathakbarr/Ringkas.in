@extends('layouts.app')

@section('title', 'Generate QR - Ringkas.in')

@section('content')
    <section class="section-enter max-w-6xl mx-auto">
        <div class="mb-5 text-center">
            <h2 class="text-3xl sm:text-5xl font-bold text-slate-900">Generate QR Code</h2>
            <p class="mt-2 text-sm sm:text-xl text-slate-600">Buat kode QR untuk URL atau teks kustom yang dapat dipindai oleh siapa saja</p>
        </div>

        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-6 surface-hover">
            <form id="qr-generator-form" class="space-y-4">
                <label class="block text-sm font-semibold text-slate-700">Tipe Kode QR <span class="text-rose-500">*</span></label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-2">
                    <button type="button" id="qr-type-url" class="qr-type-btn focus-ring interactive-press rounded-xl border border-indigo-300 bg-indigo-50 px-4 py-3 text-left" data-type="url">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl text-blue-500">🔗</span>
                            <div>
                                <p class="text-2xl font-bold text-slate-900">URL</p>
                                <p class="text-sm text-slate-600">Link ke sebuah Website</p>
                            </div>
                        </div>
                    </button>

                    <button type="button" id="qr-type-text" class="qr-type-btn focus-ring interactive-press rounded-xl border border-slate-300 bg-white px-4 py-3 text-left" data-type="text">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl text-slate-900">T</span>
                            <div>
                                <p class="text-2xl font-bold text-slate-900">Text</p>
                                <p class="text-sm text-slate-600">Custom Text</p>
                            </div>
                        </div>
                    </button>
                </div>

                <div id="qr-url-wrap">
                    <label for="qr_url" class="block mb-1.5 text-sm font-semibold text-slate-700">URL Tujuan <span class="text-rose-500">*</span></label>
                    <input
                        type="url"
                        id="qr_url"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="https://contoh.com/url-panjang-kalian"
                    >
                </div>

                <div id="qr-text-wrap" class="hidden">
                    <label for="qr_text" class="block mb-1.5 text-sm font-semibold text-slate-700">Custom Text <span class="text-rose-500">*</span></label>
                    <textarea
                        id="qr_text"
                        rows="4"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Masukkan teks yang ingin di-scan"
                    ></textarea>
                </div>

                <div>
                    <label for="qr_title" class="block mb-1.5 text-sm font-semibold text-slate-700">Judul (opsional)</label>
                    <input
                        type="text"
                        id="qr_title"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Judul yang Keren Cuy..."
                    >
                </div>

                <p id="qr-helper" class="text-xs text-slate-500">Masukkan URL atau teks, lalu klik Generate.</p>

                <button type="submit" class="focus-ring interactive-press w-full rounded-xl bg-blue-600 bg-linear-to-r from-blue-600 to-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-300/40 hover:brightness-110 transition">Generate QR Code</button>
            </form>
        </div>

        <div id="qr-result" class="mt-6 hidden glass-card rounded-3xl border border-white/70 shadow-soft p-4 sm:p-6 section-enter">
            <p class="text-2xl sm:text-3xl font-bold text-slate-900">QR Code Anda sudah Siap!</p>
            <div class="mt-3 grid md:grid-cols-2 gap-4 items-start">
                <div class="rounded-2xl border border-indigo-100 bg-blue-50 p-4 text-center">
                    <img id="qr-result-image" src="" alt="Generated QR" class="mx-auto h-44 w-44 sm:h-56 sm:w-56 rounded-md border border-slate-200 bg-white p-2">
                    <p class="mt-3 text-base sm:text-lg text-slate-700">Scan untuk mengunjungi Link yang diringkasin!</p>
                    <a id="qr-result-download" href="#" download="ringkasin-qr.png" class="focus-ring interactive-press mt-3 inline-flex w-full sm:w-auto justify-center rounded-xl bg-indigo-600 px-5 py-2.5 text-base font-semibold text-white hover:bg-indigo-700 transition">Download QR Code</a>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-600">Judul</p>
                        <p id="qr-result-title" class="mt-1 rounded-lg bg-slate-100 px-3 py-2 text-base text-slate-700">Judul yang Kalian isi...</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-600">Tipe QR</p>
                        <div class="mt-1 rounded-lg bg-slate-100 px-3 py-2 text-sm text-slate-700">
                            <span id="qr-type-url-pill" class="inline-block rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">URL</span>
                            <span class="mx-2 text-slate-400">atau</span>
                            <span id="qr-type-text-pill" class="inline-block rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-semibold text-fuchsia-700">Text</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-600">Isi Konten</p>
                        <p id="qr-result-content" class="mt-1 rounded-lg bg-slate-100 px-3 py-2 text-sm break-all text-slate-700">-</p>
                    </div>
                    <p class="text-base text-slate-600">🕒 Dibuat pada : {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            const qrTypeButtons = Array.from(document.querySelectorAll('.qr-type-btn'));
            const qrUrlWrap = document.getElementById('qr-url-wrap');
            const qrTextWrap = document.getElementById('qr-text-wrap');
            const qrUrlInput = document.getElementById('qr_url');
            const qrTextInput = document.getElementById('qr_text');
            const qrTitleInput = document.getElementById('qr_title');
            const qrForm = document.getElementById('qr-generator-form');
            const qrResult = document.getElementById('qr-result');
            const qrResultImage = document.getElementById('qr-result-image');
            const qrResultTitle = document.getElementById('qr-result-title');
            const qrResultContent = document.getElementById('qr-result-content');
            const qrResultDownload = document.getElementById('qr-result-download');
            const qrHelper = document.getElementById('qr-helper');
            const qrTypeUrlPill = document.getElementById('qr-type-url-pill');
            const qrTypeTextPill = document.getElementById('qr-type-text-pill');

            let qrMode = 'url';

            const setQrMode = (mode) => {
                qrMode = mode;
                qrTypeButtons.forEach((button) => {
                    const active = button.dataset.type === mode;
                    button.classList.toggle('bg-indigo-50', active);
                    button.classList.toggle('border-indigo-200', active);
                    button.classList.toggle('text-indigo-700', active);
                    button.classList.toggle('bg-white', !active);
                    button.classList.toggle('border-slate-300', !active);
                    button.classList.toggle('text-slate-700', !active);
                });

                if (qrTypeUrlPill && qrTypeTextPill) {
                    qrTypeUrlPill.classList.toggle('opacity-40', mode !== 'url');
                    qrTypeTextPill.classList.toggle('opacity-40', mode !== 'text');
                }

                if (qrUrlWrap) qrUrlWrap.classList.toggle('hidden', mode !== 'url');
                if (qrTextWrap) qrTextWrap.classList.toggle('hidden', mode !== 'text');
            };

            const generateQr = (content) => `https://api.qrserver.com/v1/create-qr-code/?size=420x420&ecc=H&data=${encodeURIComponent(content)}`;

            const setHelper = (text, isError = false) => {
                if (!qrHelper) return;
                qrHelper.textContent = text;
                qrHelper.className = isError ? 'text-xs text-rose-600' : 'text-xs text-slate-500';
            };

            qrTypeButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    setQrMode(button.dataset.type || 'url');
                });
            });

            if (qrForm) {
                qrForm.addEventListener('submit', (event) => {
                    event.preventDefault();

                    const content = qrMode === 'url'
                        ? (qrUrlInput?.value || '').trim()
                        : (qrTextInput?.value || '').trim();

                    if (!content) {
                        setHelper(qrMode === 'url' ? 'URL belum diisi.' : 'Teks belum diisi.', true);
                        return;
                    }

                    const qrUrl = generateQr(content);
                    if (qrResultImage) qrResultImage.src = qrUrl;
                    if (qrResultDownload) qrResultDownload.href = qrUrl;
                    if (qrResultTitle) qrResultTitle.textContent = (qrTitleInput?.value || '').trim() || '-';
                    if (qrResultContent) qrResultContent.textContent = content;
                    if (qrResult) qrResult.classList.remove('hidden');
                    setHelper('QR berhasil dibuat. Kamu bisa langsung download.', false);
                });
            }

            setQrMode('url');
        })();
    </script>
@endpush
