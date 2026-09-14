@extends('admin.layouts.app')

@section('title', 'Laporan Angket Harian')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA SISWA
    |--------------------------------------------------------------------------
    | Controller mengirim data dengan nama $siswas.
    | Blade sebelumnya menggunakan $siswa.
    | Jadi kita buat alias agar tampilan lama tetap bisa digunakan.
    */
    $siswa = $siswas ?? collect();
@endphp


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="mb-8">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            G7KAIH
        </p>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h1 class="text-3xl font-bold text-gray-900">
                    Laporan Angket Harian
                </h1>

                <p class="text-gray-500 mt-2">
                    Rekap kebiasaan harian siswa berdasarkan angket
                    yang diisi oleh orang tua.
                </p>

            </div>


            {{-- CETAK LAPORAN --}}

            <div>

                <a
                    href="{{ route('laporan.pdf', request()->query()) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2
                           bg-indigo-600
                           hover:bg-indigo-700
                           text-white
                           font-semibold
                           px-5 py-3
                           rounded-xl
                           transition
                           shadow-sm"
                >

                    <span class="text-lg">
                        🖨️
                    </span>

                    Cetak Laporan

                </a>

            </div>

        </div>

    </div>


    {{-- =========================================================
         STATISTIK
    ========================================================== --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">


        {{-- TOTAL ANGKET --}}

        <div class="bg-white border border-gray-100
                    rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Angket
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalAngket }}
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-indigo-50
                            flex items-center justify-center
                            text-2xl">

                    📝

                </div>

            </div>

        </div>


        {{-- TOTAL BELAJAR --}}

        <div class="bg-white border border-gray-100
                    rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Angket Anak Belajar
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalBelajar }}
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-green-50
                            flex items-center justify-center
                            text-2xl">

                    📚

                </div>

            </div>

        </div>


        {{-- TOTAL SHOLAT --}}

        <div class="bg-white border border-gray-100
                    rounded-2xl shadow-sm p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Sholat Dilaksanakan
                    </p>

                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalSholat }}
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-purple-50
                            flex items-center justify-center
                            text-2xl">

                    🕌

                </div>

            </div>

        </div>


    </div>


    {{-- =========================================================
         FILTER
    ========================================================== --}}

    <div class="bg-white rounded-2xl
                border border-gray-100
                shadow-sm p-6 mb-6">

        <div class="mb-5">

            <h2 class="text-lg font-bold text-gray-800">
                Filter Laporan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Gunakan filter untuk melihat data tertentu.
            </p>

        </div>


        <form
            action="{{ route('laporan.index') }}"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4"
        >


            {{-- TANGGAL MULAI --}}

            <div>

                <label
                    class="block text-sm font-semibold
                           text-gray-700 mb-2"
                >
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    value="{{ request('tanggal_mulai') }}"
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >

            </div>


            {{-- TANGGAL SELESAI --}}

            <div>

                <label
                    class="block text-sm font-semibold
                           text-gray-700 mb-2"
                >
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    value="{{ request('tanggal_selesai') }}"
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500"
                >

            </div>


            {{-- SISWA --}}

            <div>

                <label
                    class="block text-sm font-semibold
                           text-gray-700 mb-2"
                >
                    Siswa
                </label>

                <select
                    name="siswa_id"
                    class="w-full border border-gray-300
                           rounded-xl px-4 py-3
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


            {{-- BUTTON --}}

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

                    Filter

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


    {{-- =========================================================
         TABEL LAPORAN
    ========================================================== --}}

    <div class="bg-white rounded-2xl
                border border-gray-100
                shadow-sm overflow-hidden">


        {{-- HEADER TABEL --}}

        <div class="px-6 py-5
                    border-b border-gray-100
                    flex flex-col md:flex-row
                    md:items-center
                    md:justify-between
                    gap-3">

            <div>

                <h2 class="text-lg font-bold text-gray-800">
                    Data Laporan Angket
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Menampilkan {{ $angket->count() }}
                    data angket.
                </p>

            </div>


            {{-- CETAK LAPORAN DI HEADER TABEL --}}

            <a
                href="{{ route('laporan.pdf', request()->query()) }}"
                target="_blank"
                class="inline-flex items-center justify-center gap-2
                       bg-gray-800
                       hover:bg-gray-900
                       text-white
                       text-sm
                       font-semibold
                       px-4 py-2.5
                       rounded-xl
                       transition"
            >

                🖨️
                Cetak Laporan

            </a>

        </div>


        {{-- TABLE --}}

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1800px]">

                <thead class="bg-gray-50">

                    <tr>

                        {{-- NO --}}

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            No
                        </th>


                        {{-- TANGGAL --}}

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Tanggal
                        </th>


                        {{-- SISWA --}}

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Siswa
                        </th>


                        {{-- NIS --}}

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            NIS
                        </th>


                        {{-- BANGUN --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Bangun
                        </th>


                        {{-- SUBUH --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Subuh
                        </th>


                        {{-- DZUHUR --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Dzuhur
                        </th>


                        {{-- ASHAR --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Ashar
                        </th>


                        {{-- MAGRIB --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Magrib
                        </th>


                        {{-- ISYA --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Isya
                        </th>


                        {{-- BELAJAR --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Belajar
                        </th>


                        {{-- SARAPAN --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Sarapan
                        </th>


                        {{-- MAKAN SIANG --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Makan Siang
                        </th>


                        {{-- MAKAN MALAM --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Makan Malam
                        </th>


                        {{-- OLAHRAGA --}}

                        <th class="px-5 py-4 text-center
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Olahraga
                        </th>


                        {{-- KEGIATAN MEMBANTU --}}

                        <th class="px-5 py-4 text-left
                                   text-xs font-semibold
                                   text-gray-500 uppercase">
                            Kegiatan Membantu
                        </th>


                        {{-- TIDUR --}}

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

                                    {{
                                        \Carbon\Carbon::parse(
                                            $item->tanggal
                                        )->format('d/m/Y')
                                    }}

                                </span>

                            </td>


                            {{-- SISWA --}}

                            <td class="px-5 py-4">

                                <div>

                                    <p class="font-semibold text-gray-800">

                                        {{ $item->siswa->nama_siswa ?? '-' }}

                                    </p>

                                </div>

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

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕
                                    </span>

                                @endif

                            </td>


                            {{-- DZUHUR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_dzuhur)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕
                                    </span>

                                @endif

                            </td>


                            {{-- ASHAR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_ashar)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕
                                    </span>

                                @endif

                            </td>


                            {{-- MAGRIB --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_magrib)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕
                                    </span>

                                @endif

                            </td>


                            {{-- ISYA --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sholat_isya)

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-2.5 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕
                                    </span>

                                @endif

                            </td>


                            {{-- BELAJAR --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->belajar)

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- SARAPAN --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->sarapan)

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- MAKAN SIANG --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->makan_siang)

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- MAKAN MALAM --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->makan_malam)

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- OLAHRAGA --}}

                            <td class="px-5 py-4 text-center">

                                @if($item->olahraga)

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-green-50
                                               text-green-700
                                               text-xs
                                               font-semibold"
                                    >
                                        ✓ Ya
                                    </span>

                                @else

                                    <span
                                        class="inline-flex
                                               px-3 py-1
                                               rounded-full
                                               bg-red-50
                                               text-red-600
                                               text-xs
                                               font-semibold"
                                    >
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- KEGIATAN MEMBANTU --}}

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
                                colspan="18"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div
                                        class="w-16 h-16
                                               rounded-2xl
                                               bg-indigo-50
                                               flex items-center
                                               justify-center
                                               text-3xl mb-4"
                                    >
                                        📊
                                    </div>


                                    <h3
                                        class="font-semibold
                                               text-gray-700"
                                    >
                                        Belum ada data laporan
                                    </h3>


                                    <p
                                        class="text-sm
                                               text-gray-500 mt-1"
                                    >
                                        Belum ada angket harian
                                        yang diisi.
                                    </p>

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