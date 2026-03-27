@extends('layouts.app')

@section('title', 'Generate QR - Ringkas.in')

@section('content')
    <section class="section-enter max-w-4xl mx-auto">
        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-8 surface-hover">
            <div class="mb-6">
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-indigo-600">QR Code Page</p>
                <h2 class="mt-2 text-3xl sm:text-4xl font-bold tracking-snugger text-slate-900">Generate QR Code</h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600">Pilih jenis URL atau Text, lalu buat QR instan dengan high error correction dan download PNG.</p>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-5">
                <button type="button" id="qr-type-url" class="qr-type-btn focus-ring interactive-press rounded-xl border border-indigo-200 bg-indigo-50 px-3 py-2.5 text-sm font-semibold text-indigo-700" data-type="url">URL</button>
                <button type="button" id="qr-type-text" class="qr-type-btn focus-ring interactive-press rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm font-semibold text-slate-700" data-type="text">Text</button>
            </div>

            <form id="qr-generator-form" class="space-y-4">
                <div id="qr-url-wrap">
                    <label for="qr_url" class="block mb-1.5 text-sm font-semibold text-slate-700">URL Tujuan</label>
                    <input
                        type="url"
                        id="qr_url"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="https://destination.com"
                    >
                </div>

                <div id="qr-text-wrap" class="hidden">
                    <label for="qr_text" class="block mb-1.5 text-sm font-semibold text-slate-700">Custom Text</label>
                    <textarea
                        id="qr_text"
                        rows="4"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Masukkan teks yang ingin di-scan"
                    ></textarea>
                </div>

                <div>
                    <label for="qr_title" class="block mb-1.5 text-sm font-semibold text-slate-700">Judul (Opsional)</label>
                    <input
                        type="text"
                        id="qr_title"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Label QR (opsional)"
                    >
                </div>

                <p id="qr-helper" class="text-xs text-slate-500">Masukkan URL atau teks, lalu klik Generate.</p>

                <button type="submit" class="focus-ring interactive-press w-full rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-300/40 hover:brightness-110 transition">Generate QR Code</button>
            </form>

            <div id="qr-result" class="mt-5 hidden rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 section-enter">
                <p class="text-sm font-semibold text-slate-900">QR Code Anda sudah siap.</p>
                <div class="mt-3 grid sm:grid-cols-[auto,1fr] gap-4 items-start">
                    <img id="qr-result-image" src="" alt="Generated QR" class="h-44 w-44 rounded-xl border border-slate-200 p-2">
                    <div class="space-y-2 text-sm text-slate-600">
                        <p id="qr-result-title">Judul: -</p>
                        <p id="qr-result-type">Tipe: -</p>
                        <p id="qr-result-content" class="break-all">Konten: -</p>
                        <a id="qr-result-download" href="#" download="ringkasin-qr.png" class="focus-ring interactive-press inline-flex rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-700 transition">Download QR Code</a>
                    </div>
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
            const qrResultType = document.getElementById('qr-result-type');
            const qrResultContent = document.getElementById('qr-result-content');
            const qrResultDownload = document.getElementById('qr-result-download');
            const qrHelper = document.getElementById('qr-helper');

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
                    if (qrResultTitle) qrResultTitle.textContent = `Judul: ${(qrTitleInput?.value || '').trim() || '-'}`;
                    if (qrResultType) qrResultType.textContent = `Tipe: ${qrMode.toUpperCase()}`;
                    if (qrResultContent) qrResultContent.textContent = `Konten: ${content}`;
                    if (qrResult) qrResult.classList.remove('hidden');
                    setHelper('QR berhasil dibuat. Kamu bisa langsung download.', false);
                });
            }

            setQrMode('url');
        })();
    </script>
@endpush
