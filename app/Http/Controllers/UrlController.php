<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Throwable;

class UrlController extends Controller
{
    /**
     * Homepage.
     */
    public function home()
    {
        $urls = Url::latest()->get();

        return view('urls.home', compact('urls'));
    }

    /**
     * Short URL page.
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * QR generator page.
     */
    public function qr()
    {
        return view('urls.qr');
    }

    /**
     * Manage links page.
     */
    public function index()
    {
        $urls = Url::latest()->get();

        return view('urls.index', compact('urls'));
    }

    /**
     * Store new short URL.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'original_url' => ['required', 'url:http,https'],
                'use_custom_alias' => ['nullable', 'boolean'],
                'custom_alias' => ['nullable', 'alpha_dash', 'min:3', 'max:10', 'unique:urls,custom_alias'],
                'generate_qr' => ['nullable', 'boolean'],
                'deletion_key' => [
                    'required',
                    'string',
                    'min:8',
                    'max:64',
                    'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
                ],
            ],
            [
                'original_url.required' => 'URL tujuan wajib diisi.',
                'original_url.url' => 'URL tujuan harus valid dan menggunakan http/https.',

                'custom_alias.alpha_dash' => 'Alias hanya boleh berisi huruf, angka, strip, atau underscore.',
                'custom_alias.min' => 'Alias minimal :min karakter.',
                'custom_alias.max' => 'Alias maksimal :max karakter.',
                'custom_alias.unique' => 'Alias sudah digunakan, silakan pilih alias lain.',

                'deletion_key.required' => 'Deletion key wajib diisi.',
                'deletion_key.min' => 'Deletion key minimal :min karakter.',
                'deletion_key.max' => 'Deletion key maksimal :max karakter.',
                'deletion_key.regex' => 'Deletion key wajib memiliki minimal 1 huruf kapital, 1 angka, dan 1 karakter khusus.',
            ],
            [
                'original_url' => 'URL tujuan',
                'custom_alias' => 'alias',
                'generate_qr' => 'generate qr',
                'deletion_key' => 'deletion key',
            ]
        );

        $useCustomAlias = $request->boolean('use_custom_alias');
        $generateQr = $request->boolean('generate_qr');

        if (!$useCustomAlias) {
            $validated['custom_alias'] = null;
        }

        $shortCode = !empty($validated['custom_alias'])
            ? strtolower($validated['custom_alias'])
            : Url::generateShortCode();

        $isCodeUsed = Url::query()
            ->where('short_code', $shortCode)
            ->orWhere('custom_alias', $shortCode)
            ->exists();

        if ($isCodeUsed) {
            return back()
                ->withErrors(['custom_alias' => 'Alias atau kode sudah digunakan.'])
                ->withInput();
        }

        $keyHash = $this->hashDeletionKey($validated['deletion_key']);

        $url = Url::create([
            'original_url' => $validated['original_url'],
            'custom_alias' => $validated['custom_alias'] ?? null,
            'short_code' => $shortCode,
            'deletion_key' => $keyHash,
            'click_count' => 0,
        ]);

        $shortUrl = route('urls.show', $url->custom_alias ?? $url->short_code);
        $qrPath = null;
        $qrUrl = null;

        if ($generateQr) {
            try {
                $qrBinary = QrCode::format('png')->size(300)->margin(1)->generate($shortUrl);
                $qrPath = "qr/{$url->id}.png";
                Storage::disk('public')->put($qrPath, $qrBinary);
                $qrUrl = Storage::url($qrPath);
            } catch (Throwable $e) {
                report($e);
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=H&data=' . urlencode($shortUrl);
            }
        }

        $url->update(['qr_path' => $qrPath]);

        $redirect = back()
            ->with('success', 'URL pendek berhasil dibuat')
            ->with('short_url', $shortUrl)
            ->with('deletion_key', $validated['deletion_key']);

        if ($qrUrl) {
            $redirect->with('qr_url', $qrUrl);

            if (!$qrPath) {
                $redirect->with('error', 'QR lokal belum tersedia di server saat ini. Menampilkan QR fallback.');
            }
        }

        return $redirect;
    }

    /**
     * Search links by key.
     */
    public function search(Request $request)
    {
        $validated = $request->validate(
            [
                'key' => ['required', 'string', 'min:8', 'max:64'],
            ],
            [
                'key.required' => 'Deletion key wajib diisi.',
                'key.string' => 'Deletion key harus berupa teks.',
                'key.min' => 'Deletion key minimal :min karakter.',
                'key.max' => 'Deletion key maksimal :max karakter.',
            ],
            [
                'key' => 'deletion key',
            ]
        );

        $keyHash = $this->hashDeletionKey($validated['key']);

        $urls = Url::query()
            ->where('deletion_key', $keyHash)
            ->latest()
            ->get();

        return view('urls.index', [
            'urls' => $urls,
            'key' => $validated['key'],
        ]);
    }

    /**
     * Delete link by id.
     */
    public function destroy(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'deletion_key' => ['required', 'string', 'min:8', 'max:64'],
            ],
            [
                'deletion_key.required' => 'Deletion key wajib diisi untuk menghapus link.',
                'deletion_key.string' => 'Deletion key harus berupa teks.',
                'deletion_key.min' => 'Deletion key minimal :min karakter.',
                'deletion_key.max' => 'Deletion key maksimal :max karakter.',
            ],
            [
                'deletion_key' => 'deletion key',
            ]
        );

        $url = Url::findOrFail($id);
        $inputHash = $this->hashDeletionKey($validated['deletion_key']);

        if (!hash_equals((string) $url->deletion_key, $inputHash)) {
            return back()->with('error', 'Data tidak valid atau tidak memiliki akses.');
        }

        $url->delete();

        return back()->with('success', 'Link berhasil dihapus');
    }

    /**
     * POST access endpoint (tracking/API).
     */
    public function access(string $code)
    {
        $url = Url::where('short_code', $code)
            ->orWhere('custom_alias', $code)
            ->firstOrFail();

        return response()->json([
            'original_url' => $url->original_url,
        ]);
    }

    /**
     * Public redirect endpoint.
     */
    public function show(string $code)
    {
        $url = Url::where('short_code', $code)
            ->orWhere('custom_alias', $code)
            ->firstOrFail(); // otomatis 404 kalau tidak ditemukan

        $url->increment('click_count');

        return redirect()->to($url->original_url);
    }

    /**
     * Hash the deletion key.
     */
    private function hashDeletionKey(string $plainKey): string
    {
        return hash_hmac('sha256', trim($plainKey), (string) config('app.key'));
    }
}
