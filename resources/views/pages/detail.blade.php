@extends('layouts.app')

@section('content')

<div class="grid lg:grid-cols-3 gap-10">

    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm overflow-hidden">

        @if($post->image)
        <div class="overflow-hidden rounded-[32px]">

            <img src="{{ asset('storage/'.$post->image) }}" onclick="openImageModal(this.src)"
                class="w-full h-[260px] md:h-[400px] lg:h-[520px] object-cover cursor-zoom-in hover:scale-[1.02] transition duration-500">

        </div>
        @endif

        <div class="p-10">

            <div class="flex items-center gap-3 text-gray-500 mb-5">
                <span>{{ $post->user->name }}</span>
                <span>•</span>
                <span>{{ $post->created_at->format('d M Y') }}</span>
            </div>

            <h1 class="text-5xl font-bold leading-tight">
                {{ $post->title }}
            </h1>

            {{-- 1. BUNGKUS KONTEN DENGAN WRAPPER & BERI EVENT JAVASCRIPT --}}
            <div class="relative mt-12">
                <div id="article-content"
                    class="prose prose-lg max-w-none prose-img:rounded-3xl prose-headings:font-black prose-p:text-gray-700 transition-all duration-500 overflow-hidden"
                    style="max-height: 400px;"> {{-- Set batas tinggi awal artikel saat di-minimize (misal: 400px) --}}

                    {!! $post->content !!}

                </div>

                {{-- 2. LAYER GRADASI BLUR TRANSPARAN SAAT DI-MINIMIZE --}}
                <div id="readmore-gradient"
                    class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white to-transparent pointer-events-none">
                </div>
            </div>

            {{-- 3. TOMBOL READ MORE / SHOW LESS --}}
            <div class="mt-4 flex justify-center">
                <button onclick="toggleArticleContent()" id="btn-readmore"
                    class="bg-sky-100 hover:bg-sky-200 text-sky-700 font-bold px-6 py-3 rounded-2xl transition duration-300 flex items-center gap-2 shadow-sm">
                    <span id="text-readmore">Read More</span>
                    <svg id="icon-readmore" class="w-4 h-4 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            {{-- LIKE SECTION--}}
            <div class="mt-8">
                @auth
                <form action="/like/{{ $post->id }}" method="POST" class="inline-block">
                    @csrf

                    @if($post->likes->where('user_id', auth()->id())->count())
                    {{-- TAMPILAN SUDAH DI-LIKE: Merah pekat, teks font-black, efek scale-up pas di-hover --}}
                    <button type="submit"
                        class="group bg-rose-500 hover:bg-rose-600 text-white px-6 py-3 rounded-2xl font-black text-base flex items-center gap-2.5 transition-all duration-300 transform active:scale-90 hover:scale-105 shadow-md shadow-rose-500/30">
                        <span class="inline-block animate-[heartBeat_1s_ease-in-out_infinite] text-xl">❤️</span>
                        <span class="tracking-wide">{{ $post->likes->count() }} Likes</span>
                    </button>
                    @else
                    {{-- TAMPILAN BELUM DI-LIKE: Abu-abu, pas di-hover berubah jadi rose soft, lope putihnya membal --}}
                    <button type="submit"
                        class="group bg-gray-100 hover:bg-rose-50 text-gray-700 hover:text-rose-600 px-6 py-3 rounded-2xl font-black text-base flex items-center gap-2.5 transition-all duration-300 transform active:scale-90 hover:scale-105">
                        <span
                            class="inline-block transition-transform duration-300 group-hover:scale-125 group-hover:rotate-12 text-xl">🤍</span>
                        <span class="tracking-wide">{{ $post->likes->count() }} Likes</span>
                    </button>
                    @endif
                </form>
                @else
                {{-- JIKA USER BELUM LOGIN --}}
                <div
                    class="bg-gray-100 text-gray-400 px-6 py-3 rounded-2xl font-black text-base inline-flex items-center gap-2.5 cursor-not-allowed">
                    <span class="text-xl">🤍</span>
                    <span class="tracking-wide">{{ $post->likes->count() }} Likes</span>
                </div>
                @endauth
            </div>

            {{-- COMMENT SECTION --}}
            <div class="mt-16 bg-white rounded-[32px] p-8 shadow-sm border border-gray-100">

                <h2 class="text-4xl font-black text-gray-900 mb-10">
                    Discussion
                </h2>

                {{-- COMMENT FORM --}}
                @auth

                <form action="/comment/{{ $post->id }}" method="POST" class="mb-12">

                    @csrf

                    <textarea name="comment" rows="5" placeholder="Write your comment..."
                        class="w-full rounded-3xl border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-sky-500"></textarea>

                    <button class="mt-5 bg-sky-600 hover:bg-sky-700 text-white px-8 py-4 rounded-2xl transition">
                        Send Comment
                    </button>

                </form>

                @else

                <div class="bg-gray-100 rounded-3xl p-6 text-center text-gray-600">
                    Login untuk menambahkan komentar.
                </div>

                @endauth

                {{-- COMMENT LIST --}}
                <div class="space-y-6">

                    @forelse($post->comments->sortByDesc('created_at') as $comment)

                    <div class="border border-gray-100 rounded-3xl p-6">

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($comment->user->name,0,1)) }}
                            </div>

                            <div>

                                <h3 class="font-bold text-lg text-gray-900">
                                    {{ $comment->user->name }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>

                        <p class="mt-5 text-gray-700 leading-relaxed">
                            {{ $comment->comment }}
                        </p>

                    </div>

                    @empty

                    <div class="bg-gray-50 rounded-3xl p-10 text-center text-gray-500">
                        Belum ada komentar.
                    </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

    <div>

        <div class="sticky top-24 bg-white rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-bold mb-6">
                Related Posts
            </h3>

            <div class="space-y-5">

                @foreach($related as $item)

                <a href="/article/{{ $item->slug }}" class="block">
                    <h4 class="font-semibold hover:text-sky-600">
                        {{ $item->title }}
                    </h4>
                </a>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection

<script>
function toggleArticleContent() {
    const content = document.getElementById('article-content');
    const gradient = document.getElementById('readmore-gradient');
    const btnText = document.getElementById('text-readmore');
    const btnIcon = document.getElementById('icon-readmore');

    // Jika saat ini sedang di-minimize (tingginya 400px)
    if (content.style.maxHeight === '400px') {
        // Buka seluruh konten secara full otomatis
        content.style.maxHeight = content.scrollHeight + "px";

        // Sembunyikan efek blur transparan di bawah teks
        gradient.classList.add('hidden');

        // Ubah teks & putar icon panah ke atas
        btnText.innerText = 'Show Less';
        btnIcon.classList.add('rotate-180');
    } else {
        // Tutup kembali artikel ke tinggi semula
        content.style.maxHeight = '400px';

        // Munculkan kembali efek blur transparan
        gradient.classList.remove('hidden');

        // Kembalikan teks & arah icon panah ke bawah
        btnText.innerText = 'Read More';
        btnIcon.classList.remove('rotate-180');

        // Otomatis scroll layar sedikit ke atas agar pembaca tidak bingung saat artikel menutup
        content.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }
}
</script>