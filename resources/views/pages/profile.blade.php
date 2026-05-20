@extends('layouts.app')

@section('content')

{{-- HERO PROFILE --}}
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-[36px] overflow-hidden shadow-sm">
    <div class="p-10 lg:p-14">
        <div class="flex flex-col lg:flex-row lg:items-center gap-10">

            {{-- AVATAR HERO --}}
            <div>
                @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}"
                    class="w-36 h-36 rounded-full object-cover border-4 border-white shadow-lg">
                @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff&size=200"
                    class="w-36 h-36 rounded-full object-cover border-4 border-white shadow-lg">
                @endif
            </div>

            {{-- USER INFO --}}
            <div class="text-white flex-1">
                <p class="uppercase tracking-[4px] text-sm text-white/70">
                    PROFILE USER
                </p>
                <h1 class="text-5xl font-bold mt-4">
                    {{ $user->name }}
                </h1>
                <div class="mt-5 text-lg text-white/80 max-w-2xl leading-relaxed prose prose-invert">
                    @if($user->bio)
                    {!! $user->bio !!}
                    @else
                    <p>Belum ada bio profile.</p>
                    @endif
                </div>

                {{-- STATS --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-5 mt-10">
                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">
                        <p class="text-white/70 text-sm">Total Artikel</p>
                        <h2 class="text-4xl font-bold mt-3">{{ $totalPosts }}</h2>
                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">
                        <p class="text-white/70 text-sm">Bergabung</p>
                        <h2 class="text-2xl font-bold mt-3">{{ $user->created_at->format('Y') }}</h2>
                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">
                        <p class="text-white/70 text-sm">Status</p>
                        <h2 class="text-2xl font-bold mt-3">Active</h2>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SUCCESS --}}
@if(session('success'))
<div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-3xl mt-8">
    {{ session('success') }}
</div>
@endif

{{-- CONTENT --}}
<div class="grid lg:grid-cols-3 gap-10 mt-10">

    {{-- LEFT: LIST ARTIKEL --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-[32px] p-8 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-4xl font-bold">Artikel Saya</h2>
                    <p class="text-gray-500 mt-2">Semua artikel yang telah dipublish</p>
                </div>
            </div>

            {{-- EMPTY --}}
            @if($posts->count() == 0)
            <div class="text-center py-20">
                <div class="text-7xl">📄</div>
                <h2 class="text-3xl font-bold mt-6">Belum Ada Artikel</h2>
                <p class="text-gray-500 mt-4">Mulai publish artikel pertamamu.</p>
                <a href="/create" class="inline-block mt-8 bg-sky-600 text-white px-8 py-4 rounded-2xl">Buat Artikel</a>
            </div>
            @else
            {{-- ARTICLE LIST --}}
            <div class="space-y-6">
                @foreach($posts as $post)
                <div class="border border-gray-100 rounded-3xl p-5 hover:shadow-md transition">
                    <div class="flex gap-5">
                        @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" class="w-36 h-28 rounded-2xl object-cover">
                        @endif

                        <div class="flex-1">
                            <p class="text-sm text-gray-500">{{ $post->created_at->format('d M Y') }}</p>
                            <h3 class="text-2xl font-bold mt-2">{{ $post->title }}</h3>
                            <div class="flex gap-3 mt-5">
                                <a href="/article/{{ $post->slug }}"
                                    class="bg-gray-100 hover:bg-gray-200 px-5 py-2 rounded-xl transition">View</a>
                                <a href="/edit/{{ $post->id }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 px-5 py-2 rounded-xl transition">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT SIDEBAR: EDIT PROFILE FORM --}}
    <div>
        @if(auth()->check() && auth()->id() == $user->id)
        <div class="sticky top-24 bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">
            <h2 class="text-3xl font-black mb-8 text-gray-900">Edit Profile</h2>

            <form action="/profile" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- NAME --}}
                <div class="mb-6">
                    <label class="block mb-3 font-bold text-gray-700 text-sm">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}"
                        class="w-full h-13 rounded-2xl border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-sky-500 transition px-4 py-3">
                </div>

                {{-- BIO (INTEGRASI CKEDITOR) --}}
                <div class="mb-6">
                    <label class="block mb-3 font-bold text-gray-700 text-sm">Bio</label>
                    <div class="prose max-w-none">
                        <textarea name="bio" id="bio-editor" rows="5"
                            class="w-full rounded-2xl border-gray-200 bg-gray-50">{{ $user->bio }}</textarea>
                    </div>
                </div>

                {{-- AVATAR + INTERACTIVE PREVIEW --}}
                <div class="mb-8">
                    <label class="block mb-3 font-bold text-gray-700 text-sm">Avatar</label>

                    <div
                        class="flex items-center gap-5 bg-gray-50 p-4 border border-dashed border-gray-200 rounded-2xl mb-4">
                        {{-- Wadah Preview Gambar Lingkaran Kecil --}}
                        <div
                            class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 shrink-0 shadow-inner border border-gray-200">
                            @if($user->avatar)
                            <img id="avatar-preview-img" src="{{ asset('storage/'.$user->avatar) }}"
                                class="w-full h-full object-cover">
                            @else
                            <img id="avatar-preview-img"
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0ea5e9&color=fff"
                                class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-700">Preview Foto Baru</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Akan langsung berubah saat file dipilih</p>
                        </div>
                    </div>

                    {{-- Input File Asli custom styling --}}
                    <input type="file" name="avatar" id="avatar-file-input" onchange="previewAvatar(this)"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 transition cursor-pointer">
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full bg-sky-600 hover:bg-sky-700 text-white py-4 rounded-2xl font-semibold transition duration-300 shadow-sm">
                    Simpan Profile
                </button>
            </form>
        </div>@else
        {{-- TAMPILKAN BANNER ATAU KARTU INFO JIKA INI PROFIL ORANG LAIN --}}
        <div
            class="sticky top-24 bg-gradient-to-br from-gray-900 to-slate-800 rounded-[32px] p-8 text-white shadow-md text-center">
            <div class="text-4xl mb-4">✍️</div>
            <h3 class="text-xl font-bold">Tentang Penulis</h3>
            <p class="text-gray-400 text-sm mt-2 leading-relaxed">
                Kamu sedang melihat profil publik dari <strong>{{ $user->name }}</strong>. Semua artikel di sebelah kiri
                murni ditulis oleh beliau.
            </p>
            <div class="mt-6 pt-6 border-t border-gray-700/50 text-xs text-gray-500">
                AnomaliBlog Platform
            </div>
        </div>
        @endif
    </div>

</div>

{{-- LOGIC JAVASCRIPT PREVIEW & CKEDITOR --}}
<script>
// Fitur Instan Preview Gambar Avatar
function previewAvatar(input) {
    const preview = document.getElementById('avatar-preview-img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Inisialisasi CKEditor 5 untuk form Bio
document.addEventListener("DOMContentLoaded", function() {
    if (typeof ClassicEditor !== 'undefined') {
        ClassicEditor
            .create(document.querySelector('#bio-editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link',
                    'bulletedList', 'numberedList', 'blockQuote',
                    '|', 'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error('Ada kendala saat memuat CKEditor:', error);
            });
    }
});
</script>

{{-- Kustomisasi Tampilan CSS CKEditor biar senada dengan tema aplikasi --}}
<style>
.ck-editor__editable_inline {
    min-height: 140px;
    background-color: #f9fafb !important;
    border-bottom-left-radius: 1rem !important;
    border-bottom-right-radius: 1rem !important;
    padding: 0 1rem !important;
}

.ck-toolbar {
    background-color: #f3f4f6 !important;
    border-top-left-radius: 1rem !important;
    border-top-right-radius: 1rem !important;
    border-color: #e5e7eb !important;
}

.ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
    border-color: #e5e7eb !important;
}
</style>

@endsection