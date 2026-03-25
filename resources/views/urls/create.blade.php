@extends('layouts.app')

@section('title', 'Create Short URL - Ringkas.in')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Create Short URL</h2>
            <p class="text-gray-600">Shorten your long URLs instantly</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('urls.store') }}" method="POST">
                @csrf

                <!-- Original URL Input -->
                <div class="mb-6">
                    <label for="original_url" class="block text-sm font-semibold text-gray-700 mb-2">
                        Long URL <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="url" 
                        name="original_url" 
                        id="original_url"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition
                        @error('original_url') border-red-500 @enderror"
                        placeholder="https://example.com/very/long/url"
                        value="{{ old('original_url') }}"
                        required
                    >
                    @error('original_url')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom Alias Input -->
                <div class="mb-6">
                    <label for="custom_alias" class="block text-sm font-semibold text-gray-700 mb-2">
                        Custom Alias <span class="text-gray-500 text-sm">(Optional)</span>
                    </label>
                    <input 
                        type="text" 
                        name="custom_alias" 
                        id="custom_alias"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition
                        @error('custom_alias') border-red-500 @enderror"
                        placeholder="my-awesome-link (if left empty, random code will be generated)"
                        value="{{ old('custom_alias') }}"
                    >
                    <p class="text-gray-500 text-sm mt-2">Min 3 karakternya sendiri. Boleh kosong, sistem akan generate random 8-10 karakter.</p>
                    @error('custom_alias')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition duration-200"
                    >
                        ✨ Create Short URL
                    </button>
                    <a 
                        href="{{ route('urls.index') }}"
                        class="flex-1 bg-gray-200 text-gray-800 font-semibold py-3 rounded-lg hover:bg-gray-300 transition duration-200 text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Info Box -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-semibold text-blue-900 mb-2">💡 Tips:</h3>
                <ul class="text-blue-800 text-sm space-y-1">
                    <li>• Gunakan custom alias untuk membuat link yang mudah diingat</li>
                    <li>• Alias harus unik dan tidak boleh sudah digunakan</li>
                    <li>• Setiap link akan automatically generate QR Code</li>
                    <li>• Anda bisa melihat statistik klik pada halaman utama</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
