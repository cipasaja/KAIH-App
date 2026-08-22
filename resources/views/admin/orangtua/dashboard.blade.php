<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Orang Tua</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

<div class="min-h-screen">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <header class="bg-white border-b border-gray-100">

        <div class="max-w-7xl mx-auto px-6 py-5">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>

                    <p class="text-sm font-medium text-indigo-600 mb-1">
                        Portal Orang Tua
                    </p>

                    <h1 class="text-2xl font-bold text-gray-900">
                        Dashboard
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Selamat datang,
                        <span class="font-semibold text-gray-700">
                            {{ auth()->user()->name }}
                        </span>
                    </p>

                </div>


                {{-- Logout --}}

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               bg-red-500
                               hover:bg-red-600
                               text-white
                               text-sm
                               font-semibold
                               px-4
                               py-2.5
                               rounded-xl
                               shadow-sm
                               transition"
                    >

                        <span>↪</span>

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </header>


    {{-- =====================================================
        CONTENT
    ====================================================== --}}

    <main class="max-w-7xl mx-auto px-6 py-8">


        {{-- =================================================
            WELCOME
        ================================================== --}}

        <div class="mb-7">

            <h2 class="text-xl font-bold text-gray-900">
                Informasi Anak
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pantau informasi dan perkembangan data anak Anda.
            </p>

        </div>


        {{-- =================================================
            SUMMARY CARD
        ================================================== --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-7">


            {{-- DATA ANAK --}}

            <div
                class="bg-indigo-600
                       rounded-2xl
                       p-6
                       text-white
                       shadow-sm"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-indigo-200">
                            Data Anak
                        </p>

                        <h3 class="text-2xl font-bold mt-2">
                            {{ $orangTua->siswa->nama_siswa }}
                        </h3>

                    </div>

                    <div
                        class="w-11 h-11
                               rounded-xl
                               bg-white/10
                               flex
                               items-center
                               justify-center
                               text-xl"
                    >
                        👨‍🎓
                    </div>

                </div>


                <div class="mt-5 flex flex-wrap gap-2">

                    <span
                        class="inline-flex
                               items-center
                               bg-white/10
                               px-3 py-1.5
                               rounded-lg
                               text-sm"
                    >
                        NIS: {{ $orangTua->siswa->nis }}
                    </span>

                    <span
                        class="inline-flex
                               items-center
                               bg-white/10
                               px-3 py-1.5
                               rounded-lg
                               text-sm"
                    >
                        Kelas:
                        {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
                    </span>

                </div>

            </div>


            {{-- STATUS ANGKET --}}

            <div
                class="bg-white
                       rounded-2xl
                       p-6
                       shadow-sm
                       border border-gray-100"
            >

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Status Angket Hari Ini
                        </p>

                        <h3 class="text-2xl font-bold text-gray-800 mt-2">
                            Belum Diisi
                        </h3>

                    </div>

                    <div
                        class="w-11 h-11
                               rounded-xl
                               bg-emerald-50
                               flex
                               items-center
                               justify-center
                               text-xl"
                    >
                        📝
                    </div>

                </div>


                <p class="text-sm text-gray-500 mt-4">
                    Silakan isi angket harian untuk memberikan informasi
                    mengenai kondisi anak hari ini.
                </p>

            </div>

        </div>


        {{-- =================================================
            GRID DATA ORANG TUA + SISWA
        ================================================== --}}

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-7">


            {{-- DATA ORANG TUA --}}

            <div
                class="bg-white
                       rounded-2xl
                       shadow-sm
                       border border-gray-100
                       overflow-hidden"
            >

                <div class="px-6 py-5 border-b border-gray-100">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10
                                   rounded-xl
                                   bg-indigo-50
                                   flex
                                   items-center
                                   justify-center"
                        >
                            👨‍👩‍👧
                        </div>

                        <div>

                            <h3 class="font-bold text-gray-800">
                                Data Orang Tua
                            </h3>

                            <p class="text-xs text-gray-500 mt-0.5">
                                Informasi akun orang tua
                            </p>

                        </div>

                    </div>

                </div>


                <div class="p-6 space-y-5">


                    {{-- Nama --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Nama Orang Tua
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $orangTua->nama_orang_tua }}
                        </p>

                    </div>


                    {{-- Hubungan --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Hubungan
                        </p>

                        <span
                            class="inline-flex
                                   items-center
                                   mt-1
                                   px-3 py-1
                                   rounded-full
                                   text-xs
                                   font-semibold
                                   bg-indigo-50
                                   text-indigo-700"
                        >
                            {{ $orangTua->hubungan ?? '-' }}
                        </span>

                    </div>


                    {{-- No HP --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Nomor HP
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $orangTua->no_hp ?? '-' }}
                        </p>

                    </div>


                    {{-- Pekerjaan --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Pekerjaan
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $orangTua->pekerjaan ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- DATA SISWA --}}

            <div
                class="bg-white
                       rounded-2xl
                       shadow-sm
                       border border-gray-100
                       overflow-hidden"
            >

                <div class="px-6 py-5 border-b border-gray-100">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-10 h-10
                                   rounded-xl
                                   bg-blue-50
                                   flex
                                   items-center
                                   justify-center"
                        >
                            🎓
                        </div>

                        <div>

                            <h3 class="font-bold text-gray-800">
                                Data Siswa
                            </h3>

                            <p class="text-xs text-gray-500 mt-0.5">
                                Informasi anak yang terhubung
                            </p>

                        </div>

                    </div>

                </div>


                <div class="p-6 space-y-5">


                    {{-- NIS --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            NIS
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $orangTua->siswa->nis }}
                        </p>

                    </div>


                    {{-- Nama --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Nama Siswa
                        </p>

                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $orangTua->siswa->nama_siswa }}
                        </p>

                    </div>


                    {{-- Kelas --}}

                    <div>

                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">
                            Kelas
                        </p>

                        <span
                            class="inline-flex
                                   items-center
                                   mt-1
                                   px-3 py-1
                                   rounded-full
                                   text-xs
                                   font-semibold
                                   bg-indigo-50
                                   text-indigo-700"
                        >
                            {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
            AKSI CEPAT
        ================================================== --}}

        <div
            class="bg-white
                   rounded-2xl
                   shadow-sm
                   border border-gray-100
                   overflow-hidden"
        >

            <div class="px-6 py-5 border-b border-gray-100">

                <h3 class="font-bold text-gray-800">
                    Aksi Cepat
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Akses fitur yang dapat digunakan oleh orang tua.
                </p>

            </div>


            <div class="p-6">

                <a
                    href="{{ route('orangtua.angket.create') }}"
                    class="inline-flex
                           items-center
                           justify-center
                           gap-2
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           px-5
                           py-3
                           rounded-xl
                           shadow-sm
                           hover:shadow-md
                           transition"
                >

                    <span>
                        📝
                    </span>

                    Isi Angket Hari Ini

                </a>

            </div>

        </div>


    </main>

</div>

</body>
</html>