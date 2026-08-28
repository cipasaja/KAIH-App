@extends('orangtua.layout.app')

@section('title', 'Angket Harian')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="flex flex-col lg:flex-row lg:items-center
                lg:justify-between gap-4 mb-8">

        <div>

            <p class="text-sm font-medium text-indigo-600 mb-1">
                KAIH App
            </p>

            <h1 class="text-3xl font-bold text-gray-900">
                Angket Harian
            </h1>

            <p class="text-gray-500 mt-2">
                Catatan kebiasaan harian anak yang diisi oleh orang tua.
            </p>

        </div>


        {{-- BUTTON ISI ANGKET --}}
        <a
            href="{{ route('orangtua.angket.create') }}"
            class="inline-flex items-center justify-center gap-2
                   bg-indigo-600 hover:bg-indigo-700
                   text-white font-semibold
                   px-5 py-3 rounded-xl
                   shadow-sm transition"
        >

            <span class="text-lg">
                +
            </span>

            Isi Angket Hari Ini

        </a>

    </div>


    {{-- =====================================================
         SUCCESS
    ====================================================== --}}
    @if(session('success'))

        <div
            class="mb-6 bg-green-50 border border-green-200
                   text-green-700 px-5 py-4 rounded-xl"
        >

            <div class="flex items-center gap-3">

                <span class="text-lg">
                    ✓
                </span>

                <span class="font-medium">
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =====================================================
         ERROR
    ====================================================== --}}
    @if(session('error'))

        <div
            class="mb-6 bg-red-50 border border-red-200
                   text-red-700 px-5 py-4 rounded-xl"
        >

            <div class="flex items-center gap-3">

                <span class="text-lg">
                    !
                </span>

                <span class="font-medium">
                    {{ session('error') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =====================================================
         ERROR VALIDASI
    ====================================================== --}}
    @if($errors->any())

        <div
            class="mb-6 bg-red-50 border border-red-200
                   text-red-700 px-5 py-4 rounded-xl"
        >

            <ul class="list-disc ml-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         INFO DATA ANAK
    ====================================================== --}}
    <div
        class="bg-gradient-to-r from-indigo-600 to-indigo-700
               rounded-2xl p-6 text-white
               shadow-sm mb-6"
    >

        <div
            class="flex flex-col sm:flex-row
                   sm:items-center sm:justify-between
                   gap-5"
        >

            {{-- DATA ANAK --}}
            <div>

                <p class="text-indigo-200 text-sm font-medium">
                    Anak
                </p>

                <h2 class="text-2xl font-bold mt-1">
                    {{ $orangTua->siswa->nama_siswa }}
                </h2>

                <p class="text-indigo-200 text-sm mt-1">
                    NIS: {{ $orangTua->siswa->nis }}
                </p>

            </div>


            {{-- TOTAL ANGKET --}}
            <div class="text-left sm:text-right">

                <p class="text-indigo-200 text-sm">
                    Total angket
                </p>

                <p class="text-3xl font-bold">
                    {{ $angket->count() }}
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         RIWAYAT ANGKET
    ====================================================== --}}
    <div
        class="bg-white rounded-2xl shadow-sm
               border border-gray-100 overflow-hidden"
    >

        {{-- HEADER RIWAYAT --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <h3 class="text-lg font-bold text-gray-800">
                Riwayat Angket Harian
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Daftar pengisian angket harian anak.
            </p>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1200px]">

                {{-- TABLE HEADER --}}
                <thead class="bg-gray-50">

                    <tr>

                        {{-- NO --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            No
                        </th>


                        {{-- TANGGAL --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Tanggal
                        </th>


                        {{-- BANGUN --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Bangun
                        </th>


                        {{-- KEGIATAN --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Kegiatan
                        </th>


                        {{-- SHOLAT --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Sholat 5 Waktu
                        </th>


                        {{-- BELAJAR --}}
                        <th
                            class="px-6 py-4 text-center text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Belajar
                        </th>


                        {{-- TIDUR --}}
                        <th
                            class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider"
                        >
                            Tidur
                        </th>

                    </tr>

                </thead>


                {{-- =================================================
                     TABLE BODY
                ================================================== --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($angket as $item)

                        <tr class="hover:bg-gray-50 transition">


                            {{-- =====================================
                                 NO
                            ====================================== --}}
                            <td class="px-6 py-4 text-sm text-gray-500">

                                {{ $loop->iteration }}

                            </td>


                            {{-- =====================================
                                 TANGGAL
                            ====================================== --}}
                            <td class="px-6 py-4">

                                <span class="font-semibold text-gray-800">

                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}

                                </span>

                            </td>


                            {{-- =====================================
                                 JAM BANGUN
                            ====================================== --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">

                                    {{ $item->bangun_pagi ?? '-' }}

                                </span>

                            </td>


                            {{-- =====================================
                                 KEGIATAN MEMBANTU ORANG TUA
                            ====================================== --}}
                            <td class="px-6 py-4">

                                @if($item->kegiatan_membantu)

                                    <div class="max-w-xs">

                                        <p
                                            class="text-sm text-gray-700
                                                   leading-relaxed"
                                        >
                                            {{ $item->kegiatan_membantu }}
                                        </p>

                                    </div>

                                @else

                                    <span class="text-sm text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- =====================================
                                 SHOLAT 5 WAKTU
                            ====================================== --}}
                            <td class="px-6 py-4">

                                <div class="flex flex-wrap gap-1.5">


                                    {{-- SUBUH --}}
                                    @if($item->sholat_subuh)

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-green-50 text-green-700
                                                   text-xs font-semibold"
                                        >
                                            ✓ Subuh
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-gray-100 text-gray-400
                                                   text-xs font-medium"
                                        >
                                            ✕ Subuh
                                        </span>

                                    @endif


                                    {{-- DZUHUR --}}
                                    @if($item->sholat_dzuhur)

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-green-50 text-green-700
                                                   text-xs font-semibold"
                                        >
                                            ✓ Dzuhur
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-gray-100 text-gray-400
                                                   text-xs font-medium"
                                        >
                                            ✕ Dzuhur
                                        </span>

                                    @endif


                                    {{-- ASHAR --}}
                                    @if($item->sholat_ashar)

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-green-50 text-green-700
                                                   text-xs font-semibold"
                                        >
                                            ✓ Ashar
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-gray-100 text-gray-400
                                                   text-xs font-medium"
                                        >
                                            ✕ Ashar
                                        </span>

                                    @endif


                                    {{-- MAGRIB --}}
                                    @if($item->sholat_magrib)

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-green-50 text-green-700
                                                   text-xs font-semibold"
                                        >
                                            ✓ Magrib
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-gray-100 text-gray-400
                                                   text-xs font-medium"
                                        >
                                            ✕ Magrib
                                        </span>

                                    @endif


                                    {{-- ISYA --}}
                                    @if($item->sholat_isya)

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-green-50 text-green-700
                                                   text-xs font-semibold"
                                        >
                                            ✓ Isya
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center
                                                   px-2.5 py-1 rounded-lg
                                                   bg-gray-100 text-gray-400
                                                   text-xs font-medium"
                                        >
                                            ✕ Isya
                                        </span>

                                    @endif

                                </div>

                            </td>


                            {{-- =====================================
                                 BELAJAR
                            ====================================== --}}
                            <td class="px-6 py-4 text-center">

                                @if($item->belajar)

                                    <span
                                        class="inline-flex items-center
                                               px-3 py-1 rounded-full
                                               bg-green-50 text-green-700
                                               text-xs font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center
                                               px-3 py-1 rounded-full
                                               bg-red-50 text-red-600
                                               text-xs font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- =====================================
                                 JAM TIDUR
                            ====================================== --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">

                                    {{ $item->tidur_malam ?? '-' }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        {{-- =========================================
                             EMPTY STATE
                        ========================================== --}}
                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center">


                                    {{-- ICON --}}
                                    <div
                                        class="w-16 h-16 rounded-2xl
                                               bg-indigo-50
                                               flex items-center
                                               justify-center
                                               text-3xl mb-4"
                                    >
                                        📝
                                    </div>


                                    {{-- TITLE --}}
                                    <h4 class="font-semibold text-gray-700">
                                        Belum ada angket
                                    </h4>


                                    {{-- DESCRIPTION --}}
                                    <p
                                        class="text-sm text-gray-500
                                               mt-1 mb-5"
                                    >
                                        Belum ada pengisian angket harian.
                                    </p>


                                    {{-- BUTTON --}}
                                    <a
                                        href="{{ route('orangtua.angket.create') }}"
                                        class="bg-indigo-600 hover:bg-indigo-700
                                               text-white font-semibold
                                               px-4 py-2.5 rounded-xl
                                               transition"
                                    >
                                        + Isi Angket Hari Ini
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection