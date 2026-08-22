@extends('admin.layouts.app')

@section('title', 'Data Orang Tua')
@section('page-title', 'Data Orang Tua')

@section('content')

{{-- =====================================================
    HEADER
====================================================== --}}

<div class="mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <h2 class="text-3xl font-bold text-gray-900">
                Data Orang Tua
            </h2>

            <p class="text-gray-500 mt-1 text-lg">
                Kelola data orang tua dan wali siswa.
            </p>

        </div>


        {{-- Tombol Tambah --}}
        <a
            href="{{ route('orangtua.create') }}"

            class="inline-flex
                   items-center
                   justify-center
                   gap-2
                   bg-indigo-600
                   hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-6
                   py-3.5
                   rounded-xl
                   shadow-sm
                   hover:shadow-md
                   transition
                   whitespace-nowrap"
        >

            <span class="text-xl">
                +
            </span>

            <span>
                Tambah Orang Tua
            </span>

        </a>

    </div>

</div>


{{-- =====================================================
    STATISTIK
====================================================== --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-7">


    {{-- Total Orang Tua --}}
    <div
        class="bg-white
               rounded-2xl
               border border-gray-100
               shadow-sm
               p-6"
    >

        <div class="flex items-center gap-4">

            <div
                class="w-14 h-14
                       rounded-2xl
                       bg-indigo-50
                       flex
                       items-center
                       justify-center
                       text-2xl"
            >

                👨‍👩‍👧

            </div>

            <div>

                <p class="text-gray-500">
                    Total Orang Tua
                </p>

                <p class="text-3xl font-bold text-gray-900 mt-1">
                    {{ $orangTuas->count() }}
                </p>

            </div>

        </div>

    </div>


    {{-- Status Data --}}
    <div
        class="bg-white
               rounded-2xl
               border border-gray-100
               shadow-sm
               p-6"
    >

        <div class="flex items-center gap-4">

            <div
                class="w-14 h-14
                       rounded-2xl
                       bg-green-50
                       flex
                       items-center
                       justify-center
                       text-2xl"
            >

                🏠

            </div>

            <div>

                <p class="text-gray-500">
                    Status Data
                </p>

                @if($orangTuas->count() > 0)

                    <p class="text-lg font-semibold text-green-600 mt-1">
                        ✓ Data tersedia
                    </p>

                @else

                    <p class="text-lg font-semibold text-gray-500 mt-1">
                        Belum ada data
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
    IMPORT & EXPORT
====================================================== --}}

<div
    class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           p-6
           mb-7"
>

    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">


        {{-- Informasi --}}
        <div class="flex items-start gap-4">

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-indigo-50
                       flex
                       items-center
                       justify-center
                       text-xl
                       flex-shrink-0"
            >

                📊

            </div>

            <div>

                <h3 class="text-xl font-bold text-gray-900">
                    Import & Export Data
                </h3>

                <p class="text-gray-500 mt-1">
                    Kelola data orang tua menggunakan file Excel.
                </p>

            </div>

        </div>


        {{-- Form --}}
        <form
            action="{{ route('orangtua.import') }}"
            method="POST"
            enctype="multipart/form-data"

            class="flex flex-col sm:flex-row gap-3"
        >

            @csrf


            {{-- File --}}
            <input
                type="file"
                name="file"
                accept=".xlsx,.xls"
                required

                class="w-full sm:w-auto
                       min-w-[280px]
                       border border-gray-200
                       rounded-xl
                       px-4 py-3
                       text-sm
                       bg-gray-50
                       focus:outline-none
                       focus:ring-2
                       focus:ring-indigo-500
                       focus:border-indigo-500"
            >


            {{-- Import --}}
            <button
                type="submit"

                class="inline-flex
                       items-center
                       justify-center
                       gap-2
                       bg-blue-600
                       hover:bg-blue-700
                       text-white
                       font-semibold
                       px-6
                       py-3
                       rounded-xl
                       transition
                       whitespace-nowrap"
            >

                📥

                <span>
                    Import Excel
                </span>

            </button>


            {{-- Export --}}
            @if(Route::has('orangtua.export'))

                <a
                    href="{{ route('orangtua.export') }}"

                    class="inline-flex
                           items-center
                           justify-center
                           gap-2
                           bg-green-600
                           hover:bg-green-700
                           text-white
                           font-semibold
                           px-6
                           py-3
                           rounded-xl
                           transition
                           whitespace-nowrap"
                >

                    📤

                    <span>
                        Export Excel
                    </span>

                </a>

            @endif

        </form>

    </div>

</div>


{{-- =====================================================
    DAFTAR ORANG TUA
====================================================== --}}

<div
    class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           overflow-hidden"
>


    {{-- Header --}}
    <div class="px-7 py-6 border-b border-gray-100">

        <h3 class="text-xl font-bold text-gray-900">
            Daftar Orang Tua
        </h3>

        <p class="text-gray-500 mt-1">
            {{ $orangTuas->count() }} data orang tua terdaftar.
        </p>

    </div>


   {{-- =================================================
    TABLE
================================================= --}}

<div class="overflow-x-auto">

    <table class="w-full text-sm">

        {{-- HEADER --}}
        <thead class="bg-gray-50">

            <tr>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider
                           w-12"
                >
                    No
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider"
                >
                    Nama Orang Tua
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider
                           w-24"
                >
                    NIS
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider"
                >
                    Siswa
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider
                           w-28"
                >
                    Hubungan
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider"
                >
                    No HP
                </th>

                <th
                    class="px-4 py-3
                           text-left
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider"
                >
                    Pekerjaan
                </th>

                <th
                    class="px-4 py-3
                           text-center
                           text-xs
                           font-semibold
                           text-gray-500
                           uppercase
                           tracking-wider
                           w-40"
                >
                    Aksi
                </th>

            </tr>

        </thead>


        {{-- BODY --}}
        <tbody class="divide-y divide-gray-100">

            @forelse($orangTuas as $orangTua)

                <tr class="hover:bg-gray-50 transition">


                    {{-- NO --}}
                    <td class="px-4 py-4">

                        <span class="text-gray-500">
                            {{ $loop->iteration }}
                        </span>

                    </td>


                    {{-- NAMA ORANG TUA --}}
                    <td class="px-4 py-4">

                        <span class="font-semibold text-gray-800">
                            {{ $orangTua->nama_orang_tua }}
                        </span>

                    </td>


                    {{-- NIS --}}
                    <td class="px-4 py-4">

                        @if($orangTua->siswa)

                            <span class="font-medium text-gray-700">
                                {{ $orangTua->siswa->nis }}
                            </span>

                        @else

                            <span class="text-gray-400">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- SISWA --}}
                    <td class="px-4 py-4">

                        @if($orangTua->siswa)

                            <span class="font-semibold text-gray-800">
                                {{ $orangTua->siswa->nama_siswa }}
                            </span>

                        @else

                            <span
                                class="inline-flex
                                       items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs
                                       font-semibold
                                       bg-gray-100
                                       text-gray-500"
                            >
                                Belum terhubung
                            </span>

                        @endif

                    </td>


                    {{-- HUBUNGAN --}}
                    <td class="px-4 py-4">

                        @if($orangTua->hubungan)

                            <span
                                class="inline-flex
                                       items-center
                                       px-2.5 py-1
                                       rounded-full
                                       text-xs
                                       font-semibold
                                       bg-indigo-50
                                       text-indigo-700"
                            >
                                {{ $orangTua->hubungan }}
                            </span>

                        @else

                            <span class="text-gray-400">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- NO HP --}}
                    <td class="px-4 py-4">

                        <span class="text-gray-700 whitespace-nowrap">
                            {{ $orangTua->no_hp ?? '-' }}
                        </span>

                    </td>


                    {{-- PEKERJAAN --}}
                    <td class="px-4 py-4">

                        <span class="text-gray-700">
                            {{ $orangTua->pekerjaan ?? '-' }}
                        </span>

                    </td>


                    {{-- AKSI --}}
<td class="px-4 py-4">

    <div
        class="flex
               items-center
               justify-center
               gap-2"
    >

        {{-- Edit --}}
        <a
            href="{{ route('orangtua.edit', $orangTua->id) }}"

            class="inline-flex
                   items-center
                   justify-center
                   gap-1.5
                   bg-yellow-500
                   hover:bg-yellow-600
                   text-white
                   text-sm
                   font-semibold
                   px-3.5
                   py-2
                   rounded-lg
                   transition"
        >

            ✏️

            <span>
                Edit
            </span>

        </a>


        {{-- Hapus --}}
        <form
            action="{{ route('orangtua.destroy', $orangTua->id) }}"
            method="POST"

            onsubmit="return confirm(
                'Yakin ingin menghapus data orang tua {{ $orangTua->nama_orang_tua }}?'
            );"
        >

            @csrf

            @method('DELETE')


            <button
                type="submit"

                class="inline-flex
                       items-center
                       justify-center
                       gap-1.5
                       bg-red-500
                       hover:bg-red-600
                       text-white
                       text-sm
                       font-semibold
                       px-3.5
                       py-2
                       rounded-lg
                       transition"
            >

                🗑️

                <span>
                    Hapus
                </span>

            </button>

        </form>

    </div>

</td>
                </tr>


            @empty

                <tr>

                    <td
                        colspan="8"
                        class="px-6 py-14 text-center"
                    >

                        <div
                            class="flex
                                   flex-col
                                   items-center
                                   justify-center"
                        >

                            <div
                                class="w-16 h-16
                                       bg-gray-100
                                       rounded-2xl
                                       flex
                                       items-center
                                       justify-center
                                       text-3xl
                                       mb-4"
                            >
                                👨‍👩‍👧
                            </div>

                            <h4 class="font-semibold text-gray-700">
                                Belum ada data orang tua
                            </h4>

                            <p class="text-sm text-gray-500 mt-1 mb-5">
                                Silakan tambahkan data orang tua terlebih dahulu.
                            </p>

                            <a
                                href="{{ route('orangtua.create') }}"

                                class="inline-flex
                                       items-center
                                       gap-2
                                       bg-indigo-600
                                       hover:bg-indigo-700
                                       text-white
                                       font-semibold
                                       px-4
                                       py-2.5
                                       rounded-xl
                                       transition"
                            >

                                +
                                Tambah Orang Tua

                            </a>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
@endsection