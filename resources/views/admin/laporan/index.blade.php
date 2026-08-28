@extends('admin.layouts.app')

@section('title', 'Laporan Angket Harian')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="flex flex-col md:flex-row
                md:items-center
                md:justify-between
                gap-4 mb-8">

        <div>

            <p class="text-sm font-medium text-indigo-600 mb-1">
                KAIH App
            </p>

            <h1 class="text-3xl font-bold text-gray-900">
                Laporan Angket Harian
            </h1>

            <p class="text-gray-500 mt-2">
                Rekap kebiasaan harian siswa berdasarkan
                angket yang diisi oleh orang tua.
            </p>

        </div>


        {{-- =================================================
             SATU BUTTON PDF SAJA
        ================================================== --}}

        <div>

            <a
                href="{{ route('laporan.pdf', request()->query()) }}"
                class="inline-flex items-center gap-2
                       bg-red-600
                       hover:bg-red-700
                       text-white
                       font-semibold
                       px-5 py-3
                       rounded-xl
                       transition
                       shadow-sm"
            >

                <span>📄</span>

                <span>
                    Simpan Laporan PDF
                </span>

            </a>

        </div>

    </div>


    {{-- =====================================================
         STATISTIK
    ====================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">


        {{-- TOTAL ANGKET --}}

        <div class="bg-white
                    border border-gray-100
                    rounded-2xl
                    shadow-sm
                    p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Angket
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalAngket }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Data angket ditemukan
                    </p>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-indigo-50
                            flex items-center
                            justify-center
                            text-2xl">

                    📝

                </div>

            </div>

        </div>


        {{-- TOTAL BELAJAR --}}

        <div class="bg-white
                    border border-gray-100
                    rounded-2xl
                    shadow-sm
                    p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Angket Anak Belajar
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalBelajar }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Angket dengan aktivitas belajar
                    </p>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-green-50
                            flex items-center
                            justify-center
                            text-2xl">

                    📚

                </div>

            </div>

        </div>


        {{-- TOTAL SHOLAT --}}

        <div class="bg-white
                    border border-gray-100
                    rounded-2xl
                    shadow-sm
                    p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Sholat Dilaksanakan
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalSholat }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Jumlah sholat yang dilakukan
                    </p>

                </div>

                <div class="w-12 h-12
                            rounded-xl
                            bg-purple-50
                            flex items-center
                            justify-center
                            text-2xl">

                    🕌

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="bg-white
                rounded-2xl
                border border-gray-100
                shadow-sm
                p-6 mb-6">

        <div class="mb-5">

            <h2 class="text-lg font-bold text-gray-800">
                Filter Laporan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pilih tanggal atau siswa untuk melihat data tertentu.
            </p>

        </div>


        <form
            action="{{ route('laporan.index') }}"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4"
        >


            {{-- TANGGAL MULAI --}}

            <div>

                <label class="block text-sm font-semibold
                              text-gray-700 mb-2">

                    Tanggal Mulai

                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="{{ request('tanggal_mulai') }}"
                    class="w-full
                           border border-gray-300
                           rounded-xl
                           px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >

            </div>


            {{-- TANGGAL SELESAI --}}

            <div>

                <label class="block text-sm font-semibold
                              text-gray-700 mb-2">

                    Tanggal Selesai

                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="{{ request('tanggal_selesai') }}"
                    class="w-full
                           border border-gray-300
                           rounded-xl
                           px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >

            </div>


            {{-- SISWA --}}

            <div>

                <label class="block text-sm font-semibold
                              text-gray-700 mb-2">

                    Siswa

                </label>

                <select
                    name="siswa_id"
                    class="w-full
                           border border-gray-300
                           rounded-xl
                           px-4 py-3
                           bg-white
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >

                    <option value="">
                        Semua Siswa
                    </option>

                    @foreach($siswa as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ request('siswa_id') == $item->id ? 'selected' : '' }}
                        >

                            {{ $item->nama_siswa }}

                            @if($item->nis)
                                - {{ $item->nis }}
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- BUTTON FILTER --}}

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           px-5 py-3
                           rounded-xl
                           transition"
                >

                    🔍 Filter

                </button>


                <a
                    href="{{ route('laporan.index') }}"
                    class="px-5 py-3
                           bg-gray-100
                           hover:bg-gray-200
                           text-gray-700
                           font-semibold
                           rounded-xl
                           transition"
                >

                    Reset

                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         TABEL LAPORAN
    ====================================================== --}}

    <div class="bg-white
                rounded-2xl
                border border-gray-100
                shadow-sm
                overflow-hidden">


        {{-- HEADER TABLE --}}

        <div class="px-6 py-5
                    border-b border-gray-100">

            <h2 class="text-lg font-bold text-gray-800">
                Data Laporan Angket
            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Menampilkan
                <strong>{{ $angket->count() }}</strong>
                data angket.

            </p>

        </div>


        {{-- TABLE --}}

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1400px]">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            No
                        </th>

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Siswa
                        </th>

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            NIS
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Bangun
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Subuh
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Dzuhur
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Ashar
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Magrib
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Isya
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Belajar
                        </th>

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Kegiatan Membantu
                        </th>

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Tidur
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($angket as $item)

                        <tr class="hover:bg-gray-50 transition">


                            {{-- NO --}}

                            <td class="px-5 py-4 text-sm text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            {{-- TANGGAL --}}

                            <td class="px-5 py-4">

                                <span class="font-semibold text-gray-800">

                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}

                                </span>

                            </td>


                            {{-- SISWA --}}

                            <td class="px-5 py-4">

                                <p class="font-semibold text-gray-800">

                                    {{ $item->siswa->nama_siswa ?? '-' }}

                                </p>

                            </td>


                            {{-- NIS --}}

                            <td class="px-5 py-4 text-sm text-gray-600">

                                {{ $item->siswa->nis ?? '-' }}

                            </td>


                            {{-- BANGUN --}}

                            <td class="px-5 py-4 text-center text-sm">

                                {{ $item->bangun_pagi ?? '-' }}

                            </td>


                            {{-- SUBUH --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_subuh)

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕

                                    </span>

                                @endif

                            </td>


                            {{-- DZUHUR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_dzuhur)

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕

                                    </span>

                                @endif

                            </td>


                            {{-- ASHAR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_ashar)

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕

                                    </span>

                                @endif

                            </td>


                            {{-- MAGRIB --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_magrib)

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕

                                    </span>

                                @endif

                            </td>


                            {{-- ISYA --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_isya)

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕

                                    </span>

                                @endif

                            </td>


                            {{-- BELAJAR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->belajar)

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-full
                                                 bg-green-50
                                                 text-green-700
                                                 text-xs
                                                 font-semibold">

                                        ✓ Ya

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-full
                                                 bg-red-50
                                                 text-red-600
                                                 text-xs
                                                 font-semibold">

                                        ✕ Tidak

                                    </span>

                                @endif

                            </td>


                            {{-- KEGIATAN --}}

                            <td class="px-5 py-4">

                                @if($item->kegiatan_membantu)

                                    <p class="text-sm text-gray-700 max-w-xs">

                                        {{ $item->kegiatan_membantu }}

                                    </p>

                                @else

                                    <span class="text-sm text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- TIDUR --}}

                            <td class="px-5 py-4 text-center text-sm">

                                {{ $item->tidur_malam ?? '-' }}

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="13"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="w-16 h-16
                                                rounded-2xl
                                                bg-indigo-50
                                                flex items-center
                                                justify-center
                                                text-3xl mb-4">

                                        📊

                                    </div>

                                    <h3 class="font-semibold text-gray-700">

                                        Belum ada data laporan

                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">

                                        Belum ada angket harian yang diisi.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- FOOTER TABLE --}}

        <div class="px-6 py-4
                    border-t border-gray-100
                    flex items-center
                    justify-between">

            <p class="text-sm text-gray-500">

                Total:
                <strong class="text-gray-700">
                    {{ $angket->count() }}
                </strong>
                data angket.

            </p>

        </div>

    </div>

</div>

@endsection