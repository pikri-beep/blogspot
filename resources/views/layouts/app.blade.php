<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CampusBlog</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

</head>

<body class="bg-[#f5f7fb] text-gray-700">

    {{-- BACKGROUND BLUR --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10">

        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-sky-200 rounded-full blur-3xl opacity-20"></div>

        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-200 rounded-full blur-3xl opacity-20"></div>

    </div>

    {{-- NAVBAR --}}
    <nav class="sticky top-0 z-50 border-b border-white/20 bg-white/70 backdrop-blur-xl">

        <div class="max-w-7xl mx-auto px-6 py-5">

            <div class="flex items-center justify-between">

                {{-- LOGO --}}
                <a href="/" class="text-3xl font-black gradient-text">
                    AnomaliBlog
                </a>

                {{-- MENU --}}
                <div class="hidden md:flex items-center gap-6">

                    <a href="/" class="hover:text-sky-600 transition">
                        Home
                    </a>

                    @auth

                    <a href="/dashboard" class="hover:text-sky-600 transition">
                        Dashboard
                    </a>

                    <a href="/profile" class="hover:text-sky-600 transition">
                        Profile
                    </a>

                    <a href="/create"
                        class="hidden md:flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-5 py-3 rounded-2xl transition font-semibold">

                        <span class="text-lg">+</span>

                        Tulis Artikel

                    </a>

                    <form action="/logout" method="POST">

                        @csrf

                        <button class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-2xl transition">
                            Logout
                        </button>

                    </form>

                    @else

                    <a href="/login">
                        Login
                    </a>

                    <a href="/register" class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-2xl transition">
                        Register
                    </a>

                    @endauth

                </div>

            </div>

        </div>

    </nav>

    {{-- MAIN CONTENT --}}
    <main class="max-w-8xl mx-auto px-6 py-10">

        @yield('content')

    </main>
    {{-- IMAGE PREVIEW MODAL --}}
    <div id="imageModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[999] hidden items-center justify-center p-6">

        {{-- CLOSE BUTTON --}}
        <button onclick="closeImageModal()"
            class="absolute top-6 right-6 text-white text-5xl font-light hover:scale-110 transition">
            ×
        </button>

        {{-- IMAGE --}}
        <img id="previewImage" src="" class="max-w-6xl w-full max-h-[90vh] object-contain rounded-3xl shadow-2xl">

    </div>

    <script>
    function openImageModal(src) {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('previewImage');

        image.src = src;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');

        document.body.style.overflow = 'auto';
    }

    // CLOSE KETIKA CLICK BACKGROUND
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target.id === 'imageModal') {
            closeImageModal();
        }
    });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</body>

</html>