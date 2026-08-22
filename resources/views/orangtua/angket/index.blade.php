@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

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

        <a
            href="{{ route('orangtua.angket.create') }}"
            class="inline-flex items-center justify-center gap-2
                   bg-indigo-600 hover:bg-indigo-700
                   text-white font-semibold
                   px-5 py-3 rounded-xl
                   shadow-sm transition"
        >
            <span class="text-lg">+</span>
            Isi Angket Hari Ini
        </a>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="mb-6 bg-green-50 border border-green-200
                    text-green-700 px-5 py-4 rounded-xl">

            <div class="flex items-center gap-3">
                <span class="text-lg">✓</span>

                <span class="font-medium">
                    {{ session('success') }}
                </span>
            </div>

        </div>

    @endif


    {{-- ERROR --}}
    @if(session('error'))

        <div class="mb-6 bg-red-50 border border-red-200
                    text-red-700 px-5 py-4 rounded-xl">

            <div class="flex items-center gap-3">
                <span class="text-lg">!</span>

                <span class="font-medium">
                    {{ session('error') }}
                </span>
            </div>

        </div>

    @endif


    {{-- CARD INFO --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700
            rounded-2xl p-6 text-white shadow-sm mb-6">

    <div class="flex flex-col sm:flex-row sm:items-center
                sm:justify-between gap-4">

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

    {{-- RIWAYAT --}}
    <div class="bg-white rounded-2xl shadow-sm
                border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">

            <h3 class="text-lg font-bold text-gray-800">
                Riwayat Angket Harian
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Daftar pengisian angket harian anak.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            Bangun
                        </th>

                        <th class="px-6 py-4 text-center text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            Sholat
                        </th>

                        <th class="px-6 py-4 text-center text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            Belajar
                        </th>

                        <th class="px-6 py-4 text-left text-xs
                                   font-semibold text-gray-500
                                   uppercase tracking-wider">
                            Tidur
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($angket as $item)

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <span class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </span>

                            </td>


                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $item->bangun_pagi ?? '-' }}
                            </td>


                            {{-- Sholat --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-1">

                                    @if($item->sholat_subuh)
                                        <span class="px-2 py-1 rounded-lg
                                                     bg-green-50 text-green-700
                                                     text-xs font-semibold">
                                            Subuh
                                        </span>
                                    @endif

                                    @if($item->sholat_ashar)
                                        <span class="px-2 py-1 rounded-lg
                                                     bg-green-50 text-green-700
                                                     text-xs font-semibold">
                                            Ashar
                                        </span>
                                    @endif

                                    @if($item->sholat_magrib)
                                        <span class="px-2 py-1 rounded-lg
                                                     bg-green-50 text-green-700
                                                     text-xs font-semibold">
                                            Magrib
                                        </span>
                                    @endif

                                    @if($item->sholat_isya)
                                        <span class="px-2 py-1 rounded-lg
                                                     bg-green-50 text-green-700
                                                     text-xs font-semibold">
                                            Isya
                                        </span>
                                    @endif

                                    @if(
                                        !$item->sholat_subuh &&
                                        !$item->sholat_ashar &&
                                        !$item->sholat_magrib &&
                                        !$item->sholat_isya
                                    )
                                        <span class="text-gray-400 text-xs">
                                            Belum
                                        </span>
                                    @endif

                                </div>

                            </td>


                            {{-- Belajar --}}
                            <td class="px-6 py-4 text-center">

                                @if($item->belajar)

                                    <span class="inline-flex items-center
                                                 px-3 py-1 rounded-full
                                                 bg-green-50 text-green-700
                                                 text-xs font-semibold">
                                        ✓ Ya
                                    </span>

                                @else

                                    <span class="inline-flex items-center
                                                 px-3 py-1 rounded-full
                                                 bg-red-50 text-red-600
                                                 text-xs font-semibold">
                                        ✕ Tidak
                                    </span>

                                @endif

                            </td>


                            {{-- Tidur --}}
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $item->tidur_malam ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-16 h-16 rounded-2xl
                                                bg-indigo-50
                                                flex items-center
                                                justify-center
                                                text-3xl mb-4">
                                        📝
                                    </div>

                                    <h4 class="font-semibold text-gray-700">
                                        Belum ada angket
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1 mb-5">
                                        Belum ada pengisian angket harian.
                                    </p>

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