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
    <main class="max-w-7xl mx-auto px-6 py-10">

        @yield('content')

    </main>

</body>

</html>