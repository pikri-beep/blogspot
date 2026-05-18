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

            <div
                class="mt-12 prose prose-lg max-w-none prose-img:rounded-3xl prose-headings:font-black prose-p:text-gray-700">

                {!! $post->content !!}

            </div>
            {{-- LIKE SECTION --}}
            <div class="flex items-center gap-4 mt-8">

                <div class="bg-gray-100 px-5 py-3 rounded-2xl text-gray-700 font-medium">
                    ❤️ {{ $post->likes->count() }} Likes
                </div>

                @auth

                <form action="/like/{{ $post->id }}" method="POST">

                    @csrf

                    <button class="bg-sky-600 hover:bg-sky-700 text-white px-6 py-3 rounded-2xl transition">

                        @if($post->likes->where('user_id', auth()->id())->count())
                        Unlike
                        @else
                        Like
                        @endif

                    </button>

                </form>

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