<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Orang Tua</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

<div class="min-h-screen">

    {{-- HEADER --}}
    <div class="bg-white border-b border-gray-200">

        <div class="max-w-7xl mx-auto px-6 py-5">

            <div class="flex items-center justify-between">

                <div>
                    <h1 class="text-3xl font-bold text-slate-800">
                        Dashboard Orang Tua
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Selamat datang, {{ auth()->user()->name }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-3 rounded-xl transition"
                    >
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>


    <div class="max-w-7xl mx-auto p-6">

        {{-- CARD RINGKASAN --}}
        <div class="grid md:grid-cols-2 gap-6 mb-6">

            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-2xl p-6 shadow">

                <div class="text-sm opacity-80">
                    Data Anak
                </div>

                <h3 class="text-2xl font-bold mt-2">
                    {{ $orangTua->siswa->nama_siswa }}
                </h3>

                <div class="mt-4 space-y-1 text-indigo-100">

                    <p>
                        NIS : {{ $orangTua->siswa->nis }}
                    </p>

                    <p>
                        Kelas :
                        {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
                    </p>

                </div>

            </div>


            <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-2xl p-6 shadow">

                <div class="text-sm opacity-80">
                    Status Angket
                </div>

                <h3 class="text-2xl font-bold mt-2">
                    Belum Diisi
                </h3>

                <p class="mt-4 text-emerald-100">
                    Silakan isi angket harian hari ini.
                </p>

            </div>

        </div>


        {{-- DATA ORANG TUA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

            <h2 class="text-xl font-bold text-slate-800 mb-5">
                Data Orang Tua
            </h2>

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        Nama Orang Tua
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->nama_orang_tua }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Hubungan
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->hubungan }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Nomor HP
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->no_hp ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Pekerjaan
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->pekerjaan ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- DATA SISWA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

            <h2 class="text-xl font-bold text-slate-800 mb-5">
                Data Siswa
            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <div>
                    <p class="text-sm text-gray-500">
                        NIS
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->siswa->nis }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Nama Siswa
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->siswa->nama_siswa }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">
                        Kelas
                    </p>

                    <p class="font-semibold text-slate-800">
                        {{ $orangTua->siswa->kelas->nama_kelas ?? '-' }}
                    </p>
                </div>

            </div>

        </div>


        {{-- AKSI CEPAT --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <h2 class="text-xl font-bold text-slate-800 mb-4">
                Aksi Cepat
            </h2>

            <a
                href="{{ route('orangtua.angket.create') }}"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-3 rounded-xl transition"
            >
                📝 Isi Angket Hari Ini
            </a>

        </div>

    </div>

</div>

</body>
</html>