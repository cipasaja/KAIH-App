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
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- FORM --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        {{-- DATA ANAK --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Data Anak
            </h2>

            <p class="text-gray-500 mt-1">
                {{ $orangTua->siswa->nama_siswa }}
                — NIS {{ $orangTua->siswa->nis }}
            </p>
        </div>


        <form
            action="{{ route('orangtua.angket.store') }}"
            method="POST"
        >

            @csrf


            {{-- TANGGAL --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ old('tanggal', date('Y-m-d')) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >

            </div>


            {{-- JAM BANGUN PAGI --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Bangun Pagi
                </label>

                <p class="text-xs text-gray-400 mb-2">
                    Gunakan format 24 jam. Contoh: 04:30
                </p>

                <input
                    type="time"
                    name="bangun_pagi"
                    value="{{ old('bangun_pagi') }}"
                    min="00:00"
                    max="23:59"
                    step="60"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

            </div>


            {{-- SHOLAT --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Sholat
                </label>

                <div class="grid sm:grid-cols-2 gap-3">

                    {{-- SUBUH --}}
                    <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-indigo-50">

                        <input
                            type="checkbox"
                            name="sholat_subuh"
                            value="1"
                            {{ old('sholat_subuh') ? 'checked' : '' }}
                        >

                        <span>
                            Sholat Subuh
                        </span>

                    </label>


                    {{-- ASHAR --}}
                    <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-indigo-50">

                        <input
                            type="checkbox"
                            name="sholat_ashar"
                            value="1"
                            {{ old('sholat_ashar') ? 'checked' : '' }}
                        >

                        <span>
                            Sholat Ashar
                        </span>

                    </label>


                    {{-- MAGRIB --}}
                    <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-indigo-50">

                        <input
                            type="checkbox"
                            name="sholat_magrib"
                            value="1"
                            {{ old('sholat_magrib') ? 'checked' : '' }}
                        >

                        <span>
                            Sholat Magrib
                        </span>

                    </label>


                    {{-- ISYA --}}
                    <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-indigo-50">

                        <input
                            type="checkbox"
                            name="sholat_isya"
                            value="1"
                            {{ old('sholat_isya') ? 'checked' : '' }}
                        >

                        <span>
                            Sholat Isya
                        </span>

                    </label>

                </div>

            </div>


            {{-- KEGIATAN MEMBANTU --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kegiatan Membantu Orang Tua
                </label>

                <textarea
                    name="kegiatan_membantu"
                    rows="4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Contoh: membantu membersihkan rumah..."
                >{{ old('kegiatan_membantu') }}</textarea>

            </div>


            {{-- BELAJAR --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Apakah anak belajar hari ini?
                </label>

                <div class="flex gap-4">

                    {{-- YA --}}
                    <label class="flex items-center gap-2">

                        <input
                            type="radio"
                            name="belajar"
                            value="1"
                            {{ old('belajar') === '1' ? 'checked' : '' }}
                        >

                        <span>
                            Ya
                        </span>

                    </label>


                    {{-- TIDAK --}}
                    <label class="flex items-center gap-2">

                        <input
                            type="radio"
                            name="belajar"
                            value="0"
                            {{ old('belajar') === '0' ? 'checked' : '' }}
                        >

                        <span>
                            Tidak
                        </span>

                    </label>

                </div>

            </div>


            {{-- JAM TIDUR MALAM --}}
            <div class="mb-6">

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Jam Tidur Malam
                </label>

                <p class="text-xs text-gray-400 mb-2">
                    Gunakan format 24 jam. Contoh: 21:00
                </p>

                <input
                    type="time"
                    name="tidur_malam"
                    value="{{ old('tidur_malam') }}"
                    min="00:00"
                    max="23:59"
                    step="60"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >

            </div>


            {{-- BUTTON --}}
            <div class="flex gap-3">

                <a
                    href="{{ route('orangtua.angket.index') }}"
                    class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold"
                >
                    Kembali
                </a>


                <button
                    type="submit"
                    class="px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold"
                >
                    Simpan Angket
                </button>

            </div>

        </form>

    </div>

</div>

@endsection