@extends('admin.layouts.app')

@section('title', 'Data Kelas')
@section('page-title', 'Data Kelas')

@section('content')

{{-- =====================================================
    HEADER
====================================================== --}}

<div class="mb-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        <div>

            <p class="text-sm font-semibold text-indigo-600 mb-1">
                Data Akademik
            </p>

            <h1 class="text-2xl lg:text-3xl font-bold text-slate-900">
                Data Kelas
            </h1>

            <p class="text-slate-500 mt-1">
                Kelola kelas dan jurusan yang tersedia di sekolah.
            </p>

        </div>


        <a
            href="{{ route('kelas.create') }}"
            class="inline-flex items-center justify-center
                   gap-2
                   bg-indigo-600 hover:bg-indigo-700
                   text-white
                   font-semibold
                   px-5 py-3
                   rounded-xl
                   shadow-sm hover:shadow-md
                   transition"
        >

            <span class="text-lg">+</span>

            <span>Tambah Kelas</span>

        </a>

    </div>

</div>


{{-- =====================================================
    NOTIFIKASI SUCCESS
====================================================== --}}

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
            class="w-9 h-9 rounded-xl
                   bg-emerald-100
                   flex items-center justify-center
                   font-bold"
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


{{-- =====================================================
    ERROR
====================================================== --}}

@if($errors->any())

    <div
        class="mb-6
               bg-red-50
               border border-red-200
               text-red-700
               px-5 py-4
               rounded-2xl"
    >

        <p class="font-semibold mb-2">
            Terjadi kesalahan
        </p>

        <ul class="list-disc ml-5 text-sm space-y-1">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


{{-- =====================================================
    SUMMARY
====================================================== --}}

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">

    {{-- Total Kelas --}}
    <div
        class="bg-white
               border border-slate-100
               rounded-2xl
               shadow-sm
               p-5"
    >

        <div class="flex items-center gap-4">

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-indigo-50
                       text-indigo-600
                       flex items-center justify-center
                       text-xl"
            >
                📚
            </div>

            <div>

                <p class="text-sm text-slate-500">
                    Total Kelas
                </p>

                <p class="text-2xl font-bold text-slate-900">
                    {{ $kelas->count() }}
                </p>

            </div>

        </div>

    </div>


    {{-- Status --}}
    <div
        class="bg-white
               border border-slate-100
               rounded-2xl
               shadow-sm
               p-5"
    >

        <div class="flex items-center gap-4">

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-violet-50
                       text-violet-600
                       flex items-center justify-center
                       text-xl"
            >
                🏫
            </div>

            <div>

                <p class="text-sm text-slate-500">
                    Status Data
                </p>

                @if($kelas->count() > 0)

                    <p class="text-sm font-semibold text-emerald-600 mt-1">
                        ✓ Data tersedia
                    </p>

                @else

                    <p class="text-sm font-semibold text-slate-500 mt-1">
                        Belum ada data
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
    IMPORT / EXPORT
====================================================== --}}

<div
    class="bg-white
           border border-slate-100
           rounded-2xl
           shadow-sm
           p-5
           mb-6"
>

    <div class="flex flex-col xl:flex-row
                xl:items-center
                xl:justify-between
                gap-5">

        {{-- Info --}}
        <div>

            <div class="flex items-center gap-3">

                <div
                    class="w-10 h-10
                           rounded-xl
                           bg-blue-50
                           text-blue-600
                           flex items-center justify-center"
                >
                    📊
                </div>

                <div>

                    <h3 class="font-bold text-slate-800">
                        Import & Export Data
                    </h3>

                    <p class="text-sm text-slate-500 mt-0.5">
                        Kelola data kelas menggunakan file Excel.
                    </p>

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3">

            {{-- Import --}}
            <form
                action="{{ route('kelas.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex flex-col sm:flex-row gap-2"
            >

                @csrf

                <input
                    type="file"
                    name="file"
                    accept=".xlsx,.xls"
                    required
                    class="w-full sm:w-auto
                           border border-slate-200
                           rounded-xl
                           px-3 py-2.5
                           text-sm
                           bg-slate-50
                           focus:outline-none
                           focus:ring-2
                           focus:ring-indigo-500
                           focus:border-indigo-500"
                >

                <button
                    type="submit"
                    class="inline-flex items-center justify-center
                           gap-2
                           bg-blue-600
                           hover:bg-blue-700
                           text-white
                           font-semibold
                           px-4 py-2.5
                           rounded-xl
                           transition
                           whitespace-nowrap"
                >

                    📥

                    Import Excel

                </button>

            </form>


            {{-- Export --}}
            <a
                href="{{ route('kelas.export') }}"
                class="inline-flex items-center justify-center
                       gap-2
                       bg-emerald-600
                       hover:bg-emerald-700
                       text-white
                       font-semibold
                       px-4 py-2.5
                       rounded-xl
                       transition
                       whitespace-nowrap"
            >

                📤

                Export Excel

            </a>

        </div>

    </div>

</div>


{{-- =====================================================
    TABLE
====================================================== --}}

<div
    class="bg-white
           border border-slate-100
           rounded-2xl
           shadow-sm
           overflow-hidden"
>

    {{-- Table Header --}}
    <div
        class="px-6 py-5
               border-b border-slate-100
               flex flex-col sm:flex-row
               sm:items-center
               sm:justify-between
               gap-2"
    >

        <div>

            <h2 class="text-lg font-bold text-slate-900">
                Daftar Kelas
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                {{ $kelas->count() }} kelas terdaftar.
            </p>

        </div>

    </div>


    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full min-w-[700px]">

            <thead class="bg-slate-50">

                <tr>

                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-bold
                               uppercase
                               tracking-wider
                               text-slate-500
                               w-20"
                    >
                        No
                    </th>

                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-bold
                               uppercase
                               tracking-wider
                               text-slate-500"
                    >
                        Nama Kelas
                    </th>

                    <th
                        class="px-6 py-4
                               text-left
                               text-xs
                               font-bold
                               uppercase
                               tracking-wider
                               text-slate-500"
                    >
                        Jurusan
                    </th>

                    <th
                        class="px-6 py-4
                               text-center
                               text-xs
                               font-bold
                               uppercase
                               tracking-wider
                               text-slate-500
                               w-48"
                    >
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($kelas as $item)

                    <tr class="hover:bg-slate-50 transition">


                        {{-- No --}}
                        <td class="px-6 py-4">

                            <span
                                class="inline-flex
                                       items-center
                                       justify-center
                                       w-8 h-8
                                       rounded-lg
                                       bg-slate-100
                                       text-sm
                                       font-semibold
                                       text-slate-600"
                            >
                                {{ $loop->iteration }}
                            </span>

                        </td>


                        {{-- Nama Kelas --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-indigo-50
                                           text-indigo-600
                                           flex items-center justify-center
                                           font-bold"
                                >
                                    📚
                                </div>

                                <div>

                                    <p class="font-semibold text-slate-800">
                                        {{ $item->nama_kelas }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Kelas sekolah
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Jurusan --}}
                        <td class="px-6 py-4">

                            @if($item->jurusan)

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1.5
                                           rounded-lg
                                           bg-indigo-50
                                           text-indigo-700
                                           text-xs
                                           font-bold"
                                >

                                    🏫

                                    <span class="ml-1.5">
                                        {{ $item->jurusan->nama_jurusan }}
                                    </span>

                                </span>

                            @else

                                <span
                                    class="inline-flex
                                           items-center
                                           px-3 py-1.5
                                           rounded-lg
                                           bg-slate-100
                                           text-slate-500
                                           text-xs
                                           font-semibold"
                                >

                                    Tidak ada jurusan

                                </span>

                            @endif

                        </td>


                        {{-- Aksi --}}
                        <td class="px-6 py-4">

                            <div
                                class="flex
                                       items-center
                                       justify-center
                                       gap-2"
                            >

                                {{-- Edit --}}
                                <a
                                    href="{{ route('kelas.edit', $item->id) }}"
                                    class="inline-flex
                                           items-center
                                           gap-1.5
                                           px-3.5 py-2
                                           rounded-lg
                                           bg-amber-50
                                           text-amber-700
                                           hover:bg-amber-100
                                           text-sm
                                           font-semibold
                                           transition"
                                >

                                    ✏️

                                    Edit

                                </a>


                                {{-- Hapus --}}
                                <form
                                    action="{{ route('kelas.destroy', $item->id) }}"
                                    method="POST"
                                    class="inline"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Yakin ingin menghapus kelas {{ $item->nama_kelas }}?')"
                                        class="inline-flex
                                               items-center
                                               gap-1.5
                                               px-3.5 py-2
                                               rounded-lg
                                               bg-red-50
                                               text-red-600
                                               hover:bg-red-100
                                               text-sm
                                               font-semibold
                                               transition"
                                    >

                                        🗑️

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                @empty

                    {{-- Empty State --}}
                    <tr>

                        <td
                            colspan="4"
                            class="px-6 py-16"
                        >

                            <div class="flex flex-col items-center text-center">

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-slate-100
                                           flex items-center justify-center
                                           text-3xl
                                           mb-4"
                                >
                                    📚
                                </div>

                                <h3 class="font-bold text-slate-700">
                                    Belum ada data kelas
                                </h3>

                                <p class="text-sm text-slate-500 mt-1 mb-5">
                                    Tambahkan kelas pertama untuk mulai mengelola data.
                                </p>

                                <a
                                    href="{{ route('kelas.create') }}"
                                    class="inline-flex items-center gap-2
                                           bg-indigo-600
                                           hover:bg-indigo-700
                                           text-white
                                           font-semibold
                                           px-4 py-2.5
                                           rounded-xl
                                           transition"
                                >

                                    +

                                    Tambah Kelas

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