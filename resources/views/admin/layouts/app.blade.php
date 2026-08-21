<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - KAIH App
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen">

        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}

        <aside
            class="fixed inset-y-0 left-0 z-40
                   w-72
                   bg-white
                   border-r border-slate-200
                   flex flex-col"
        >

            {{-- LOGO --}}
            <div class="px-6 py-6 border-b border-slate-100">

                <div class="flex items-center gap-3">

                    <div
                        class="w-11 h-11
                               rounded-2xl
                               bg-indigo-600
                               flex items-center justify-center
                               text-xl
                               shadow-lg shadow-indigo-200"
                    >
                        🎓
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-slate-900">
                            KAIH App
                        </h1>

                        <p class="text-xs text-slate-400 mt-0.5">
                            Sistem Akademik
                        </p>
                    </div>

                </div>

            </div>


            {{-- USER INFO --}}
            <div class="px-5 pt-5">

                <div
                    class="bg-slate-50
                           border border-slate-100
                           rounded-2xl
                           p-4"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10
                                   rounded-xl
                                   bg-indigo-100
                                   text-indigo-700
                                   flex items-center justify-center
                                   font-bold"
                        >
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <div class="min-w-0">

                            <p class="font-semibold text-sm text-slate-800 truncate">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Administrator
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- MENU --}}
            <nav class="flex-1 px-4 py-6 overflow-y-auto">

                <p
                    class="px-3 mb-3
                           text-[11px]
                           font-bold
                           uppercase
                           tracking-wider
                           text-slate-400"
                >
                    Menu Utama
                </p>


                {{-- Dashboard --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           transition
                           {{ request()->routeIs('admin.dashboard')
                                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                                : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}"
                >

                    <span class="text-lg">🏠</span>

                    <span>Dashboard</span>

                </a>


                {{-- Jurusan --}}
                <a
                    href="{{ route('jurusan.index') }}"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           transition
                           {{ request()->routeIs('jurusan.*')
                                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                                : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}"
                >

                    <span class="text-lg">🏫</span>

                    <span>Jurusan</span>

                </a>


                {{-- Kelas --}}
                <a
                    href="{{ route('kelas.index') }}"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           transition
                           {{ request()->routeIs('kelas.*')
                                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                                : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}"
                >

                    <span class="text-lg">📚</span>

                    <span>Kelas</span>

                </a>


                {{-- Siswa --}}
                <a
                    href="{{ route('siswa.index') }}"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           transition
                           {{ request()->routeIs('siswa.*')
                                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                                : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}"
                >

                    <span class="text-lg">👨‍🎓</span>

                    <span>Siswa</span>

                </a>


                {{-- Orang Tua --}}
                <a
                    href="{{ route('orangtua.index') }}"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           transition
                           {{ request()->routeIs('orangtua.*')
                                ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200'
                                : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-700' }}"
                >

                    <span class="text-lg">👨‍👩‍👧</span>

                    <span>Orang Tua</span>

                </a>


                {{-- Laporan --}}
                <a
                    href="#"
                    class="flex items-center gap-3
                           px-4 py-3
                           mb-1
                           rounded-xl
                           text-sm font-semibold
                           text-slate-600
                           hover:bg-indigo-50
                           hover:text-indigo-700
                           transition"
                >

                    <span class="text-lg">📊</span>

                    <span>Laporan</span>

                    <span
                        class="ml-auto
                               text-[10px]
                               bg-slate-100
                               text-slate-400
                               px-2 py-1
                               rounded-full"
                    >
                        Soon
                    </span>

                </a>

            </nav>


            {{-- LOGOUT --}}
            <div class="p-4 border-t border-slate-100">

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full
                               flex items-center justify-center gap-2
                               px-4 py-3
                               rounded-xl
                               text-sm font-semibold
                               text-red-600
                               bg-red-50
                               hover:bg-red-100
                               transition"
                    >

                        <span>🚪</span>

                        <span>Keluar dari Akun</span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- =====================================================
            MAIN AREA
        ====================================================== --}}

        <div class="ml-72 min-h-screen">


            {{-- HEADER --}}
            <header
                class="sticky top-0 z-30
                       h-20
                       bg-white/90
                       backdrop-blur
                       border-b border-slate-200"
            >

                <div
                    class="h-full
                           px-8
                           flex items-center justify-between"
                >

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                            Admin Panel
                        </p>

                        <h2 class="text-xl font-bold text-slate-900">
                            @yield('page-title', 'Dashboard')
                        </h2>

                    </div>


                    {{-- RIGHT HEADER --}}
                    <div class="flex items-center gap-4">

                        {{-- Notification --}}
                        <button
                            type="button"
                            class="relative
                                   w-10 h-10
                                   rounded-xl
                                   bg-slate-50
                                   hover:bg-indigo-50
                                   flex items-center justify-center
                                   transition"
                        >

                            🔔

                            <span
                                class="absolute top-2 right-2
                                       w-2 h-2
                                       bg-red-500
                                       rounded-full
                                       border-2 border-white"
                            ></span>

                        </button>


                        {{-- User --}}
                        <div class="flex items-center gap-3">

                            <div
                                class="w-10 h-10
                                       rounded-xl
                                       bg-indigo-600
                                       text-white
                                       flex items-center justify-center
                                       font-bold"
                            >
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>

                            <div class="hidden sm:block">

                                <p class="text-sm font-semibold text-slate-800">
                                    {{ Auth::user()->name ?? 'Admin' }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    Administrator
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </header>


            {{-- MAIN CONTENT --}}
            <main class="p-6 lg:p-8">


                {{-- SUCCESS --}}
                @if(session('success'))

                    <div
                        class="mb-6
                               flex items-center gap-3
                               bg-emerald-50
                               border border-emerald-200
                               text-emerald-700
                               px-5 py-4
                               rounded-2xl"
                    >

                        <div
                            class="w-9 h-9
                                   rounded-xl
                                   bg-emerald-100
                                   flex items-center justify-center"
                        >
                            ✓
                        </div>

                        <div>

                            <p class="font-semibold">
                                Berhasil
                            </p>

                            <p class="text-sm">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                @endif


                {{-- ERROR --}}
                @if(session('error'))

                    <div
                        class="mb-6
                               flex items-center gap-3
                               bg-red-50
                               border border-red-200
                               text-red-700
                               px-5 py-4
                               rounded-2xl"
                    >

                        <div
                            class="w-9 h-9
                                   rounded-xl
                                   bg-red-100
                                   flex items-center justify-center"
                        >
                            !
                        </div>

                        <div>

                            <p class="font-semibold">
                                Terjadi Kesalahan
                            </p>

                            <p class="text-sm">
                                {{ session('error') }}
                            </p>

                        </div>

                    </div>

                @endif


                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>