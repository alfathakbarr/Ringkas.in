@extends('layouts.app')

@section('title', 'Short URL - Ringkas.in')

@section('content')
    @php
        $existingAliases = \App\Models\Url::query()
            ->whereNotNull('custom_alias')
            ->pluck('custom_alias')
            ->map(fn ($alias) => strtolower(trim($alias)))
            ->filter()
            ->values();
    @endphp

    <section class="section-enter max-w-4xl mx-auto">
        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-8">
            <div class="mb-6">
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest text-indigo-600">Short URL Page</p>
                <h2 class="mt-2 text-3xl sm:text-4xl font-bold tracking-snugger text-slate-900">Buat URL Pendek</h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600">Form lengkap dengan destination URL, title opsional, alias real-time check, auto 10-karakter, dan preview QR opsional.</p>
            </div>

            <form id="short-url-form" action="{{ route('urls.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="original_url" class="block mb-1.5 text-sm font-semibold text-slate-700">URL Tujuan <span class="text-rose-500">*</span></label>
                        <input
                            type="url"
                            name="original_url"
                            id="original_url"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="https://example.com/very/long/path"
                            value="{{ old('original_url') }}"
                            required
                        >
                    </div>

                    <div>
                        <label for="title" class="block mb-1.5 text-sm font-semibold text-slate-700">Judul (Opsional)</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="Judul link kamu"
                            value="{{ old('title') }}"
                        >
                    </div>

                    <div>
                        <label for="custom_alias" class="block mb-1.5 text-sm font-semibold text-slate-700">Custom Alias (Opsional)</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="custom_alias"
                                id="custom_alias"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pr-24 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                                placeholder="misal: promo-ramadan"
                                value="{{ old('custom_alias') }}"
                            >
                            <span id="alias-indicator" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Idle</span>
                        </div>
                        <p id="alias-message" class="mt-1.5 text-xs text-slate-500">Cek ketersediaan alias secara real-time (indikator: ✓ / ✗).</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="generated_code" class="block mb-1.5 text-sm font-semibold text-slate-700">Auto 10-char Code</label>
                        <input
                            type="text"
                            id="generated_code"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"
                            readonly
                        >
                        <button type="button" id="regen-code" class="mt-2 text-xs font-semibold text-indigo-700 hover:text-indigo-900">Generate Ulang</button>
                    </div>

                    <div>
                        <label for="deletion_key_preview" class="block mb-1.5 text-sm font-semibold text-slate-700">Delete Key (Preview)</label>
                        <input
                            type="text"
                            id="deletion_key_preview"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700"
                            readonly
                        >
                        <p class="mt-2 text-xs text-slate-500">Simpan key ini agar mudah memfilter di Kelola Link.</p>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5">
                    <label class="flex items-center justify-between gap-3">
                        <span>
                            <span class="block text-sm font-semibold text-slate-800">Generate QR untuk URL ini</span>
                            <span class="block text-xs text-slate-500">Aktifkan jika ingin preview QR sebelum submit.</span>
                        </span>
                        <input type="checkbox" id="enable-short-qr" class="h-5 w-5 accent-indigo-600" checked>
                    </label>

                    <div id="short-qr-preview-wrap" class="mt-4 hidden">
                        <img id="short-qr-preview-image" src="" alt="QR Preview" class="h-40 w-40 rounded-xl border border-slate-200 p-2 bg-white">
                        <a id="short-qr-download" href="#" download="ringkasin-short-url-qr.png" class="mt-3 inline-flex rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white hover:bg-indigo-700 transition">Download QR</a>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-1">
                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-linear-to-r from-blue-600 to-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-300/40 hover:brightness-110 transition"
                    >
                        Short Link
                    </button>
                    <a
                        href="{{ route('urls.home') }}"
                        class="flex-1 rounded-xl border border-slate-300 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
                    >
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            const existingAliases = @json($existingAliases);

            const aliasInput = document.getElementById('custom_alias');
            const aliasIndicator = document.getElementById('alias-indicator');
            const aliasMessage = document.getElementById('alias-message');
            const generatedCodeInput = document.getElementById('generated_code');
            const deletionKeyPreview = document.getElementById('deletion_key_preview');
            const regenCodeBtn = document.getElementById('regen-code');
            const shortUrlForm = document.getElementById('short-url-form');
            const originalUrlInput = document.getElementById('original_url');

            const shortQrToggle = document.getElementById('enable-short-qr');
            const shortQrWrap = document.getElementById('short-qr-preview-wrap');
            const shortQrImage = document.getElementById('short-qr-preview-image');
            const shortQrDownload = document.getElementById('short-qr-download');

            const randomString = (length) => {
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                let value = '';
                for (let i = 0; i < length; i += 1) {
                    value += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return value;
            };

            const nextUniqueCode = () => {
                let code = randomString(10);
                while (existingAliases.includes(code.toLowerCase())) {
                    code = randomString(10);
                }
                return code;
            };

            const setAliasStatus = (status, text) => {
                if (!aliasIndicator || !aliasMessage) return;

                if (status === 'ok') {
                    aliasIndicator.textContent = '✓ Available';
                    aliasIndicator.className = 'absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700';
                } else if (status === 'bad') {
                    aliasIndicator.textContent = '✗ Taken';
                    aliasIndicator.className = 'absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700';
                } else {
                    aliasIndicator.textContent = 'Idle';
                    aliasIndicator.className = 'absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500';
                }

                aliasMessage.textContent = text;
            };

            const validateAlias = () => {
                if (!aliasInput) return { valid: true, value: '' };

                const raw = aliasInput.value.trim();
                if (!raw) {
                    setAliasStatus('idle', 'Alias kosong: sistem akan menggunakan kode otomatis 10 karakter.');
                    return { valid: true, value: '' };
                }

                const alias = raw.toLowerCase();
                const aliasRegex = /^[a-z0-9-]{3,50}$/;

                if (!aliasRegex.test(alias)) {
                    setAliasStatus('bad', 'Alias harus 3-50 karakter, hanya huruf kecil, angka, dan tanda minus.');
                    return { valid: false, value: alias };
                }

                if (existingAliases.includes(alias)) {
                    setAliasStatus('bad', 'Alias ini sudah dipakai.');
                    return { valid: false, value: alias };
                }

                setAliasStatus('ok', 'Alias tersedia dan siap dipakai.');
                return { valid: true, value: alias };
            };

            const refreshGeneratedValues = () => {
                if (generatedCodeInput) {
                    generatedCodeInput.value = nextUniqueCode();
                }
                if (deletionKeyPreview) {
                    deletionKeyPreview.value = randomString(16);
                }
            };

            const refreshShortQrPreview = () => {
                if (!shortQrToggle || !shortQrWrap || !shortQrImage || !shortQrDownload || !originalUrlInput) return;

                const urlValue = originalUrlInput.value.trim();
                const show = shortQrToggle.checked && urlValue.length > 0;
                shortQrWrap.classList.toggle('hidden', !show);
                if (!show) return;

                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=260x260&ecc=H&data=${encodeURIComponent(urlValue)}`;
                shortQrImage.src = qrUrl;
                shortQrDownload.href = qrUrl;
            };

            if (aliasInput) {
                aliasInput.addEventListener('input', validateAlias);
            }

            if (regenCodeBtn) {
                regenCodeBtn.addEventListener('click', refreshGeneratedValues);
            }

            if (shortQrToggle) {
                shortQrToggle.addEventListener('change', refreshShortQrPreview);
            }

            if (originalUrlInput) {
                originalUrlInput.addEventListener('input', refreshShortQrPreview);
            }

            if (shortUrlForm) {
                shortUrlForm.addEventListener('submit', (event) => {
                    const aliasCheck = validateAlias();
                    if (!aliasCheck.valid) {
                        event.preventDefault();
                        return;
                    }

                    if (aliasInput && aliasInput.value.trim() === '' && generatedCodeInput) {
                        aliasInput.value = generatedCodeInput.value;
                    }
                });
            }

            refreshGeneratedValues();
            validateAlias();
            refreshShortQrPreview();
        })();
    </script>
@endpush
