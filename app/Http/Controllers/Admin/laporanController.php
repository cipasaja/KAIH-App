<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan laporan angket harian.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

        $query = AngketHarian::with([
            'siswa',
            'orangTua'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_mulai')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_mulai
            );

        }

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
        | DATA LAPORAN
        |--------------------------------------------------------------------------
        */

        $angket = $query
            ->orderByDesc('tanggal')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $siswa = \App\Models\Siswa::orderBy(
            'nama_siswa'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalAngket = $angket->count();

        $totalBelajar = $angket
            ->where('belajar', 1)
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


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
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
}