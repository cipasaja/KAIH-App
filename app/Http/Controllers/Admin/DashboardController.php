<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\AngketHarian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Data Master
        |--------------------------------------------------------------------------
        */

        $totalJurusan = Jurusan::count();
        $totalKelas = Kelas::count();
        $totalSiswa = Siswa::count();
        $totalOrangTua = OrangTua::count();


        /*
        |--------------------------------------------------------------------------
        | Monitoring Angket Hari Ini
        |--------------------------------------------------------------------------
        */

        $tanggal = Carbon::today()->format('Y-m-d');


        // Siswa yang sudah mengisi angket hari ini
        $angketHariIni = AngketHarian::whereDate(
            'tanggal',
            $tanggal
        )
        ->distinct('siswa_id')
        ->count('siswa_id');


        // Siswa yang belum mengisi
        $belumIsiAngket = $totalSiswa - $angketHariIni;


        // Persentase pengisian
        $persentaseAngket = $totalSiswa > 0
            ? round(($angketHariIni / $totalSiswa) * 100)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Statistik Kategori
        |--------------------------------------------------------------------------
        */

        $kategoriQuery = AngketHarian::whereDate(
            'tanggal',
            $tanggal
        );


        $jumlahBaik = (clone $kategoriQuery)
            ->where('kategori', 'Baik')
            ->count();


        $jumlahPerhatian = (clone $kategoriQuery)
            ->where('kategori', 'Perlu Perhatian')
            ->count();


        $jumlahPendampingan = (clone $kategoriQuery)
            ->where('kategori', 'Perlu Pendampingan')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Siswa Perlu Perhatian
        |--------------------------------------------------------------------------
        */

        $siswaPerhatian = AngketHarian::with([
            'siswa.kelas'
        ])
        ->whereDate('tanggal', $tanggal)
        ->whereIn('kategori', [
            'Perlu Perhatian',
            'Perlu Pendampingan'
        ])
        ->orderByDesc('id')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Siswa Belum Mengisi Angket
        |--------------------------------------------------------------------------
        */

        $siswaBelumIsi = Siswa::with('kelas')
            ->whereDoesntHave('angketHarians', function ($query) use ($tanggal) {
                $query->whereDate('tanggal', $tanggal);
            })
            ->orderBy('nama_siswa')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kirim Data ke Dashboard
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'totalJurusan',
            'totalKelas',
            'totalSiswa',
            'totalOrangTua',

            'jumlahBaik',
            'jumlahPerhatian',
            'jumlahPendampingan',

            'angketHariIni',
            'belumIsiAngket',
            'persentaseAngket',

            'siswaPerhatian',
            'siswaBelumIsi'
        ));
    }
}