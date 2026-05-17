@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-3xl shadow-md border border-gray-100 my-10">

    <h1 class="text-3xl font-black text-gray-900 mb-8 tracking-tight">
        Edit Artikel
    </h1>

    <form action="/edit/{{ $post->id }}" method="POST" enctype="multipart/form-data" class="space-y-6">

        @csrf
        @method('PUT')

        {{-- TITLE --}}
        <div>
            <label class="block text-sm font-bold uppercase tracking-wider mb-2 text-gray-600">
                Judul Artikel
            </label>
            <input type="text" name="title" value="{{ $post->title }}" required
                class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 h-12 px-4 text-gray-800 transition">
            <x-input-error :messages="$errors->get('title')" class="mt-1" />
        </div>

        {{-- IMAGE UPLOAD & PREVIEW --}}
        <div>
            <label class="block text-sm font-bold uppercase tracking-wider mb-2 text-gray-600">
                Gambar Artikel
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                {{-- Kiri: Gambar Lama (Jika Ada) --}}
                @if($post->image)
                <div
                    class="p-3 bg-gray-50 border border-gray-200 rounded-2xl flex flex-col items-center justify-center">
                    <span class="text-xs font-semibold text-gray-400 mb-2">Gambar Saat Ini:</span>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image"
                        class="h-32 w-full object-cover rounded-xl">
                </div>
                @endif

                {{-- Kanan: Wadah Preview Gambar Baru --}}
                <div id="preview-container"
                    class="hidden p-3 bg-sky-50/50 border border-dashed border-sky-300 rounded-2xl flex flex-col items-center justify-center">
                    <span class="text-xs font-semibold text-sky-600 mb-2">Preview Gambar Baru:</span>
                    <img id="image-preview" src="#" alt="New Preview" class="h-32 w-full object-cover rounded-xl">
                </div>
            </div>

            {{-- Custom Input File Styling biar lebih rapi dari bawaan browser --}}
            <input type="file" name="image" id="image-input" accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer border border-gray-200 rounded-xl p-1 bg-gray-50">
            <p class="text-gray-400 text-xs mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
            <x-input-error :messages="$errors->get('image')" class="mt-1" />
        </div>

        {{-- CONTENT --}}
        <div>
            <label class="block text-sm font-bold uppercase tracking-wider mb-2 text-gray-600">
                Konten Artikel
            </label>
            <textarea name="content" rows="10" required
                class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 p-4 text-gray-800 transition leading-relaxed">{{ $post->content }}</textarea>
            <x-input-error :messages="$errors->get('content')" class="mt-1" />
        </div>

        {{-- BUTTONS --}}
        <div class="pt-4 flex items-center gap-3">
            <button type="submit"
                class="h-12 bg-sky-600 hover:bg-sky-700 text-white px-8 rounded-xl font-semibold text-base transition duration-300 shadow-lg shadow-sky-600/20 active:scale-[0.98]">
                Update Artikel
            </button>
            <a href="/dashboard"
                class="h-12 bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 rounded-xl font-semibold text-base transition flex items-center justify-center">
                Batal
            </a>
        </div>

    </form>
</div>

{{-- JAVASCRIPT UNTUK PREVIEW --}}
<script>
document.getElementById('image-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();

        // Ketika file berhasil dibaca browser
        reader.onload = function(e) {
            imagePreview.src = e.target.result; // Set src gambar dengan data URL
            previewContainer.classList.remove('hidden'); // Munculkan container preview
        }

        reader.readAsDataURL(file);
    } else {
        // Jika user membatalkan pilihan file
        imagePreview.src = "#";
        previewContainer.classList.add('hidden');
    }
});
</script>

@endsection