<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        | DATA FILTER
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalAkhir = $request->tanggal_selesai;
        $kelasId = $request->kelas_id;
        $kategori = $request->kategori;


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
        | FILTER KELAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kelas_id')) {

            $query->whereHas('siswa', function ($q) use ($kelasId) {

                $q->where(
                    'kelas_id',
                    $kelasId
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA
        |--------------------------------------------------------------------------
        */

        $query->orderBy(
            'tanggal',
            'asc'
        );

        $query->orderBy(
            'created_at',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA ANGKET
        |--------------------------------------------------------------------------
        */

        $angket = $query->get();


        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */

        $siswaQuery = Siswa::with([
            'kelas',
            'angketHarians'
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA BERDASARKAN KELAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kelas_id')) {

            $siswaQuery->where(
                'kelas_id',
                $kelasId
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER SISWA BERDASARKAN SISWA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('siswa_id')) {

            $siswaQuery->where(
                'id',
                $request->siswa_id
            );

        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN SISWA
        |--------------------------------------------------------------------------
        */

        $siswas = $siswaQuery
            ->orderBy(
                'nama_siswa',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | AGAR SESUAI DENGAN BLADE
        |--------------------------------------------------------------------------
        */

        foreach ($siswas as $item) {

            $item->setRelation(
                'angketHarian',
                $item->angketHarians
            );

        }


        /*
        |--------------------------------------------------------------------------
        | ALIAS UNTUK BLADE
        |--------------------------------------------------------------------------
        */

        $siswa = $siswas;


        /*
        |--------------------------------------------------------------------------
        | DATA KELAS
        |--------------------------------------------------------------------------
        */

        $kelas = Kelas::with('jurusan')
            ->withCount('siswa')
            ->orderBy(
                'nama_kelas',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA
        |--------------------------------------------------------------------------
        */

        $totalSiswa = $siswas->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ANGKET
        |--------------------------------------------------------------------------
        */

        $totalAngket = $angket->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL BELAJAR
        |--------------------------------------------------------------------------
        */

        $totalBelajar = $angket
            ->where('belajar', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL SHOLAT
        |--------------------------------------------------------------------------
        */

        $totalSholat =
            $angket->where('sholat_subuh', true)->count()
            + $angket->where('sholat_dzuhur', true)->count()
            + $angket->where('sholat_ashar', true)->count()
            + $angket->where('sholat_magrib', true)->count()
            + $angket->where('sholat_isya', true)->count();


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA SKOR
        |--------------------------------------------------------------------------
        */

        $rataRataSkor = round(
            $angket->avg('skor') ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE PENGISIAN
        |--------------------------------------------------------------------------
        */

        $siswaSudahMengisi = $siswas->filter(function ($item) {

            return $item->angketHarian
                && $item->angketHarian->count() > 0;

        })->count();


        if ($totalSiswa > 0) {

            $persentasePengisian = round(
                ($siswaSudahMengisi / $totalSiswa) * 100,
                2
            );

        } else {

            $persentasePengisian = 0;

        }


        /*
        |--------------------------------------------------------------------------
        | JUMLAH KONDISI SISWA
        |--------------------------------------------------------------------------
        */

        $jumlahBaik = 0;
        $jumlahPerhatian = 0;
        $jumlahPendampingan = 0;


        foreach ($siswas as $item) {

            $dataSiswa = $item->angketHarian;


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            if ($tanggalMulai && $tanggalAkhir) {

                $dataSiswa = $dataSiswa->filter(function ($angketItem) use (
                    $tanggalMulai,
                    $tanggalAkhir
                ) {

                    $tanggal = $angketItem->tanggal
                        ? $angketItem->tanggal->format('Y-m-d')
                        : null;

                    return $tanggal
                        && $tanggal >= $tanggalMulai
                        && $tanggal <= $tanggalAkhir;

                });

            } elseif ($tanggalMulai) {

                $dataSiswa = $dataSiswa->filter(function ($angketItem) use (
                    $tanggalMulai
                ) {

                    $tanggal = $angketItem->tanggal
                        ? $angketItem->tanggal->format('Y-m-d')
                        : null;

                    return $tanggal
                        && $tanggal >= $tanggalMulai;

                });

            } elseif ($tanggalAkhir) {

                $dataSiswa = $dataSiswa->filter(function ($angketItem) use (
                    $tanggalAkhir
                ) {

                    $tanggal = $angketItem->tanggal
                        ? $angketItem->tanggal->format('Y-m-d')
                        : null;

                    return $tanggal
                        && $tanggal <= $tanggalAkhir;

                });

            }


            /*
            |--------------------------------------------------------------------------
            | FILTER KATEGORI
            |--------------------------------------------------------------------------
            */

            if ($kategori) {

                $dataSiswa = $dataSiswa->filter(function ($angketItem) use (
                    $kategori
                ) {

                    return $angketItem->kategori == $kategori;

                });

            }


            /*
            |--------------------------------------------------------------------------
            | AMBIL ANGKET TERAKHIR
            |--------------------------------------------------------------------------
            */

            $terakhir = $dataSiswa
                ->sortByDesc(function ($item) {

                    return $item->tanggal
                        ? $item->tanggal->timestamp
                        : 0;

                })
                ->sortByDesc('id')
                ->first();


            if (!$terakhir) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | HITUNG KATEGORI
            |--------------------------------------------------------------------------
            */

            if ($terakhir->kategori == 'Baik') {

                $jumlahBaik++;

            } elseif ($terakhir->kategori == 'Perlu Perhatian') {

                $jumlahPerhatian++;

            } elseif ($terakhir->kategori == 'Perlu Pendampingan') {

                $jumlahPendampingan++;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.laporan.index',
            compact(
                'angket',
                'siswas',
                'siswa',
                'kelas',
                'kelasId',
                'kategori',
                'tanggalMulai',
                'tanggalAkhir',
                'totalSiswa',
                'totalAngket',
                'totalBelajar',
                'totalSholat',
                'rataRataSkor',
                'persentasePengisian',
                'jumlahBaik',
                'jumlahPerhatian',
                'jumlahPendampingan'
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
        */

        $query->orderBy(
            'tanggal',
            'asc'
        );

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
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
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


        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->download(
            'laporan-angket-harian.pdf'
        );
    }
}