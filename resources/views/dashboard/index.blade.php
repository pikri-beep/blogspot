@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-[32px] p-10 text-white shadow-sm">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

        <div>

            <p class="uppercase tracking-[4px] text-sm text-white/70">
                USER DASHBOARD
            </p>

            <h1 class="text-5xl font-bold mt-4 leading-tight">
                Halo, {{ auth()->user()->name }}
            </h1>

            <p class="mt-4 text-white/80 text-lg max-w-2xl">
                Kelola artikel, update tulisan, dan bangun portfolio konten modern milikmu.
            </p>

        </div>

        <div class="flex gap-4">

            <a href="/create"
                class="bg-white text-sky-600 px-6 py-4 rounded-2xl font-semibold hover:scale-105 transition duration-300">
                + Tambah Artikel
            </a>

            <a href="/profile"
                class="bg-white/10 border border-white/20 px-6 py-4 rounded-2xl hover:bg-white/20 transition">
                Profile
            </a>

        </div>

    </div>

</div>

{{-- STATS --}}
<div class="grid md:grid-cols-3 gap-6 mt-10">

    {{-- TOTAL POST --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-gray-500">
                    Total Artikel
                </p>

                <h2 class="text-5xl font-bold mt-3">
                    {{ $totalPosts }}
                </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-sky-100 flex items-center justify-center text-3xl">
                📝
            </div>

        </div>

    </div>

    {{-- STATUS --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-gray-500">
                    Status Akun
                </p>

                <h2 class="text-3xl font-bold mt-3">
                    Active
                </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">
                🚀
            </div>

        </div>

    </div>

    {{-- MEMBER --}}
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-gray-500">
                    Member Since
                </p>

                <h2 class="text-3xl font-bold mt-3">
                    {{ auth()->user()->created_at->format('Y') }}
                </h2>

            </div>

            <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">
                👤
            </div>

        </div>

    </div>

</div>

{{-- SUCCESS ALERT --}}
@if(session('success'))

<div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-3xl mt-8">

    {{ session('success') }}

</div>

@endif

{{-- SECTION TITLE --}}
<div class="flex justify-between items-center mt-14 mb-8">

    <div>

        <h2 class="text-4xl font-bold">
            Artikel Saya
        </h2>

        <p class="text-gray-500 mt-2">
            Semua artikel yang telah kamu publish
        </p>

    </div>

</div>

{{-- EMPTY STATE --}}
@if($posts->count() == 0)

<div class="bg-white rounded-3xl p-16 shadow-sm text-center">

    <div class="text-7xl mb-6">
        📄
    </div>

    <h2 class="text-3xl font-bold">
        Belum Ada Artikel
    </h2>

    <p class="text-gray-500 mt-4 max-w-lg mx-auto">
        Mulai buat artikel pertamamu dan bangun portfolio konten profesional.
    </p>

    <a href="/create" class="inline-block mt-8 bg-sky-600 text-white px-8 py-4 rounded-2xl">
        Buat Artikel
    </a>

</div>

@else

{{-- ARTICLE GRID --}}
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">

    @foreach($posts as $post)

    <div
        class="bg-white rounded-[32px] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition duration-300">

        {{-- IMAGE --}}
        @if($post->image)

        <div class="overflow-hidden">

            <img src="{{ asset('storage/'.$post->image) }}"
                class="w-full h-60 object-cover hover:scale-105 transition duration-500">

        </div>

        @endif

        {{-- CONTENT --}}
        <div class="p-7">

            {{-- DATE --}}
            <div class="flex items-center gap-2 text-sm text-gray-500">

                <span>
                    {{ $post->created_at->format('d M Y') }}
                </span>

            </div>

            {{-- TITLE --}}
            <h2 class="text-2xl font-bold mt-4 leading-snug">
                {{ $post->title }}
            </h2>

            {{-- ACTION --}}
            <div class="flex gap-3 mt-8">

                {{-- VIEW --}}
                <a href="/article/{{ $post->slug }}"
                    class="flex-1 text-center bg-gray-100 hover:bg-gray-200 py-3 rounded-2xl transition">
                    View
                </a>

                {{-- EDIT --}}
                <a href="/edit/{{ $post->id }}"
                    class="flex-1 text-center bg-yellow-400 hover:bg-yellow-500 py-3 rounded-2xl transition">
                    Edit
                </a>

            </div>

            {{-- DELETE --}}
            <form action="/delete/{{ $post->id }}" method="POST" class="mt-3">

                @csrf
                @method('DELETE')

                <button onclick="return confirm('Hapus artikel ini?')"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-2xl transition">
                    Delete
                </button>

            </form>

        </div>

    </div>

    @endforeach

</div>

@endif

@endsection