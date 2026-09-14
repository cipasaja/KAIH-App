<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AngketHarian;
use App\Services\AngketService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Orang Tua
     */
    public function index(AngketService $service)
    {
        $user = Auth::user();

        // Pastikan akun adalah orang tua
        if (!$user || $user->role !== 'orang_tua') {
            abort(403, 'Akses hanya untuk orang tua.');
        }

        // Ambil data orang tua beserta data siswa
        $orangTua = $user->orangTua()
            ->with('siswa.kelas.jurusan')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jika akun orang tua belum terhubung
        |--------------------------------------------------------------------------
        */
        if (!$orangTua) {
            return view(
                'orangtua.dashboard',
                [
                    'user' => $user,
                    'orangTua' => null,
                    'siswa' => null,
                    'angketHariIni' => null,
                    'statusAngketHariIni' => 'Belum Diisi',
                    'jumlahIbadahHariIni' => 0,
                    'statusBelajarHariIni' => false,
                    'kategoriTerakhir' => '-',
                    'skorTerakhir' => 0,
                    'persentaseBelajar' => 0,
                    'persentaseIbadah' => 0,
                    'rincianSkor' => [
                        'Subuh' => 0,
                        'Dzuhur' => 0,
                        'Ashar' => 0,
                        'Magrib' => 0,
                        'Isya' => 0,
                        'Belajar' => 0,
                        'Bangun Pagi' => 0,
                        'Tidur Malam' => 0,
                    ],
                    'alasanTidakSholat' => null,
                    'riwayatTerbaru' => collect(),
                    'grafikTanggal' => [],
                    'grafikSkor' => [],
                    'grafikIbadah' => [],
                ]
            )->with(
                'error',
                'Akun orang tua belum terhubung dengan data orang tua.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil data siswa
        |--------------------------------------------------------------------------
        */
        $siswa = $orangTua->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa belum tersedia.');
        }

        /*
        |--------------------------------------------------------------------------
        | Sediakan relasi angketHarian untuk dashboard
        |--------------------------------------------------------------------------
        |
        | Model Siswa menggunakan nama relasi angketHarians().
        | Dashboard menggunakan $siswa->angketHarian.
        | Jadi kita samakan dari controller tanpa mengubah model.
        |
        */
        $siswa->setRelation(
            'angketHarian',
            AngketHarian::where('siswa_id', $siswa->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('id', 'desc')
                ->get()
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil semua angket siswa
        |--------------------------------------------------------------------------
        */
        $angket = $siswa->angketHarian;

        /*
        |--------------------------------------------------------------------------
        | ANGKET HARI INI
        |--------------------------------------------------------------------------
        */
        $tanggalHariIni = Carbon::today();

        $angketHariIni = $angket->first(function ($item) use ($tanggalHariIni) {
            return Carbon::parse($item->tanggal)
                ->isSameDay($tanggalHariIni);
        });

        $statusAngketHariIni = $angketHariIni
            ? 'Sudah Diisi'
            : 'Belum Diisi';

        /*
        |--------------------------------------------------------------------------
        | IBADAH HARI INI
        |--------------------------------------------------------------------------
        */
        $jumlahIbadahHariIni = 0;

        if ($angketHariIni) {

            if ($angketHariIni->sholat_subuh) {
                $jumlahIbadahHariIni++;
            }

            if ($angketHariIni->sholat_dzuhur) {
                $jumlahIbadahHariIni++;
            }

            if ($angketHariIni->sholat_ashar) {
                $jumlahIbadahHariIni++;
            }

            if ($angketHariIni->sholat_magrib) {
                $jumlahIbadahHariIni++;
            }

            if ($angketHariIni->sholat_isya) {
                $jumlahIbadahHariIni++;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BELAJAR HARI INI
        |--------------------------------------------------------------------------
        */
        $statusBelajarHariIni = $angketHariIni
            ? (bool) $angketHariIni->belajar
            : false;

        /*
        |--------------------------------------------------------------------------
        | ANGKET TERAKHIR
        |--------------------------------------------------------------------------
        */
        $angketTerakhir = $angket->first();

        $skorTerakhir = $angketTerakhir
            ? ($angketTerakhir->skor ?? 0)
            : 0;

        $kategoriTerakhir = $angketTerakhir
            ? ($angketTerakhir->kategori ?? '-')
            : '-';

        /*
        |--------------------------------------------------------------------------
        | RINCIAN SKOR TERAKHIR
        |--------------------------------------------------------------------------
        */
        if ($angketTerakhir) {

            $rincianSkor = $service->rincianSkor(
                $angketTerakhir->toArray()
            );

        } else {

            $rincianSkor = [
                'Subuh' => 0,
                'Dzuhur' => 0,
                'Ashar' => 0,
                'Magrib' => 0,
                'Isya' => 0,
                'Belajar' => 0,
                'Bangun Pagi' => 0,
                'Tidur Malam' => 0,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PERSENTASE BELAJAR
        |--------------------------------------------------------------------------
        */
        $totalAngket = $angket->count();

        if ($totalAngket > 0) {

            $jumlahBelajar = $angket
                ->where('belajar', true)
                ->count();

            $persentaseBelajar = round(
                ($jumlahBelajar / $totalAngket) * 100
            );

        } else {

            $persentaseBelajar = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | PERSENTASE IBADAH
        |--------------------------------------------------------------------------
        */
        $totalSholat = 0;

        $totalKesempatanSholat = $totalAngket * 5;

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

        if ($totalKesempatanSholat > 0) {

            $persentaseIbadah = round(
                ($totalSholat / $totalKesempatanSholat) * 100
            );

        } else {

            $persentaseIbadah = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | ALASAN TIDAK SHOLAT
        |--------------------------------------------------------------------------
        */
        $alasanTidakSholat = $angketTerakhir
            ? ($angketTerakhir->alasan_tidak_sholat ?? null)
            : null;

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT TERBARU
        |--------------------------------------------------------------------------
        */
        $riwayatTerbaru = $angket->take(5);

        /*
        |--------------------------------------------------------------------------
        | GRAFIK 7 HARI
        |--------------------------------------------------------------------------
        */
        $grafikTanggal = [];
        $grafikSkor = [];
        $grafikIbadah = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::today()->subDays($i);

            $dataHari = $angket->first(function ($item) use ($tanggal) {

                return Carbon::parse($item->tanggal)
                    ->isSameDay($tanggal);

            });

            $grafikTanggal[] = $tanggal->format('d/m');

            if ($dataHari) {

                $grafikSkor[] = (int) ($dataHari->skor ?? 0);

                $jumlahSholat = 0;

                if ($dataHari->sholat_subuh) {
                    $jumlahSholat++;
                }

                if ($dataHari->sholat_dzuhur) {
                    $jumlahSholat++;
                }

                if ($dataHari->sholat_ashar) {
                    $jumlahSholat++;
                }

                if ($dataHari->sholat_magrib) {
                    $jumlahSholat++;
                }

                if ($dataHari->sholat_isya) {
                    $jumlahSholat++;
                }

                // 5 sholat = 100%
                $grafikIbadah[] = $jumlahSholat * 20;

            } else {

                $grafikSkor[] = 0;
                $grafikIbadah[] = 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Tampilkan dashboard
        |--------------------------------------------------------------------------
        */
        return view(
            'orangtua.dashboard',
            compact(
                'user',
                'orangTua',
                'siswa',
                'angketHariIni',
                'statusAngketHariIni',
                'jumlahIbadahHariIni',
                'statusBelajarHariIni',
                'kategoriTerakhir',
                'skorTerakhir',
                'persentaseBelajar',
                'persentaseIbadah',
                'rincianSkor',
                'alasanTidakSholat',
                'riwayatTerbaru',
                'grafikTanggal',
                'grafikSkor',
                'grafikIbadah'
            )
        );
    }
}