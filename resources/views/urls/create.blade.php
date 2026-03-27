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

        $aliasEnabled = old('use_custom_alias', '1') === '1';
        $qrEnabled = old('generate_qr', '1') === '1';
    @endphp

    <section class="section-enter max-w-4xl mx-auto">
        <div class="mb-6 text-center">
            <h2 class="mt-2 text-3xl sm:text-4xl font-bold tracking-snugger text-slate-900">Buat URL Pendek</h2>
            <p class="mt-2 text-sm sm:text-base text-slate-600">Perpendek URL panjang Anda dengan alias kustom atau kode yang dihasilkan otomatis</p>
        </div>

        <div class="glass-card rounded-3xl border border-white/70 shadow-soft p-5 sm:p-6 surface-hover">
            <form id="short-url-form" action="{{ route('urls.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <div class="md:col-span-2">
                        <label for="original_url" class="block mb-1.5 text-sm font-semibold text-slate-700">URL Tujuan <span class="text-rose-500">*</span></label>
                        <input
                            type="url"
                            name="original_url"
                            id="original_url"
                            class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="https://contoh.com/url-panjang-kalian"
                            value="{{ old('original_url') }}"
                            required
                        >
                    </div>
                </div>

                <div>
                    <div>
                        <label for="title" class="block mb-1.5 text-sm font-semibold text-slate-700">Judul (Opsional)</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                            placeholder="Judul link kamu"
                            value="{{ old('title') }}"
                        >
                    </div>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" id="use_custom_alias" name="use_custom_alias" value="1" class="h-3.5 w-3.5 accent-indigo-600" {{ $aliasEnabled ? 'checked' : '' }}>
                        Menggunakan Custom alias (atau 10 karakter unik akan di generate)
                    </label>
                </div>

                <div id="custom-alias-wrap" class="{{ $aliasEnabled ? '' : 'hidden' }}">
                    <label for="custom_alias" class="block mb-1.5 text-sm font-semibold text-slate-700">Custom Alias <span class="text-rose-500">*</span></label>
                    <div class="flex items-center gap-2">
                        <span class="text-slate-800 whitespace-nowrap">ringkas.in /</span>
                        <div class="relative flex-1">
                            <input
                                type="text"
                                name="custom_alias"
                                id="custom_alias"
                                class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 pr-24 text-sm outline-none focus:ring-2 focus:ring-indigo-400"
                                placeholder="Diisi apa aja boleh..."
                                value="{{ old('custom_alias') }}"
                                {{ $aliasEnabled ? '' : 'disabled' }}
                            >
                            <span id="alias-indicator" class="absolute right-3 top-1/2 -translate-y-1/2 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">Idle</span>
                        </div>
                    </div>
                    <p id="alias-message" class="mt-1.5 text-xs text-slate-500">Hanya huruf, angka, tanda hubung, dan garis bawah yang diperbolehkan</p>
                </div>

                <div>
                    <label for="deletion_key" class="block mb-1.5 text-sm font-semibold text-slate-700">Delete Key <span class="text-rose-500">*</span></label>
                    <input
                        type="text"
                        id="deletion_key"
                        name="deletion_key"
                        value="{{ old('deletion_key') }}"
                        class="focus-ring w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-400"
                        placeholder="Contoh: 2HLPNWN6 atau akusukamakankabkso"
                        required
                        minlength="8"
                        maxlength="64"
                        pattern="(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+"
                        title="Minimal 1 huruf kapital, 1 angka, dan 1 karakter khusus"
                    >
                    <p class="mt-1.5 text-xs text-slate-500">Simpan kunci ini! Anda akan membutuhkannya untuk menghapus tautan ini dari halaman Kelola Tautan.</p>
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" id="generate_qr" name="generate_qr" value="1" class="h-3.5 w-3.5 accent-indigo-600" {{ $qrEnabled ? 'checked' : '' }}>
                        Buat Kode QR untuk URL pendek ini
                    </label>
                </div>

                <div class="pt-1">
                    <button type="submit" class="focus-ring interactive-press w-full rounded-xl bg-blue-600 bg-linear-to-r from-blue-600 to-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-300/40 hover:brightness-110 transition">
                        Short Link
                    </button>
                </div>
            </form>
        </div>

        @if(session('short_url'))
            <div class="mt-6 glass-card rounded-3xl border border-white/70 shadow-soft p-4 sm:p-6 section-enter">
                <div class="grid gap-4 md:grid-cols-[1fr,1.1fr]">
                    <div>
                        <h3 class="text-2xl font-bold text-black">URL Pendek Anda sudah Siap!</h3>

                        <p class="mt-4 text-lg font-semibold text-slate-700">Judul</p>
                        <div class="mt-2 rounded-2xl bg-slate-100 px-4 py-2 text-base text-slate-800">
                            {{ session('title') !== '' ? session('title') : 'Judul yang Kalian isi...' }}
                        </div>

                        <p class="mt-4 text-lg font-semibold text-slate-700">URL Pendek</p>
                        <div class="mt-2 flex items-center gap-3">
                            <div class="flex-1 rounded-2xl border border-cyan-500 bg-cyan-100 px-4 py-3 text-base text-blue-700 break-all" id="short-url-result">{{ session('short_url') }}</div>
                            <button type="button" id="copy-short-url" class="focus-ring inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 text-white text-xl">⧉</button>
                        </div>

                        <p class="mt-4 text-lg font-semibold text-slate-700">Original URL</p>
                        <div class="mt-2 rounded-2xl bg-slate-100 px-4 py-3 text-base text-slate-500 break-all underline decoration-1">
                            {{ session('original_url') }}
                        </div>

                        <p class="mt-4 text-base text-slate-600">🕒 Dibuat pada : {{ session('created_at_label') }}</p>
                    </div>

                    <div class="rounded-3xl border border-fuchsia-100 bg-blue-50 p-4 text-center">
                        <h4 class="flex items-center gap-3 text-3xl font-bold text-black">
                            <span class="text-3xl">▦</span>
                            QR Code
                        </h4>

                        @php
                            $fallbackQr = 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&ecc=H&data=' . urlencode((string) session('short_url'));
                            $qrDisplayUrl = session('qr_url') ?: $fallbackQr;
                        @endphp

                        <img src="{{ $qrDisplayUrl }}" alt="QR Result" class="mx-auto mt-4 h-56 w-56 rounded-2xl border border-slate-300 bg-white p-2">
                        <p class="mt-3 text-xl text-slate-800">Scan untuk mengunjungi link yang diringkasin!</p>
                        <a href="{{ $qrDisplayUrl }}" target="_blank" id="qr-download-btn" class="focus-ring interactive-press mt-3 inline-flex rounded-2xl bg-indigo-600 px-6 py-2.5 text-xl font-semibold text-white">⤓ Download QR Code</a>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            const existingAliases = @json($existingAliases);

            const useCustomAliasCheckbox = document.getElementById('use_custom_alias');
            const customAliasWrap = document.getElementById('custom-alias-wrap');
            const aliasInput = document.getElementById('custom_alias');
            const aliasIndicator = document.getElementById('alias-indicator');
            const aliasMessage = document.getElementById('alias-message');
            const deletionKeyInput = document.getElementById('deletion_key');
            const shortUrlForm = document.getElementById('short-url-form');
            const generateQrCheckbox = document.getElementById('generate_qr');
            const copyShortUrlButton = document.getElementById('copy-short-url');
            const shortUrlResult = document.getElementById('short-url-result');

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

            const refreshAliasVisibility = () => {
                if (!useCustomAliasCheckbox || !customAliasWrap || !aliasInput) return;

                const enabled = useCustomAliasCheckbox.checked;
                customAliasWrap.classList.toggle('hidden', !enabled);
                aliasInput.disabled = !enabled;

                if (!enabled) {
                    aliasInput.value = '';
                    setAliasStatus('idle', 'Alias dimatikan: sistem akan membuat kode otomatis.');
                } else {
                    validateAlias();
                }
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

                const alias = raw;
                const aliasRegex = /^[A-Za-z0-9_-]{3,10}$/;

                if (!aliasRegex.test(alias)) {
                    setAliasStatus('bad', 'Alias harus 3-10 karakter dan hanya huruf, angka, underscore, atau tanda minus.');
                    return { valid: false, value: alias };
                }

                if (existingAliases.includes(alias.toLowerCase())) {
                    setAliasStatus('bad', 'Alias ini sudah dipakai.');
                    return { valid: false, value: alias };
                }

                setAliasStatus('ok', 'Alias tersedia dan siap dipakai.');
                return { valid: true, value: alias };
            };

            const refreshDeletionKey = () => {
                if (deletionKeyInput && !deletionKeyInput.value.trim()) {
                    deletionKeyInput.value = `Rk!${Math.floor(Math.random() * 10)}${randomString(9)}`;
                }
            };

            if (aliasInput) {
                aliasInput.addEventListener('input', validateAlias);
            }

            if (useCustomAliasCheckbox) {
                useCustomAliasCheckbox.addEventListener('change', refreshAliasVisibility);
            }

            if (generateQrCheckbox && generateQrCheckbox.value !== '1') {
                generateQrCheckbox.value = '1';
            }

            if (shortUrlForm) {
                shortUrlForm.addEventListener('submit', (event) => {
                    if (useCustomAliasCheckbox && useCustomAliasCheckbox.checked) {
                        const aliasCheck = validateAlias();
                        if (!aliasCheck.valid) {
                            event.preventDefault();
                            return;
                        }
                    }

                    if (!deletionKeyInput || !deletionKeyInput.value.trim()) {
                        event.preventDefault();
                    }
                });
            }

            if (copyShortUrlButton && shortUrlResult) {
                copyShortUrlButton.addEventListener('click', async () => {
                    const shortUrlText = shortUrlResult.textContent.trim();
                    if (!shortUrlText) return;

                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(shortUrlText);
                        const previous = copyShortUrlButton.textContent;
                        copyShortUrlButton.textContent = '✓';
                        setTimeout(() => {
                            copyShortUrlButton.textContent = previous;
                        }, 1000);
                    } else {
                        window.prompt('Copy this URL:', shortUrlText);
                    }
                });
            }

            refreshDeletionKey();
            refreshAliasVisibility();
            validateAlias();
        })();
    </script>
@endpush
