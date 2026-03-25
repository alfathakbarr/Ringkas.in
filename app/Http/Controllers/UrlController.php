<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = Url::all();
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
            'custom_alias' => 'nullable|string|unique:urls,custom_alias',
        ]);

        $url = new Url();
        $url->original_url = $request->original_url;
        $url->custom_alias = $request->custom_alias;
        $url->short_code = $request->custom_alias ?? Url::generateShortCode();
        $url->click_count = 0;
        $url->save();

        return redirect()->route('urls.index')
                       ->with('success', 'URL berhasil dibuat!');
    }

    /**
     * Display the specified resource and increment click count.
     */
    public function show(string $id)
    {
        $url = Url::where('short_code', $id)
                  ->orWhere('custom_alias', $id)
                  ->firstOrFail();

        $url->incrementClick();

        return redirect($url->original_url);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = Url::findOrFail($id);
        $url->delete();

        return redirect()->route('urls.index')
                       ->with('success', 'URL berhasil dihapus!');
    }
}
