<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $validated = $request->validate([
            'original_url' => ['required', 'url'],
            'custom_alias' => ['nullable', 'alpha_dash', 'min:3', 'max:10', 'unique:urls,custom_alias'],
            'deletion_key' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/',
            ],
        ], [
            'deletion_key.regex' => 'Deletion key wajib memiliki minimal 1 huruf kapital, 1 angka, dan 1 karakter khusus.',
        ]);

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
        $qrBinary = QrCode::format('png')->size(300)->margin(1)->generate($shortUrl);
        $qrPath = "qr/{$url->id}.png";
        Storage::disk('public')->put($qrPath, $qrBinary);

        $url->update(['qr_path' => $qrPath]);

        return back()
            ->with('success', 'URL pendek berhasil dibuat')
            ->with('short_url', $shortUrl)
            ->with('deletion_key', $validated['deletion_key'])
            ->with('qr_url', Storage::url($qrPath));
    }

    /**
     * Search links by key.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:64'],
        ]);

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
        $validated = $request->validate([
            'deletion_key' => ['required', 'string', 'max:64'],
        ]);

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