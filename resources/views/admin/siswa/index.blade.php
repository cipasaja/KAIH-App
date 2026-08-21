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


    {{-- Header --}}
    <div class="px-7 py-6 border-b border-gray-100">

        <h3 class="text-xl font-bold text-gray-900">
            Daftar Siswa
        </h3>

        <p class="text-gray-500 mt-1">
            {{ $siswas->count() }} siswa terdaftar.
        </p>

    </div>


    {{-- Table --}}
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

                            <span class="text-base font-semibold text-gray-800">
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
                                    🎓
                                </div>


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

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection