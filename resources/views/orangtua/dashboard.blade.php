<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Orang Tua - KAIH App
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
                        class="w-11 h-11 bg-indigo-600
                               rounded-xl flex items-center
                               justify-center text-white text-xl"
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
                        class="w-10 h-10 bg-indigo-100
                               rounded-full flex items-center
                               justify-center text-indigo-600
                               font-bold"
                    >
                        {{ strtoupper(substr($user->name ?? 'O', 0, 1)) }}
                    </div>

                    <div class="hidden sm:block">

                        <p class="font-semibold text-gray-800">
                            {{ $user->name ?? 'Orang Tua' }}
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
                    class="text-indigo-600 font-semibold"
                >
                    🏠 Dashboard
                </a>

                <a
                    href="{{ route('orangtua.angket.index') }}"
                    class="text-gray-600 hover:text-indigo-600
                           font-medium transition"
                >
                    📝 Angket Harian
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="ml-auto"
                >
                    @csrf

                    <button
                        type="submit"
                        class="text-red-500 hover:text-red-600
                               font-medium"
                    >
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </nav>


    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">

        {{-- HEADER --}}
        <div class="mb-8">

            <p class="text-sm font-semibold text-indigo-600 mb-1">
                DASHBOARD ORANG TUA
            </p>

            <h2 class="text-3xl font-bold text-gray-900">
                Selamat Datang 👋
            </h2>

            <p class="text-gray-500 mt-2">
                Pantau kegiatan dan kebiasaan harian anak.
            </p>

        </div>


        {{-- DATA ANAK --}}
        <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-6 mb-6"
        >

            <div class="flex items-center gap-4">

                <div
                    class="w-14 h-14 bg-indigo-100
                           rounded-2xl flex items-center
                           justify-center text-2xl"
                >
                    👨‍🎓
                </div>

                <div>

                    <p class="text-sm text-gray-500">
                        Anak Anda
                    </p>

                    <h3 class="text-xl font-bold text-gray-900">

                        {{ $orangTua->siswa->nama_siswa ?? 'Belum ada siswa' }}

                    </h3>

                    @if($orangTua->siswa)

                        <p class="text-sm text-gray-500 mt-1">

                            NIS:
                            {{ $orangTua->siswa->nis }}

                            @if($orangTua->siswa->kelas)
                                — Kelas
                                {{ $orangTua->siswa->kelas->nama_kelas }}
                            @endif

                        </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- MENU --}}
        <div class="grid md:grid-cols-2 gap-6">


            {{-- ANGKET --}}
            <div
                class="bg-white rounded-2xl
                       border border-gray-100
                       shadow-sm p-6"
            >

                <div
                    class="w-12 h-12 bg-indigo-100
                           rounded-xl flex items-center
                           justify-center text-xl mb-4"
                >
                    📝
                </div>

                <h3 class="text-xl font-bold text-gray-900">
                    Angket Harian
                </h3>

                <p class="text-gray-500 mt-2 mb-5">
                    Isi kebiasaan harian anak seperti
                    sholat, belajar, membantu orang tua,
                    bangun pagi, dan tidur malam.
                </p>

                <a
                    href="{{ route('orangtua.angket.create') }}"
                    class="inline-flex items-center
                           justify-center
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white font-semibold
                           px-5 py-3 rounded-xl
                           transition"
                >
                    Isi Angket Hari Ini
                </a>

            </div>


            {{-- RIWAYAT --}}
            <div
                class="bg-white rounded-2xl
                       border border-gray-100
                       shadow-sm p-6"
            >

                <div
                    class="w-12 h-12 bg-green-100
                           rounded-xl flex items-center
                           justify-center text-xl mb-4"
                >
                    📊
                </div>

                <h3 class="text-xl font-bold text-gray-900">
                    Riwayat Angket
                </h3>

                <p class="text-gray-500 mt-2 mb-5">
                    Lihat data angket harian yang sudah
                    diisi sebelumnya.
                </p>

                <a
                    href="{{ route('orangtua.angket.index') }}"
                    class="inline-flex items-center
                           justify-center
                           bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           font-semibold
                           px-5 py-3 rounded-xl
                           transition"
                >
                    Lihat Riwayat
                </a>

            </div>

        </div>

    </main>

</body>

</html>