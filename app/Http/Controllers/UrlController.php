<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display homepage preview.
     */
    public function home()
    {
        $urls = Url::all();
        return view('urls.home', compact('urls'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $totalLinks = Url::count();
        // $totalClicks = Url::sum('click_count');
        // $recentUrls = Url::latest()->take(5)->get();

        // return view('home', compact('totalLinks', 'totalClicks', 'recentUrls'));
        
        // Sementara tampilkan semua URL untuk testing
        $urls = Url::all();
        return view('urls.index', compact('urls'));
    }

    public function shortUrlView()
    {
        return view('short-url');
    }

    public function qrView()
    {
        return view('generate-qr');
    }

    public function manageView()
    {
        $urls = Url::latest()->paginate(10);
        return view('manage', compact('urls'));
    }

    /**
     * Display QR generator page.
     */
    public function qr()
    {
        return view('urls.qr');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => ['required', 'url'],
            'custom_alias' => ['nullable', 'alpha_dash', 'min:3', 'max:50', 'unique:urls,custom_alias'],
        ]);

        $shortCode = $validated['custom_alias'] ?? Url::generateShortCode();

        $url = Url::create([
            'original_url' => $validated['original_url'],
            'custom_alias' => $validated['custom_alias'] ?? null,
            'short_code' => $shortCode,
            'deletion_key' => Str::upper(Str::random(12)),
            'click_count' => 0,
        ]);

        return back()->with('success', 'URL pendek berhasil dibuat')->with('short_url', route('url.redirect', $url->short_code));
    }

    public function search(Request $request)
    {
        $request->validate(['key' => ['required', 'string', 'max:100']]);
        $key = $request->key;

        $urls = Url::query()
            ->where('short_code', 'like', "%{$key}%")
            ->orWhere('custom_alias', 'like', "%{$key}%")
            ->orWhere('original_url', 'like', "%{$key}%")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('manage', compact('urls', 'key'));
    }

    public function destroy(string $id)
    {
        Url::findOrFail($id)->delete();
        return back()->with('success', 'Link berhasil dihapus');
    }

    public function access(string $code)
    {
        $url = Url::where('short_code', $code)
            ->orWhere('custom_alias', $code)
            ->firstOrFail();

        $url->increment('click_count');

        return response()->json([
            'original_url' => $url->original_url,
            'click_count' => $url->click_count,
        ]);
    }

    public function redirect(string $code)
    {
        $url = Url::where('short_code', $code)
            ->orWhere('custom_alias', $code)
            ->firstOrFail();

        $url->increment('click_count');

        return redirect()->away($url->original_url);
    }
}