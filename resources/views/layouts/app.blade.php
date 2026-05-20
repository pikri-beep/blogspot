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
                    <a href="/dashboard" class="hover:text-sky-600 font-medium transition">Dashboard</a>

                    {{-- DROPDOWN USER PROFILE --}}
                    <div class="relative inline-block text-left" id="user-dropdown-wrapper">
                        <button onclick="toggleUserDropdown()" type="button"
                            class="flex items-center gap-3 bg-gray-50 hover:bg-gray-100 border border-gray-100 px-4 py-2 rounded-2xl transition duration-300 focus:outline-none">

                            {{-- FOTO PROFIL DINAMIS --}}
                            @if(auth()->user()->avatar)
                            {{-- Jika user sudah upload foto profil, tampilkan fotonya --}}
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                class="w-8 h-8 rounded-full object-cover shadow-sm border border-gray-100">
                            @else
                            {{-- Fallback: Jika belum upload, pakai inisial huruf bawaan yang kemarin --}}
                            <div
                                class="w-8 h-8 rounded-full bg-sky-600 text-white flex items-center justify-center font-black uppercase text-xs shadow-sm shadow-sky-600/20">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif

                            {{-- Nama User --}}
                            <span class="font-bold text-sm text-gray-800 hidden sm:inline-block">
                                {{ auth()->user()->name }}
                            </span>
                            {{-- Ikon Panah Kecil --}}
                            <svg class="w-4 h-4 text-gray-400 transition-transform duration-300" id="dropdown-arrow"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- KOTAK MENU DROPDOWN (Default: Tersembunyi 'hidden') --}}
                        <div id="user-dropdown-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 origin-top-right transition-all duration-200 transform scale-95 opacity-0">

                            {{-- Link Ke Profile --}}
                            <a href="/profile"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-sky-50 hover:text-sky-600 transition">
                                👤 Profile
                            </a>

                            <hr class="border-gray-50 my-1">

                            {{-- Tombol Logout --}}
                            <form action="/logout" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50 transition">
                                    🚪 Logout
                                </button>
                            </form>

                        </div>
                    </div>

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
    <script>
    function toggleUserDropdown() {
        const menu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');

        if (menu.classList.contains('hidden')) {
            // Tampilkan Menu dengan animasi halus
            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.remove('scale-95', 'opacity-0');
                menu.classList.add('scale-100', 'opacity-100');
            }, 10);
            arrow.classList.add('rotate-180');
        } else {
            // Sembunyikan Menu
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 200);
            arrow.classList.remove('rotate-180');
        }
    }

    // Fitur Otomatis Tutup Dropdown jika User klik di luar area menu
    window.addEventListener('click', function(e) {
        const wrapper = document.getElementById('user-dropdown-wrapper');
        const menu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');

        if (wrapper && !wrapper.contains(e.target)) {
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.remove('scale-100', 'opacity-100');
                menu.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 200);
                arrow.classList.remove('rotate-180');
            }
        }
    });
    </script>
</body>

</html>