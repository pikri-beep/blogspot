@extends('layouts.app')

@section('content')

<div class="grid lg:grid-cols-12 gap-8">

    {{-- MAIN CONTENT --}}
    <div class="lg:col-span-8">

        {{-- HERO --}}
        <section class="bg-white border border-gray-100 rounded-[32px] overflow-hidden shadow-sm">

            <div class="p-10 lg:p-14">

                <div
                    class="inline-flex items-center gap-2 bg-sky-50 text-sky-700 px-4 py-2 rounded-full text-sm font-medium">

                    <div class="w-2 h-2 rounded-full bg-sky-500"></div>

                    Creative Article Platform

                </div>

                <h1 class="text-5xl lg:text-6xl font-black leading-tight text-gray-900 mt-8 max-w-4xl">

                    Modern Insights,
                    News & Professional Articles

                </h1>

                <p class="mt-8 text-xl text-gray-500 leading-relaxed max-w-3xl">

                    Platform artikel modern dengan tampilan clean dan profesional
                    untuk berbagi wawasan, berita kampus, teknologi, dan inspirasi.

                </p>

                <div class="flex flex-wrap gap-4 mt-10">

                    <a href="#articles"
                        class="bg-sky-600 hover:bg-sky-700 text-white px-8 py-4 rounded-2xl font-semibold transition">
                        Explore Articles
                    </a>

                    @guest

                    <a href="/register"
                        class="border border-gray-200 hover:border-sky-500 hover:text-sky-600 px-8 py-4 rounded-2xl font-semibold transition">
                        Become Writer
                    </a>

                    @endguest

                </div>

            </div>

        </section>

        {{-- SECTION --}}
        <div id="articles" class="flex items-center justify-between mt-14 mb-8">

            <div>

                <p class="text-sky-600 font-semibold text-sm uppercase tracking-[3px]">
                    Latest Articles
                </p>

                <h2 class="text-4xl font-black text-gray-900 mt-3">
                    Recent Publications
                </h2>

            </div>

        </div>
        {{-- SEARCH BAR --}}
        <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 mb-10">

            <form action="/" method="GET">

                <div class="flex flex-col md:flex-row gap-4">

                    {{-- INPUT --}}
                    <div class="flex-1 relative">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-400 absolute left-5 top-1/2 -translate-y-1/2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />

                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                            class="w-full h-14 rounded-2xl border border-gray-200 bg-gray-50 pl-14 pr-6 text-gray-700 focus:border-sky-500 focus:ring-sky-500">

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                        class="h-14 px-8 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white font-semibold transition duration-300 shadow-sm">

                        Cari Artikel

                    </button>

                </div>

            </form>

        </div>
        {{-- ARTICLE LIST --}}
        <div class="space-y-8">

            @foreach($posts as $post)

            <article
                class="bg-white border border-gray-100 rounded-[32px] overflow-hidden shadow-sm hover:shadow-lg transition duration-300">

                <div class="grid lg:grid-cols-5">

                    {{-- IMAGE --}}
                    <div class="lg:col-span-2">

                        @if($post->image)

                        <div class="aspect-[4/3] overflow-hidden">

                            <img src="{{ asset('storage/'.$post->image) }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-700">

                        </div>

                        @else

                        <div class="w-full h-full min-h-[260px] bg-gray-100"></div>

                        @endif

                    </div>

                    {{-- CONTENT --}}
                    <div class="lg:col-span-3 p-8 lg:p-10 flex flex-col justify-between">

                        <div>

                            {{-- META --}}
                            <div class="flex items-center gap-4 text-sm text-gray-500">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold">

                                        {{ strtoupper(substr($post->user->name,0,1)) }}

                                    </div>

                                    <span class="font-medium">
                                        {{ $post->user->name }}
                                    </span>

                                </div>

                                <span>•</span>

                                <span>
                                    {{ $post->created_at->format('d M Y') }}
                                </span>

                            </div>

                            {{-- TITLE --}}
                            <h2 class="text-3xl font-black text-gray-900 leading-snug mt-6">

                                {{ $post->title }}

                            </h2>

                            {{-- EXCERPT --}}
                            <p class="text-gray-500 leading-relaxed mt-6 line-clamp-3">

                                {{ Str::limit(strip_tags($post->content), 180) }}

                            </p>

                        </div>

                        {{-- BUTTON --}}
                        <div class="mt-10">

                            <a href="/article/{{ $post->slug }}"
                                class="inline-flex items-center gap-3 text-sky-600 font-semibold hover:gap-5 transition-all">
                                Read Article
                                →
                            </a>

                        </div>

                    </div>

                </div>

            </article>

            @endforeach

        </div>

        {{-- PAGINATION --}}
        <div class="mt-12">

            {{ $posts->withQueryString()->links() }}

        </div>

    </div>

    {{-- SIDEBAR --}}
    <aside class="lg:col-span-4">

        <div class="sticky top-24 space-y-8">

            {{-- TRENDING --}}
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">

                <div class="flex items-center justify-between mb-8">

                    <div>

                        <p class="text-sky-600 font-semibold text-sm uppercase tracking-[3px]">
                            Trending
                        </p>

                        <h3 class="text-3xl font-black text-gray-900 mt-2">
                            🔥 Trending Articles
                        </h3>

                    </div>

                </div>

                <div class="space-y-8">

                    @foreach($trending as $post)

                    <a href="/article/{{ $post->slug }}"
                        class="block group border-b border-gray-100 pb-6 last:border-0">

                        <div class="flex gap-5">

                            <div class="text-3xl font-black text-sky-100 group-hover:text-sky-500 transition">
                                0{{ $loop->iteration }}
                            </div>

                            <div>

                                <h4
                                    class="text-lg font-bold leading-snug text-gray-900 group-hover:text-sky-600 transition">

                                    {{ $post->title }}

                                </h4>

                                <p class="text-sm text-gray-500 mt-3">

                                    {{ $post->created_at->format('d M Y') }}

                                </p>

                                <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">

                                    {{-- LIKE --}}
                                    <div class="flex items-center gap-1">

                                        ❤️

                                        <span>
                                            {{ $post->likes_count }}
                                        </span>

                                    </div>

                                    {{-- COMMENT --}}
                                    <div class="flex items-center gap-1">

                                        💬

                                        <span>
                                            {{ $post->comments_count }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </a>

                    @endforeach

                </div>

            </div>

            {{-- CTA --}}
            <div class="bg-sky-600 rounded-[32px] p-10 text-white overflow-hidden relative">

                <div class="absolute top-0 right-0 w-52 h-52 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative z-10">

                    <p class="uppercase tracking-[3px] text-sm text-white/70">
                        Join Platform
                    </p>

                    <h3 class="text-4xl font-black leading-tight mt-5">

                        Start Writing
                        Professional Articles

                    </h3>

                    <p class="mt-6 text-white/80 leading-relaxed">

                        Bangun personal branding dan bagikan wawasan terbaikmu.

                    </p>

                    @guest

                    <a href="/register"
                        class="inline-flex mt-8 bg-white text-sky-700 px-7 py-4 rounded-2xl font-semibold hover:scale-105 transition">
                        Register Now
                    </a>

                    @endguest

                </div>

            </div>

        </div>

    </aside>

</div>

@endsection