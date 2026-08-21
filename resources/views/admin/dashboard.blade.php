@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- =====================================================
    WELCOME
====================================================== --}}

<div class="mb-8">

    <div
        class="relative overflow-hidden
               bg-gradient-to-r from-indigo-600 to-violet-600
               rounded-3xl
               p-7 lg:p-8
               text-white
               shadow-xl shadow-indigo-100"
    >

        {{-- Decorative --}}
        <div
            class="absolute -right-10 -top-10
                   w-44 h-44
                   rounded-full
                   bg-white/10"
        ></div>

        <div
            class="absolute right-20 -bottom-20
                   w-52 h-52
                   rounded-full
                   bg-white/5"
        ></div>


        <div class="relative">

            <p class="text-indigo-100 text-sm font-medium mb-2">
                Sistem Informasi Akademik
            </p>

            <h1 class="text-2xl lg:text-3xl font-bold">
                Selamat datang, {{ Auth::user()->name ?? 'Admin' }} 👋
            </h1>

            <p class="text-indigo-100 mt-2 max-w-2xl">
                Kelola data akademik sekolah dengan mudah melalui
                dashboard KAIH.
            </p>

        </div>

    </div>

</div>


{{-- =====================================================
    STATISTIK
====================================================== --}}

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">


    {{-- Jurusan --}}
    <div
        class="bg-white
               rounded-2xl
               border border-slate-100
               p-6
               shadow-sm
               hover:shadow-md
               transition"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-slate-500">
                    Total Jurusan
                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $totalJurusan }}
                </p>

                <p class="text-xs text-slate-400 mt-2">
                    Jurusan terdaftar
                </p>

            </div>

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-indigo-50
                       text-indigo-600
                       flex items-center justify-center
                       text-xl"
            >
                🏫
            </div>

        </div>

    </div>


    {{-- Kelas --}}
    <div
        class="bg-white
               rounded-2xl
               border border-slate-100
               p-6
               shadow-sm
               hover:shadow-md
               transition"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-slate-500">
                    Total Kelas
                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $totalKelas }}
                </p>

                <p class="text-xs text-slate-400 mt-2">
                    Kelas terdaftar
                </p>

            </div>

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-emerald-50
                       text-emerald-600
                       flex items-center justify-center
                       text-xl"
            >
                📚
            </div>

        </div>

    </div>


    {{-- Siswa --}}
    <div
        class="bg-white
               rounded-2xl
               border border-slate-100
               p-6
               shadow-sm
               hover:shadow-md
               transition"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-slate-500">
                    Total Siswa
                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $totalSiswa }}
                </p>

                <p class="text-xs text-slate-400 mt-2">
                    Siswa terdaftar
                </p>

            </div>

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-blue-50
                       text-blue-600
                       flex items-center justify-center
                       text-xl"
            >
                👨‍🎓
            </div>

        </div>

    </div>


    {{-- Orang Tua --}}
    <div
        class="bg-white
               rounded-2xl
               border border-slate-100
               p-6
               shadow-sm
               hover:shadow-md
               transition"
    >

        <div class="flex items-start justify-between">

            <div>

                <p class="text-sm font-medium text-slate-500">
                    Total Orang Tua
                </p>

                <p class="text-3xl font-bold text-slate-900 mt-2">
                    {{ $totalOrangTua }}
                </p>

                <p class="text-xs text-slate-400 mt-2">
                    Orang tua terdaftar
                </p>

            </div>

            <div
                class="w-12 h-12
                       rounded-2xl
                       bg-rose-50
                       text-rose-600
                       flex items-center justify-center
                       text-xl"
            >
                👨‍👩‍👧
            </div>

        </div>

    </div>

</div>


{{-- =====================================================
    QUICK ACTION
====================================================== --}}

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


    {{-- Kelola Data --}}
    <div
        class="lg:col-span-2
               bg-white
               rounded-2xl
               border border-slate-100
               shadow-sm
               p-6"
    >

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Kelola Data
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Akses cepat untuk mengelola data sekolah.
                </p>

            </div>

            <div
                class="w-10 h-10
                       rounded-xl
                       bg-indigo-50
                       text-indigo-600
                       flex items-center justify-center"
            >
                ⚡
            </div>

        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">


            {{-- Jurusan --}}
            <a
                href="{{ route('jurusan.index') }}"
                class="group
                       flex items-center gap-4
                       p-4
                       rounded-2xl
                       border border-slate-100
                       hover:border-indigo-200
                       hover:bg-indigo-50/50
                       transition"
            >

                <div
                    class="w-11 h-11
                           rounded-xl
                           bg-indigo-50
                           text-indigo-600
                           flex items-center justify-center
                           group-hover:bg-indigo-100"
                >
                    🏫
                </div>

                <div class="flex-1">

                    <p class="font-semibold text-slate-800">
                        Data Jurusan
                    </p>

                    <p class="text-xs text-slate-400">
                        Kelola jurusan sekolah
                    </p>

                </div>

                <span class="text-slate-300 group-hover:text-indigo-600">
                    →
                </span>

            </a>


            {{-- Kelas --}}
            <a
                href="{{ route('kelas.index') }}"
                class="group
                       flex items-center gap-4
                       p-4
                       rounded-2xl
                       border border-slate-100
                       hover:border-emerald-200
                       hover:bg-emerald-50/50
                       transition"
            >

                <div
                    class="w-11 h-11
                           rounded-xl
                           bg-emerald-50
                           text-emerald-600
                           flex items-center justify-center"
                >
                    📚
                </div>

                <div class="flex-1">

                    <p class="font-semibold text-slate-800">
                        Data Kelas
                    </p>

                    <p class="text-xs text-slate-400">
                        Kelola data kelas
                    </p>

                </div>

                <span class="text-slate-300 group-hover:text-emerald-600">
                    →
                </span>

            </a>


            {{-- Siswa --}}
            <a
                href="{{ route('siswa.index') }}"
                class="group
                       flex items-center gap-4
                       p-4
                       rounded-2xl
                       border border-slate-100
                       hover:border-blue-200
                       hover:bg-blue-50/50
                       transition"
            >

                <div
                    class="w-11 h-11
                           rounded-xl
                           bg-blue-50
                           text-blue-600
                           flex items-center justify-center"
                >
                    👨‍🎓
                </div>

                <div class="flex-1">

                    <p class="font-semibold text-slate-800">
                        Data Siswa
                    </p>

                    <p class="text-xs text-slate-400">
                        Kelola data siswa
                    </p>

                </div>

                <span class="text-slate-300 group-hover:text-blue-600">
                    →
                </span>

            </a>


            {{-- Orang Tua --}}
            <a
                href="{{ route('orangtua.index') }}"
                class="group
                       flex items-center gap-4
                       p-4
                       rounded-2xl
                       border border-slate-100
                       hover:border-rose-200
                       hover:bg-rose-50/50
                       transition"
            >

                <div
                    class="w-11 h-11
                           rounded-xl
                           bg-rose-50
                           text-rose-600
                           flex items-center justify-center"
                >
                    👨‍👩‍👧
                </div>

                <div class="flex-1">

                    <p class="font-semibold text-slate-800">
                        Data Orang Tua
                    </p>

                    <p class="text-xs text-slate-400">
                        Kelola data orang tua
                    </p>

                </div>

                <span class="text-slate-300 group-hover:text-rose-600">
                    →
                </span>

            </a>

        </div>

    </div>


    {{-- Informasi --}}
    <div
        class="bg-white
               rounded-2xl
               border border-slate-100
               shadow-sm
               p-6"
    >

        <div class="flex items-center gap-3 mb-5">

            <div
                class="w-10 h-10
                       rounded-xl
                       bg-violet-50
                       text-violet-600
                       flex items-center justify-center"
            >
                💡
            </div>

            <div>

                <h2 class="font-bold text-slate-900">
                    Informasi
                </h2>

                <p class="text-xs text-slate-400">
                    KAIH App
                </p>

            </div>

        </div>


        <div class="space-y-4">

            <div
                class="p-4
                       rounded-2xl
                       bg-slate-50
                       border border-slate-100"
            >

                <p class="text-sm font-semibold text-slate-700">
                    📊 Data Akademik
                </p>

                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Gunakan menu di sebelah kiri untuk mengelola
                    seluruh data akademik sekolah.
                </p>

            </div>


            <div
                class="p-4
                       rounded-2xl
                       bg-indigo-50
                       border border-indigo-100"
            >

                <p class="text-sm font-semibold text-indigo-700">
                    📝 Angket Harian
                </p>

                <p class="text-xs text-indigo-600 mt-1 leading-relaxed">
                    Fitur angket orang tua akan digunakan untuk
                    memantau aktivitas harian siswa.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection