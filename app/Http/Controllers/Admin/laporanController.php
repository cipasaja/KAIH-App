<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AngketHarian;
use App\Models\Siswa;


class LaporanController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        // =====================================================
        // QUERY ANGKET
        // =====================================================

        $query = AngketHarian::with('siswa')
            ->orderBy('tanggal', 'desc');


        // =====================================================
        // FILTER TANGGAL MULAI
        // =====================================================

        if ($request->filled('tanggal_mulai')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );

        }


        // =====================================================
        // FILTER TANGGAL SELESAI
        // =====================================================

        if ($request->filled('tanggal_selesai')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_selesai
            );

        }


        // =====================================================
        // FILTER SISWA
        // =====================================================

        if ($request->filled('siswa_id')) {

            $query->where(
                'siswa_id',
                $request->siswa_id
            );

        }


        // =====================================================
        // AMBIL DATA
        // =====================================================

        $angket = $query->get();


        // =====================================================
        // DATA SISWA
        // =====================================================

        $siswa = Siswa::orderBy('nama_siswa')->get();


        // =====================================================
        // TOTAL ANGKET
        // =====================================================

        $totalAngket = $angket->count();


        // =====================================================
        // TOTAL BELAJAR
        // =====================================================

        $totalBelajar = $angket
            ->where('belajar', true)
            ->count();


        // =====================================================
        // TOTAL SHOLAT
        // =====================================================

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


        // =====================================================
        // TAMPILKAN VIEW
        // =====================================================

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


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF
    |--------------------------------------------------------------------------
    */

    public function pdf(Request $request)
    {

        // =====================================================
        // QUERY ANGKET
        // =====================================================

        $query = AngketHarian::with('siswa')
            ->orderBy('tanggal', 'desc');


        // =====================================================
        // FILTER TANGGAL MULAI
        // =====================================================

        if ($request->filled('tanggal_mulai')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );

        }


        // =====================================================
        // FILTER TANGGAL SELESAI
        // =====================================================

        if ($request->filled('tanggal_selesai')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_selesai
            );

        }


        // =====================================================
        // FILTER SISWA
        // =====================================================

        if ($request->filled('siswa_id')) {

            $query->where(
                'siswa_id',
                $request->siswa_id
            );

        }


        // =====================================================
        // AMBIL DATA
        // =====================================================

        $angket = $query->get();


        // =====================================================
        // STATISTIK
        // =====================================================

        $totalAngket = $angket->count();


        $totalBelajar = $angket
            ->where('belajar', true)
            ->count();


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


        // =====================================================
        // FILTER UNTUK PDF
        // =====================================================

        $tanggalMulai = $request->tanggal_mulai;

        $tanggalSelesai = $request->tanggal_selesai;

        $siswaId = $request->siswa_id;


        // =====================================================
        // BUAT PDF
        // =====================================================

        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            compact(
                'angket',
                'totalAngket',
                'totalBelajar',
                'totalSholat',
                'tanggalMulai',
                'tanggalSelesai',
                'siswaId'
            )
        );


        // =====================================================
        // SET KERTAS A4 LANDSCAPE
        // =====================================================

        $pdf->setPaper(
            'a4',
            'landscape'
        );


        // =====================================================
        // DOWNLOAD FILE
        // =====================================================

        return $pdf->download(
            'laporan-angket-harian.pdf'
        );

    }

}