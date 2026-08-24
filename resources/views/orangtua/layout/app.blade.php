<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Orang Tua - KAIH App')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- HEADER --}}
    <header class="bg-white border-b border-gray-200">

        <div class="max-w-7xl mx-auto px-6 py-4">

            <div class="flex items-center justify-between">

                {{-- LOGO --}}
                <div class="flex items-center gap-3">

                    <div
                        class="w-11 h-11 bg-indigo-600 rounded-xl
                               flex items-center justify-center
                               text-white text-xl"
                    >
                        🎓
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-gray-900">
                            KAIH App
                        </h1>

                        <p class="text-sm text-gray-500">
                            Sistem Informasi Akademik
                        </p>
                    </div>

                </div>


                {{-- USER --}}
                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10 bg-indigo-100 rounded-full
                               flex items-center justify-center
                               text-indigo-600 font-bold"
                    >
                        {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                    </div>

                    <div class="hidden sm:block">

                        <p class="font-semibold text-gray-800">
                            {{ Auth::user()->name ?? 'Orang Tua' }}
                        </p>

                        <p class="text-sm text-gray-500">
                            Orang Tua
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </header>


    {{-- NAVIGATION --}}
    <nav class="bg-white border-b border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center gap-6 py-3">

                <a
                    href="{{ route('orangtua.dashboard') }}"
                    class="font-medium transition
                        {{ request()->routeIs('orangtua.dashboard')
                            ? 'text-indigo-600 font-semibold'
                            : 'text-gray-600 hover:text-indigo-600' }}"
                >
                    🏠 Dashboard
                </a>

                <a
                    href="{{ route('orangtua.angket.index') }}"
                    class="font-medium transition
                        {{ request()->routeIs('orangtua.angket.*')
                            ? 'text-indigo-600 font-semibold'
                            : 'text-gray-600 hover:text-indigo-600' }}"
                >
                    📝 Angket Harian
                </a>


                {{-- LOGOUT --}}
                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="ml-auto"
                >
                    @csrf

                    <button
                        type="submit"
                        class="text-red-500 hover:text-red-600
                               font-medium transition"
                    >
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </nav>


    {{-- CONTENT --}}
    <main class="min-h-screen">

        @yield('content')

    </main>

</body>

</html>