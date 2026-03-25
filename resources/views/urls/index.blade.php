@extends('layouts.app')

@section('title', 'All Short URLs - Ringkas.in')

@section('content')
    <div class="mb-8">
        <h2 class="text-4xl font-bold text-gray-800 mb-2">All Short URLs</h2>
        <p class="text-gray-600">Manage and track your shortened links</p>
    </div>

    @if($urls->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">Belum ada URL yang dibuat</p>
            <a href="{{ route('urls.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Buat URL Pendek Sekarang
            </a>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Original URL</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Short Code</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Clicks</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($urls as $url)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700 truncate" title="{{ $url->original_url }}">
                                {{ Str::limit($url->original_url, 50) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <code class="bg-gray-100 px-3 py-1 rounded text-blue-600 font-mono">
                                        {{ $url->custom_alias ?? $url->short_code }}
                                    </code>
                                    <button 
                                        type="button"
                                        class="copy-btn bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs hover:bg-blue-200 transition"
                                        data-url="{{ route('urls.show', $url->short_code) }}"
                                        title="Copy to clipboard"
                                    >
                                        📋 Copy
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                {{ $url->click_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $url->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <form action="{{ route('urls.destroy', $url->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin hapus URL ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-200 transition">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @push('scripts')
    <script>
        // Copy to Clipboard Feature
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const shortUrl = this.getAttribute('data-url');
                
                // Copy to clipboard
                navigator.clipboard.writeText(shortUrl).then(() => {
                    // Show feedback
                    const originalText = this.textContent;
                    this.textContent = '✓ Copied!';
                    this.classList.add('bg-green-200', 'text-green-600');
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-200', 'text-green-600');
                        this.classList.add('bg-blue-100', 'text-blue-600');
                    }, 2000);
                }).catch(err => {
                    alert('Gagal menyalin ke clipboard');
                    console.error('Error:', err);
                });
            });
        });
    </script>
    @endpush
@endsection
