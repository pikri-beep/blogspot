<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="font-sans antialiased bg-[#f5f7fb]">

    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-12 relative overflow-hidden">

        {{-- BG Decors --}}
        <div
            class="absolute top-0 left-0 w-[500px] h-[500px] bg-sky-200 opacity-20 blur-3xl rounded-full pointer-events-none">
        </div>
        <div
            class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-200 opacity-20 blur-3xl rounded-full pointer-events-none">
        </div>

        {{-- MAIN CARD CONTAINER --}}
        <div
            class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 bg-white rounded-3xl shadow-2xl relative z-10 overflow-hidden min-h-[600px]">

            {{-- LEFT SIDE (Hanya muncul di Desktop lg) --}}
            <div
                class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-sky-500 to-blue-700 text-white p-12 flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <p class="uppercase tracking-[4px] text-xs font-bold text-white/70">
                        Welcome Back
                    </p>

                    <h1 class="text-5xl font-black leading-tight mt-6">
                        Sign In to <br>
                        CampusBlog.
                    </h1>

                    <p class="mt-6 text-base text-white/80 leading-relaxed">
                        Lanjutkan menulis artikel dan bagikan ide kreatifmu kepada dunia sekarang juga.
                    </p>
                </div>

                <div
                    class="relative z-10 flex items-center gap-4 bg-white/5 p-4 rounded-2xl backdrop-blur-sm border border-white/10">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-xl shadow-inner">
                        ✍️
                    </div>
                    <div>
                        <h3 class="font-bold text-sm">
                            Keep Inspiring Others
                        </h3>
                        <p class="text-white/60 text-xs">
                            Your Dashboard is Waiting
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE (Form Login) --}}
            <div class="col-span-1 lg:col-span-7 p-8 sm:p-12 lg:p-16 flex items-center">
                <div class="w-full">

                    <div>
                        <h2 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                            Login
                        </h2>
                        <p class="text-gray-500 mt-2 text-sm sm:text-base">
                            Masuk dengan akun yang sudah terdaftar.
                        </p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
                        @csrf

                        {{-- EMAIL --}}
                        <div>
                            <label for="email"
                                class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 h-12 px-4 text-gray-800 transition">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <label for="password"
                                class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-600">
                                Password
                            </label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 h-12 px-4 text-gray-800 transition">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        {{-- REMEMBER & FORGOT PASSWORD --}}
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-sky-600 focus:ring-sky-500 w-4 h-4">
                                <span>Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sky-600 hover:text-sky-700 text-sm font-semibold transition">
                                Forgot password?
                            </a>
                            @endif
                        </div>

                        {{-- BUTTON --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full h-12 bg-sky-600 hover:bg-sky-700 text-white rounded-xl font-semibold text-base transition duration-300 shadow-lg shadow-sky-600/20 active:scale-[0.98]">
                                Login
                            </button>
                        </div>

                        {{-- REGISTER LINK --}}
                        <p class="text-center text-gray-500 text-sm mt-4">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-sky-600 font-semibold hover:text-sky-700 transition ml-1">
                                Register
                            </a>
                        </p>

                    </form>

                </div>
            </div>

        </div>

    </div>

</body>

</html>