@extends('admin.layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@section('content')

{{-- =========================================================
    HEADER
========================================================= --}}

<div class="mb-8">

    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

        <div>

            <h2 class="text-3xl font-bold text-gray-900">
                Data Siswa
            </h2>

            <p class="text-gray-500 mt-1 text-lg">
                Kelola data siswa dan informasi kelas.
            </p>

        </div>


        {{-- Tombol Tambah --}}
        <a
            href="{{ route('siswa.create') }}"
            class="inline-flex
                   items-center
                   justify-center
                   gap-2
                   bg-indigo-600
                   hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-6
                   py-3
                   rounded-xl
                   shadow-sm
                   hover:shadow-md
                   transition"
        >

            <span class="text-xl">
                +
            </span>

            <span>
                Tambah Siswa
            </span>

        </a>

    </div>

</div>


{{-- =========================================================
    PESAN SUKSES
========================================================= --}}

@if(session('success'))

    <div
        class="mb-6
               bg-green-50
               border border-green-200
               text-green-700
               px-5
               py-4
               rounded-xl"
    >

        <div class="flex items-center gap-3">

            <span class="text-xl">
                ✓
            </span>

            <span class="font-medium">
                {{ session('success') }}
            </span>

        </div>

    </div>

@endif


{{-- =========================================================
    ERROR
========================================================= --}}

@if($errors->any())

    <div
        class="mb-6
               bg-red-50
               border border-red-200
               text-red-700
               px-5
               py-4
               rounded-xl"
    >

        <ul class="list-disc list-inside">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- =========================================================
    STATISTIK
========================================================= --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-7">


    {{-- Total Siswa --}}
    <div
        class="bg-white
               rounded-2xl
               border border-gray-100
               shadow-sm
               p-6"
    >

        <div class="flex items-center gap-5">

            <div
                class="w-14 h-14
                       rounded-2xl
                       bg-indigo-50
                       flex
                       items-center
                       justify-center
                       text-2xl"
            >
                🎓
            </div>

            <div>

                <p class="text-gray-500 text-base">
                    Total Siswa
                </p>

                <p class="text-3xl font-bold text-gray-900 mt-1">
                    {{ $siswas->count() }}
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

        <div class="flex items-center gap-5">

            <div
                class="w-14 h-14
                       rounded-2xl
                       bg-green-50
                       flex
                       items-center
                       justify-center
                       text-2xl"
            >
                🏫
            </div>

            <div>

                <p class="text-gray-500 text-base">
                    Status Data
                </p>

                @if($siswas->count() > 0)

                    <p class="text-green-600 font-semibold mt-1">
                        ✓ Data tersedia
                    </p>

                @else

                    <p class="text-gray-400 font-semibold mt-1">
                        Belum ada data
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    IMPORT & EXPORT
========================================================= --}}

<div
    class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           p-6
           mb-7"
>

    <div class="flex items-start gap-4 mb-6">

        <div
            class="w-12 h-12
                   rounded-2xl
                   bg-indigo-50
                   flex
                   items-center
                   justify-center
                   text-xl
                   shrink-0"
        >
            📊
        </div>

        <div>

            <h3 class="text-xl font-bold text-gray-900">
                Import & Export Data
            </h3>

            <p class="text-gray-500 mt-1">
                Kelola data siswa menggunakan file Excel.
            </p>

        </div>

    </div>


    <div class="flex flex-col lg:flex-row gap-3">


        {{-- Form Import --}}
        <form
            action="{{ route('siswa.import') }}"
            method="POST"
            enctype="multipart/form-data"
            class="flex flex-col sm:flex-row gap-3 flex-1"
        >

            @csrf

            <input
                type="file"
                name="file"
                accept=".xlsx,.xls"
                required

                class="w-full
                       sm:max-w-md
                       border
                       border-gray-200
                       rounded-xl
                       px-4
                       py-3
                       text-sm
                       bg-gray-50
                       focus:outline-none
                       focus:ring-2
                       focus:ring-indigo-500
                       focus:border-indigo-500"
            >


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

        </form>


        {{-- Export --}}
        <a
            href="{{ route('siswa.export') }}"

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

    </div>

</div>


{{-- =========================================================
    DAFTAR SISWA
========================================================= --}}

<div
    class="bg-white
           rounded-2xl
           border border-gray-100
           shadow-sm
           overflow-hidden"
>


    {{-- =====================================================
        HEADER DAFTAR + PENCARIAN
    ====================================================== --}}

    <div
        class="px-7 py-6
               border-b border-gray-100"
    >

        <div
            class="flex
                   flex-col
                   lg:flex-row
                   lg:items-center
                   lg:justify-between
                   gap-5"
        >


            {{-- Judul --}}
            <div>

                <h3 class="text-xl font-bold text-gray-900">
                    Daftar Siswa
                </h3>

                <p class="text-gray-500 mt-1">

                    @if(!empty($search))

                        Hasil pencarian untuk:
                        <span class="font-semibold text-gray-700">
                            "{{ $search }}"
                        </span>

                    @else

                        {{ $siswas->count() }} siswa terdaftar.

                    @endif

                </p>

            </div>


            {{-- =================================================
                FORM PENCARIAN
            ================================================== --}}

            <form
                action="{{ route('siswa.index') }}"
                method="GET"
                class="flex
                       flex-col
                       sm:flex-row
                       gap-2
                       w-full
                       lg:w-auto"
            >

                <div class="relative">

                    <span
                        class="absolute
                               left-4
                               top-1/2
                               -translate-y-1/2
                               text-gray-400"
                    >
                        🔍
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari NIS / nama / kelas..."

                        class="w-full
                               sm:w-80
                               border
                               border-gray-200
                               rounded-xl
                               pl-11
                               pr-4
                               py-3
                               text-sm
                               bg-gray-50
                               focus:outline-none
                               focus:ring-2
                               focus:ring-indigo-500
                               focus:border-indigo-500"
                    >

                </div>


                {{-- Tombol Cari --}}
                <button
                    type="submit"

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
                           transition
                           whitespace-nowrap"
                >

                    🔍

                    Cari

                </button>


                {{-- Tombol Reset --}}
                @if(!empty($search))

                    <a
                        href="{{ route('siswa.index') }}"

                        class="inline-flex
                               items-center
                               justify-center
                               bg-gray-100
                               hover:bg-gray-200
                               text-gray-700
                               font-semibold
                               px-5
                               py-3
                               rounded-xl
                               transition
                               whitespace-nowrap"
                    >

                        Reset

                    </a>

                @endif

            </form>

        </div>

    </div>


    {{-- =====================================================
        INFO HASIL PENCARIAN
    ====================================================== --}}

    @if(!empty($search))

        <div
            class="px-7 py-4
                   bg-indigo-50
                   border-b border-indigo-100"
        >

            <p class="text-sm text-indigo-700">

                🔎 Menampilkan
                <strong>{{ $siswas->count() }}</strong>
                data siswa yang cocok dengan pencarian
                <strong>"{{ $search }}"</strong>.

            </p>

        </div>

    @endif


    {{-- =====================================================
        TABLE
    ====================================================== --}}

    <div class="overflow-x-auto">

        <table class="w-full">


            {{-- =================================================
                HEADER TABLE
            ================================================== --}}

            <thead class="bg-gray-50">

                <tr>

                    <th
                        class="px-7 py-5
                               text-left
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider
                               w-20"
                    >
                        No
                    </th>


                    <th
                        class="px-7 py-5
                               text-left
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        NIS
                    </th>


                    <th
                        class="px-7 py-5
                               text-left
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Nama Siswa
                    </th>


                    <th
                        class="px-7 py-5
                               text-left
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Jenis Kelamin
                    </th>


                    <th
                        class="px-7 py-5
                               text-left
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider"
                    >
                        Kelas
                    </th>


                    <th
                        class="px-7 py-5
                               text-center
                               text-sm
                               font-semibold
                               text-gray-500
                               uppercase
                               tracking-wider
                               w-56"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>


            {{-- =================================================
                BODY
            ================================================== --}}

            <tbody class="divide-y divide-gray-100">

                @forelse($siswas as $siswa)

                    <tr class="hover:bg-gray-50 transition">


                        {{-- No --}}
                        <td class="px-7 py-5">

                            <span
                                class="inline-flex
                                       items-center
                                       justify-center
                                       w-9
                                       h-9
                                       rounded-xl
                                       bg-gray-50
                                       text-gray-600
                                       font-medium"
                            >
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- NIS --}}
                        <td class="px-7 py-5">

                            <span
                                class="text-base
                                       font-semibold
                                       text-gray-800"
                            >
                                {{ $siswa->nis }}
                            </span>

                        </td>


                        {{-- Nama --}}
                        <td class="px-7 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-indigo-50
                                           flex
                                           items-center
                                           justify-center
                                           text-lg"
                                >
                                    🎓
                                </div>

                                <div>

                                    <p class="font-semibold text-gray-900">
                                        {{ $siswa->nama_siswa }}
                                    </p>

                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Siswa sekolah
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Jenis Kelamin --}}
                        <td class="px-7 py-5">

                            @if($siswa->jenis_kelamin === 'L')

                                <span
                                    class="inline-flex
                                           items-center
                                           px-4
                                           py-2
                                           rounded-full
                                           text-sm
                                           font-semibold
                                           bg-blue-50
                                           text-blue-700"
                                >
                                    Laki-laki
                                </span>

                            @elseif($siswa->jenis_kelamin === 'P')

                                <span
                                    class="inline-flex
                                           items-center
                                           px-4
                                           py-2
                                           rounded-full
                                           text-sm
                                           font-semibold
                                           bg-pink-50
                                           text-pink-700"
                                >
                                    Perempuan
                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           px-4
                                           py-2
                                           rounded-full
                                           text-sm
                                           font-semibold
                                           bg-gray-100
                                           text-gray-500"
                                >
                                    -
                                </span>

                            @endif

                        </td>


                        {{-- Kelas --}}
                        <td class="px-7 py-5">

                            @if($siswa->kelas)

                                <div class="flex items-center gap-2">

                                    <span
                                        class="inline-flex
                                               items-center
                                               gap-2
                                               px-4
                                               py-2
                                               rounded-xl
                                               bg-indigo-50
                                               text-indigo-700
                                               text-sm
                                               font-semibold"
                                    >

                                        📚

                                        {{ $siswa->kelas->nama_kelas }}

                                    </span>

                                </div>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           px-4
                                           py-2
                                           rounded-xl
                                           bg-gray-100
                                           text-gray-500
                                           text-sm
                                           font-medium"
                                >
                                    Tidak ada kelas
                                </span>

                            @endif

                        </td>


                        {{-- Aksi --}}
                        <td class="px-7 py-5">

                            <div
                                class="flex
                                       items-center
                                       justify-center
                                       gap-2"
                            >

                                {{-- Edit --}}
                                <a
                                    href="{{ route('siswa.edit', $siswa->id) }}"

                                    class="inline-flex
                                           items-center
                                           justify-center
                                           gap-2
                                           bg-yellow-50
                                           hover:bg-yellow-100
                                           text-yellow-600
                                           font-semibold
                                           px-4
                                           py-2.5
                                           rounded-xl
                                           transition"
                                >

                                    ✏️

                                    <span>
                                        Edit
                                    </span>

                                </a>


                                {{-- Hapus --}}
                                <form
                                    action="{{ route('siswa.destroy', $siswa->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus siswa {{ $siswa->nama_siswa }}?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"

                                        class="inline-flex
                                               items-center
                                               justify-center
                                               gap-2
                                               bg-red-50
                                               hover:bg-red-100
                                               text-red-600
                                               font-semibold
                                               px-4
                                               py-2.5
                                               rounded-xl
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

                    {{-- =================================================
                        EMPTY STATE
                    ================================================== --}}

                    <tr>

                        <td
                            colspan="6"
                            class="px-7 py-16 text-center"
                        >

                            <div
                                class="flex
                                       flex-col
                                       items-center
                                       justify-center"
                            >

                                <div
                                    class="w-16
                                           h-16
                                           rounded-2xl
                                           bg-indigo-50
                                           flex
                                           items-center
                                           justify-center
                                           text-3xl
                                           mb-4"
                                >
                                    🔍
                                </div>


                                @if(!empty($search))

                                    <h4 class="text-lg font-bold text-gray-800">
                                        Data siswa tidak ditemukan
                                    </h4>

                                    <p class="text-gray-500 mt-1 mb-5">
                                        Tidak ada siswa yang cocok dengan
                                        "{{ $search }}".
                                    </p>

                                    <a
                                        href="{{ route('siswa.index') }}"

                                        class="inline-flex
                                               items-center
                                               gap-2
                                               bg-gray-100
                                               hover:bg-gray-200
                                               text-gray-700
                                               font-semibold
                                               px-5
                                               py-3
                                               rounded-xl
                                               transition"
                                    >
                                        Reset Pencarian
                                    </a>

                                @else

                                    <h4 class="text-lg font-bold text-gray-800">
                                        Belum ada data siswa
                                    </h4>

                                    <p class="text-gray-500 mt-1 mb-5">
                                        Silakan tambahkan data siswa terlebih dahulu.
                                    </p>

                                    <a
                                        href="{{ route('siswa.create') }}"

                                        class="inline-flex
                                               items-center
                                               gap-2
                                               bg-indigo-600
                                               hover:bg-indigo-700
                                               text-white
                                               font-semibold
                                               px-5
                                               py-3
                                               rounded-xl
                                               transition"
                                    >

                                        +

                                        Tambah Siswa

                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <div
        class="px-7 py-5
               border-t border-gray-100
               bg-gray-50"
    >

        <p class="text-sm text-gray-500">

            @if(!empty($search))

                Menampilkan
                <strong class="text-gray-700">
                    {{ $siswas->count() }}
                </strong>
                hasil pencarian.

            @else

                Total:
                <strong class="text-gray-700">
                    {{ $siswas->count() }}
                </strong>
                data siswa.

            @endif

        </p>

    </div>

</div>

@endsection