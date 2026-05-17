@extends('layouts.app')

@section('content')

{{-- HERO PROFILE --}}
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-[36px] overflow-hidden shadow-sm">

    <div class="p-10 lg:p-14">

        <div class="flex flex-col lg:flex-row lg:items-center gap-10">

            {{-- AVATAR --}}
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

                <p class="mt-5 text-lg text-white/80 max-w-2xl leading-relaxed">

                    @if($user->bio)
                    {{ $user->bio }}
                    @else
                    Belum ada bio profile.
                    @endif

                </p>

                {{-- STATS --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-5 mt-10">

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">

                        <p class="text-white/70 text-sm">
                            Total Artikel
                        </p>

                        <h2 class="text-4xl font-bold mt-3">
                            {{ $totalPosts }}
                        </h2>

                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">

                        <p class="text-white/70 text-sm">
                            Bergabung
                        </p>

                        <h2 class="text-2xl font-bold mt-3">
                            {{ $user->created_at->format('Y') }}
                        </h2>

                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 backdrop-blur">

                        <p class="text-white/70 text-sm">
                            Status
                        </p>

                        <h2 class="text-2xl font-bold mt-3">
                            Active
                        </h2>

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

    {{-- LEFT --}}
    <div class="lg:col-span-2">

        <div class="bg-white rounded-[32px] p-8 shadow-sm">

            <div class="flex items-center justify-between mb-8">

                <div>

                    <h2 class="text-4xl font-bold">
                        Artikel Saya
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Semua artikel yang telah dipublish
                    </p>

                </div>

            </div>

            {{-- EMPTY --}}
            @if($posts->count() == 0)

            <div class="text-center py-20">

                <div class="text-7xl">
                    📄
                </div>

                <h2 class="text-3xl font-bold mt-6">
                    Belum Ada Artikel
                </h2>

                <p class="text-gray-500 mt-4">
                    Mulai publish artikel pertamamu.
                </p>

                <a href="/create" class="inline-block mt-8 bg-sky-600 text-white px-8 py-4 rounded-2xl">
                    Buat Artikel
                </a>

            </div>

            @else

            {{-- ARTICLE LIST --}}
            <div class="space-y-6">

                @foreach($posts as $post)

                <div class="border border-gray-100 rounded-3xl p-5 hover:shadow-md transition">

                    <div class="flex gap-5">

                        {{-- IMAGE --}}
                        @if($post->image)

                        <img src="{{ asset('storage/'.$post->image) }}" class="w-36 h-28 rounded-2xl object-cover">

                        @endif

                        {{-- CONTENT --}}
                        <div class="flex-1">

                            <p class="text-sm text-gray-500">
                                {{ $post->created_at->format('d M Y') }}
                            </p>

                            <h3 class="text-2xl font-bold mt-2">
                                {{ $post->title }}
                            </h3>

                            <div class="flex gap-3 mt-5">

                                <a href="/article/{{ $post->slug }}"
                                    class="bg-gray-100 hover:bg-gray-200 px-5 py-2 rounded-xl transition">
                                    View
                                </a>

                                <a href="/edit/{{ $post->id }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 px-5 py-2 rounded-xl transition">
                                    Edit
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

            @endif

        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>

        <div class="sticky top-24 bg-white rounded-[32px] p-8 shadow-sm">

            <h2 class="text-3xl font-bold mb-8">
                Edit Profile
            </h2>

            <form action="/profile" method="POST" enctype="multipart/form-data">

                @csrf

                {{-- NAME --}}
                <div class="mb-6">

                    <label class="block mb-3 font-medium">
                        Nama
                    </label>

                    <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded-2xl border-gray-300">

                </div>

                {{-- BIO --}}
                <div class="mb-6">

                    <label class="block mb-3 font-medium">
                        Bio
                    </label>

                    <textarea name="bio" rows="5" class="w-full rounded-2xl border-gray-300">{{ $user->bio }}</textarea>

                </div>

                {{-- AVATAR --}}
                <div class="mb-8">

                    <label class="block mb-3 font-medium">
                        Avatar
                    </label>

                    <input type="file" name="avatar">

                </div>

                {{-- BUTTON --}}
                <button class="w-full bg-sky-600 hover:bg-sky-700 text-white py-4 rounded-2xl transition">
                    Simpan Profile
                </button>

            </form>

        </div>

    </div>

</div>

@endsection