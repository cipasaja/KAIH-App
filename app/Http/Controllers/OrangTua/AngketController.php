<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AngketHarian;
use App\Services\AngketService;
use Carbon\Carbon;

class AngketController extends Controller
{
    /**
     * Riwayat angket
     */
    public function index()
    {
        $orangTua = Auth::user()
            ->orangTua()
            ->with([
                'siswa.kelas.jurusan',
                'siswa.angketHarians'
            ])
            ->first();

        if (!$orangTua) {
            abort(
                403,
                'Data orang tua belum terhubung.'
            );
        }

        $angketHarian = AngketHarian::where(
                'orang_tua_id',
                $orangTua->id
            )
            ->orderBy(
                'tanggal',
                'desc'
            )
            ->get();

        return view(
            'orangtua.angket.index',
            compact(
                'angketHarian',
                'orangTua'
            )
        );
    }


    /**
     * Form isi angket
     */
    public function create()
    {
        $orangTua = Auth::user()
            ->orangTua()
            ->with('siswa')
            ->first();

        if (!$orangTua || !$orangTua->siswa) {
            abort(
                403,
                'Data siswa belum tersedia.'
            );
        }

        $siswa = $orangTua->siswa;

        $tanggalHariIni = Carbon::today()
            ->format('Y-m-d');

        return view(
            'orangtua.angket.create',
            compact(
                'orangTua',
                'siswa',
                'tanggalHariIni'
            )
        );
    }


    /**
     * Simpan angket
     */
    public function store(
        Request $request,
        AngketService $service
    ) {
        $orangTua = Auth::user()
            ->orangTua()
            ->with('siswa')
            ->first();

        if (!$orangTua || !$orangTua->siswa) {
            abort(
                403,
                'Data siswa belum tersedia.'
            );
        }

        $siswaId = $orangTua->siswa->id;


        $request->validate([

            'tanggal'
                =>
            'required|date',

            'sholat_subuh'
                =>
            'nullable|boolean',

            'sholat_dzuhur'
                =>
            'nullable|boolean',

            'sholat_ashar'
                =>
            'nullable|boolean',

            'sholat_magrib'
                =>
            'nullable|boolean',

            'sholat_isya'
                =>
            'nullable|boolean',

            'belajar'
                =>
            'nullable|boolean',

            'sarapan'
                =>
            'nullable|boolean',

            'makan_siang'
                =>
            'nullable|boolean',

            'makan_malam'
                =>
            'nullable|boolean',

            // TAMBAHAN BARU
            'olahraga'
                =>
            'nullable|boolean',

            'bangun_pagi'
                =>
            'nullable|date_format:H:i',

            'tidur_malam'
                =>
            'nullable|date_format:H:i',

            'kegiatan_membantu'
                =>
            'nullable|string',

            'alasan_tidak_sholat'
                =>
            'nullable|string|max:500',

        ]);


        $tanggal = Carbon::parse(
            $request->tanggal
        );

        $hariIni = Carbon::today();


        if ($tanggal->gt($hariIni)) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tanggal tidak boleh lebih dari hari ini.'
                );
        }


        if (
            $tanggal->lt(
                $hariIni->copy()->subDay()
            )
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengisian maksimal satu hari sebelumnya.'
                );
        }


        $cek = AngketHarian::where(
                'siswa_id',
                $siswaId
            )
            ->whereDate(
                'tanggal',
                $request->tanggal
            )
            ->exists();


        if ($cek) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Angket tanggal tersebut sudah ada.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG SKOR
        |--------------------------------------------------------------------------
        | Olahraga belum dimasukkan ke skor.
        */

        $skor = $service->hitungSkor([

            'sholat_subuh'
                =>
            $request->boolean('sholat_subuh'),

            'sholat_dzuhur'
                =>
            $request->boolean('sholat_dzuhur'),

            'sholat_ashar'
                =>
            $request->boolean('sholat_ashar'),

            'sholat_magrib'
                =>
            $request->boolean('sholat_magrib'),

            'sholat_isya'
                =>
            $request->boolean('sholat_isya'),

            'belajar'
                =>
            $request->boolean('belajar'),

            'bangun_pagi'
                =>
            $request->bangun_pagi,

            'tidur_malam'
                =>
            $request->tidur_malam,

        ]);


        $kategori = $service->kategori(
            $skor
        );


        try {

            DB::transaction(function () use (
                $request,
                $orangTua,
                $siswaId,
                $skor,
                $kategori
            ) {

                AngketHarian::create([

                    'orang_tua_id'
                        =>
                    $orangTua->id,

                    'siswa_id'
                        =>
                    $siswaId,

                    'tanggal'
                        =>
                    $request->tanggal,

                    'tanggal_pengisian'
                        =>
                    now(),

                    'bangun_pagi'
                        =>
                    $request->bangun_pagi,

                    'sholat_subuh'
                        =>
                    $request->boolean('sholat_subuh'),

                    'sholat_dzuhur'
                        =>
                    $request->boolean('sholat_dzuhur'),

                    'sholat_ashar'
                        =>
                    $request->boolean('sholat_ashar'),

                    'sholat_magrib'
                        =>
                    $request->boolean('sholat_magrib'),

                    'sholat_isya'
                        =>
                    $request->boolean('sholat_isya'),


                    // ALASAN TIDAK SHOLAT
                    'alasan_tidak_sholat'
                        =>
                    $request->alasan_tidak_sholat,


                    // BELAJAR
                    'belajar'
                        =>
                    $request->boolean('belajar'),


                    // MAKANAN BERGIZI
                    'sarapan'
                        =>
                    $request->boolean('sarapan'),

                    'makan_siang'
                        =>
                    $request->boolean('makan_siang'),

                    'makan_malam'
                        =>
                    $request->boolean('makan_malam'),


                    // OLAHRAGA
                    'olahraga'
                        =>
                    $request->boolean('olahraga'),


                    // KEGIATAN MEMBANTU
                    'kegiatan_membantu'
                        =>
                    $request->kegiatan_membantu,


                    // TIDUR
                    'tidur_malam'
                        =>
                    $request->tidur_malam,


                    // SKOR
                    'skor'
                        =>
                    $skor,


                    // KATEGORI
                    'kategori'
                        =>
                    $kategori,

                ]);
            });


        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menyimpan angket.'
                );
        }


        return redirect()
            ->route(
                'orangtua.dashboard'
            )
            ->with(
                'success',
                'Angket berhasil disimpan.'
            );
    }
}