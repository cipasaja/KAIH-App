@extends('admin.layouts.app')

@section('title', 'Isi Angket Harian')

@section('page-title', 'Isi Angket Harian')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- HEADER --}}
    <div class="mb-8">

        <p class="text-sm font-medium text-indigo-600 mb-1">
            KAIH App
        </p>

        <h1 class="text-3xl font-bold text-gray-900">
            Angket Harian
        </h1>

        <p class="text-gray-500 mt-2">
            Isi kebiasaan harian anak.
        </p>

    </div>


    {{-- ERROR --}}
    @if($errors->any())

        <div class="mb-6 bg-red-50 border border-red-200
                    text-red-700 px-5 py-4 rounded-xl">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow-sm
                border border-gray-100 p-6">


        {{-- DATA ANAK --}}
        <div class="mb-8">

            <h2 class="text-xl font-bold text-gray-800">
                Data Anak
            </h2>

            <p class="text-gray-500 mt-1">

                {{ $orangTua->siswa->nama_siswa }}

                — NIS {{ $orangTua->siswa->nis }}

            </p>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('orangtua.angket.store') }}"
            method="POST"
        >

            @csrf


            {{-- =========================================
                 TANGGAL
            ========================================== --}}
            <div class="mb-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >

            </div>


            {{-- =========================================
                 JAM BANGUN PAGI
            ========================================== --}}
            <div class="mb-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Jam Bangun Pagi
                </label>

                <input
                    type="text"
                    name="bangun_pagi"
                    value="{{ old('bangun_pagi') }}"
                    placeholder="Contoh: 05:30"
                    maxlength="5"
                    inputmode="numeric"
                    pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

                <p class="text-xs text-gray-400 mt-2">
                    Gunakan format 24 jam, contoh:
                    <span class="font-semibold">05:30</span>
                </p>

            </div>


            {{-- =========================================
                 SHOLAT 5 WAKTU
            ========================================== --}}
            <div class="mb-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-3"
                >
                    Sholat 5 Waktu
                </label>

                <p class="text-sm text-gray-500 mb-4">
                    Centang sholat yang dilakukan anak hari ini.
                </p>


                <div class="grid sm:grid-cols-2 gap-3">


                    {{-- SUBUH --}}
                    <label
                        class="flex items-center gap-3 p-4
                               border border-gray-200
                               rounded-xl
                               cursor-pointer
                               hover:bg-indigo-50
                               transition"
                    >

                        <input
                            type="checkbox"
                            name="sholat_subuh"
                            value="1"
                            {{ old('sholat_subuh') ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600
                                   border-gray-300 rounded
                                   focus:ring-indigo-500"
                        >

                        <div>
                            <span class="font-semibold text-gray-800">
                                Subuh
                            </span>

                            <p class="text-xs text-gray-400">
                                Sholat Subuh
                            </p>
                        </div>

                    </label>


                    {{-- DZUHUR --}}
                    <label
                        class="flex items-center gap-3 p-4
                               border border-gray-200
                               rounded-xl
                               cursor-pointer
                               hover:bg-indigo-50
                               transition"
                    >

                        <input
                            type="checkbox"
                            name="sholat_dzuhur"
                            value="1"
                            {{ old('sholat_dzuhur') ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600
                                   border-gray-300 rounded
                                   focus:ring-indigo-500"
                        >

                        <div>
                            <span class="font-semibold text-gray-800">
                                Dzuhur
                            </span>

                            <p class="text-xs text-gray-400">
                                Sholat Dzuhur
                            </p>
                        </div>

                    </label>


                    {{-- ASHAR --}}
                    <label
                        class="flex items-center gap-3 p-4
                               border border-gray-200
                               rounded-xl
                               cursor-pointer
                               hover:bg-indigo-50
                               transition"
                    >

                        <input
                            type="checkbox"
                            name="sholat_ashar"
                            value="1"
                            {{ old('sholat_ashar') ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600
                                   border-gray-300 rounded
                                   focus:ring-indigo-500"
                        >

                        <div>
                            <span class="font-semibold text-gray-800">
                                Ashar
                            </span>

                            <p class="text-xs text-gray-400">
                                Sholat Ashar
                            </p>
                        </div>

                    </label>


                    {{-- MAGRIB --}}
                    <label
                        class="flex items-center gap-3 p-4
                               border border-gray-200
                               rounded-xl
                               cursor-pointer
                               hover:bg-indigo-50
                               transition"
                    >

                        <input
                            type="checkbox"
                            name="sholat_magrib"
                            value="1"
                            {{ old('sholat_magrib') ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600
                                   border-gray-300 rounded
                                   focus:ring-indigo-500"
                        >

                        <div>
                            <span class="font-semibold text-gray-800">
                                Magrib
                            </span>

                            <p class="text-xs text-gray-400">
                                Sholat Magrib
                            </p>
                        </div>

                    </label>


                    {{-- ISYA --}}
                    <label
                        class="flex items-center gap-3 p-4
                               border border-gray-200
                               rounded-xl
                               cursor-pointer
                               hover:bg-indigo-50
                               transition"
                    >

                        <input
                            type="checkbox"
                            name="sholat_isya"
                            value="1"
                            {{ old('sholat_isya') ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600
                                   border-gray-300 rounded
                                   focus:ring-indigo-500"
                        >

                        <div>
                            <span class="font-semibold text-gray-800">
                                Isya
                            </span>

                            <p class="text-xs text-gray-400">
                                Sholat Isya
                            </p>
                        </div>

                    </label>

                </div>

            </div>


            {{-- =========================================
                 KEGIATAN MEMBANTU ORANG TUA
            ========================================== --}}
            <div class="mb-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Kegiatan Membantu Orang Tua
                </label>

                <textarea
                    name="kegiatan_membantu"
                    rows="4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Contoh: membantu membersihkan rumah..."
                >{{ old('kegiatan_membantu') }}</textarea>

            </div>


            {{-- =========================================
                 BELAJAR
            ========================================== --}}
            <div class="mb-6">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-3"
                >
                    Apakah anak belajar hari ini?
                </label>


                <div class="flex gap-6">


                    {{-- YA --}}
                    <label class="flex items-center gap-2 cursor-pointer">

                        <input
                            type="radio"
                            name="belajar"
                            value="1"
                            {{ old('belajar') === '1' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600
                                   focus:ring-indigo-500"
                        >

                        <span>
                            Ya
                        </span>

                    </label>


                    {{-- TIDAK --}}
                    <label class="flex items-center gap-2 cursor-pointer">

                        <input
                            type="radio"
                            name="belajar"
                            value="0"
                            {{ old('belajar') === '0' ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600
                                   focus:ring-indigo-500"
                        >

                        <span>
                            Tidak
                        </span>

                    </label>

                </div>

            </div>


            {{-- =========================================
                 JAM TIDUR MALAM
            ========================================== --}}
            <div class="mb-8">

                <label
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Jam Tidur Malam
                </label>

                <input
                    type="text"
                    name="tidur_malam"
                    value="{{ old('tidur_malam') }}"
                    placeholder="Contoh: 21:30"
                    maxlength="5"
                    inputmode="numeric"
                    pattern="^([01][0-9]|2[0-3]):[0-5][0-9]$"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3
                           focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

                <p class="text-xs text-gray-400 mt-2">
                    Gunakan format 24 jam, contoh:
                    <span class="font-semibold">21:30</span>
                </p>

            </div>


            {{-- =========================================
                 BUTTON
            ========================================== --}}
            <div class="flex gap-3">


                {{-- KEMBALI --}}
                <a
                    href="{{ route('orangtua.angket.index') }}"
                    class="px-5 py-3 rounded-xl
                           bg-gray-100 hover:bg-gray-200
                           text-gray-700 font-semibold
                           transition"
                >
                    Kembali
                </a>


                {{-- SIMPAN --}}
                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl
                           bg-indigo-600 hover:bg-indigo-700
                           text-white font-semibold
                           transition"
                >
                    Simpan Angket
                </button>

            </div>

        </form>

    </div>

</div>

@endsection