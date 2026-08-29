<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use App\Models\Siswa;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * =========================================================
     * HALAMAN LAPORAN
     * =========================================================
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY ANGKET
        |--------------------------------------------------------------------------
        */

        $query = AngketHarian::with('siswa');


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL SELESAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_selesai')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_selesai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('siswa_id')) {

            $query->where(
                'siswa_id',
                $request->siswa_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA
        |--------------------------------------------------------------------------
        |
        | Tanggal paling lama ditampilkan terlebih dahulu.
        |
        | Contoh:
        |
        | 22/08/2026 -> No. 1
        | 26/08/2026 -> No. 2
        | 27/08/2026 -> No. 3
        | 29/08/2026 -> No. 4
        |
        */

        $query->orderBy(
            'tanggal',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA TANGGAL SAMA
        |--------------------------------------------------------------------------
        |
        | Jika terdapat beberapa angket dengan tanggal yang sama,
        | data yang dibuat lebih dahulu ditampilkan lebih dahulu.
        |
        */

        $query->orderBy(
            'created_at',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $angket = $query->get();


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $siswa = Siswa::orderBy(
            'nama_siswa',
            'asc'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ANGKET
        |--------------------------------------------------------------------------
        */

        $totalAngket = $angket->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA YANG BELAJAR
        |--------------------------------------------------------------------------
        */

        $totalBelajar = $angket
            ->where('belajar', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SHOLAT
        |--------------------------------------------------------------------------
        |
        | Menghitung jumlah seluruh sholat yang dilaksanakan.
        |
        */

        $totalSholat = 0;

        foreach ($angket as $item) {

            if ($item->sholat_subuh) {
                $totalSholat++;
            }

            if ($item->sholat_dzuhur) {
                $totalSholat++;
            }

            if ($item->sholat_ashar) {
                $totalSholat++;
            }

            if ($item->sholat_magrib) {
                $totalSholat++;
            }

            if ($item->sholat_isya) {
                $totalSholat++;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.index',
            compact(
                'angket',
                'siswa',
                'totalAngket',
                'totalBelajar',
                'totalSholat'
            )
        );
    }


    /**
     * =========================================================
     * PDF LAPORAN
     * =========================================================
     */
    public function pdf(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY ANGKET
        |--------------------------------------------------------------------------
        */

        $query = AngketHarian::with('siswa');


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL SELESAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_selesai')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_selesai
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('siswa_id')) {

            $query->where(
                'siswa_id',
                $request->siswa_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | URUTAN DATA PDF
        |--------------------------------------------------------------------------
        |
        | PDF juga menggunakan urutan:
        |
        | tanggal lama -> tanggal baru
        |
        */

        $query->orderBy(
            'tanggal',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA TANGGAL SAMA
        |--------------------------------------------------------------------------
        */

        $query->orderBy(
            'created_at',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $angket = $query->get();


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */

        $siswa = Siswa::orderBy(
            'nama_siswa',
            'asc'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | DATA FILTER UNTUK PDF
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;

        $tanggalSelesai = $request->tanggal_selesai;

        $siswaId = $request->siswa_id;


        /*
        |--------------------------------------------------------------------------
        | NAMA SISWA YANG DIPILIH
        |--------------------------------------------------------------------------
        */

        $namaSiswa = 'Semua siswa';

        if ($siswaId) {

            $siswaDipilih = Siswa::find(
                $siswaId
            );

            if ($siswaDipilih) {

                $namaSiswa = $siswaDipilih->nama_siswa;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN VIEW PDF
        |--------------------------------------------------------------------------
        |
        | File:
        | resources/views/admin/laporan/pdf.blade.php
        |
        */

        return view(
            'admin.laporan.pdf',
            compact(
                'angket',
                'siswa',
                'tanggalMulai',
                'tanggalSelesai',
                'siswaId',
                'namaSiswa'
            )
        );
    }
}