<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AngketHarianController extends Controller
{
    /**
     * Menampilkan riwayat angket milik anak.
     */
    public function index()
    {
        $user = Auth::user();

        $orangTua = $user->orangTua;

        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data orang tua belum terhubung dengan akun ini.'
                );
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data siswa belum terhubung dengan orang tua ini.'
                );
        }

        $angket = AngketHarian::where('orang_tua_id', $orangTua->id)
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->get();

        return view(
            'orangtua.angket.index',
            compact(
                'user',
                'orangTua',
                'siswa',
                'angket'
            )
        );
    }


    /**
     * Menampilkan form angket.
     */
    public function create()
    {
        $user = Auth::user();

        $orangTua = $user->orangTua;

        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data orang tua belum terhubung dengan akun ini.'
                );
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data siswa belum terhubung dengan orang tua ini.'
                );
        }

        return view('orangtua.angket.create',compact(
                'user',
                'orangTua',
                'siswa'
            )
        );
    }


    /**
     * Menyimpan angket.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $orangTua = $user->orangTua;

        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data orang tua belum terhubung dengan akun ini.'
                );
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with(
                    'error',
                    'Data siswa belum terhubung dengan orang tua ini.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'tanggal' => [
                'required',
                'date',
            ],

            'bangun_pagi' => [
                'nullable',
                'date_format:H:i',
            ],

            // SHOLAT 5 WAKTU

            'sholat_subuh' => [
                'nullable',
                'boolean',
            ],

            'sholat_dzuhur' => [
                'nullable',
                'boolean',
            ],

            'sholat_ashar' => [
                'nullable',
                'boolean',
            ],

            'sholat_magrib' => [
                'nullable',
                'boolean',
            ],

            'sholat_isya' => [
                'nullable',
                'boolean',
            ],

            // KEGIATAN

            'kegiatan_membantu' => [
                'nullable',
                'string',
            ],

            // BELAJAR

            'belajar' => [
                'nullable',
                'boolean',
            ],

            // TIDUR

            'tidur_malam' => [
                'nullable',
                'date_format:H:i',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEGAH PENGISIAN 2X PADA TANGGAL YANG SAMA
        |--------------------------------------------------------------------------
        */

        $sudahAda = AngketHarian::where(
                'siswa_id',
                $siswa->id
            )
            ->where(
                'tanggal',
                $validated['tanggal']
            )
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Angket untuk tanggal tersebut sudah pernah diisi.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA
        |--------------------------------------------------------------------------
        */

        AngketHarian::create([

            'orang_tua_id' => $orangTua->id,

            'siswa_id' => $siswa->id,

            'tanggal' => $validated['tanggal'],

            // Jam bangun
            'bangun_pagi' =>
                $validated['bangun_pagi'] ?? null,

            // Sholat 5 waktu
            'sholat_subuh' =>
                $validated['sholat_subuh'] ?? null,

            'sholat_dzuhur' =>
                $validated['sholat_dzuhur'] ?? null,

            'sholat_ashar' =>
                $validated['sholat_ashar'] ?? null,

            'sholat_magrib' =>
                $validated['sholat_magrib'] ?? null,

            'sholat_isya' =>
                $validated['sholat_isya'] ?? null,

            // Kegiatan membantu orang tua
            'kegiatan_membantu' =>
                $validated['kegiatan_membantu'] ?? null,

            // Belajar
            'belajar' =>
                $validated['belajar'] ?? null,

            // Jam tidur
            'tidur_malam' =>
                $validated['tidur_malam'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | SELESAI
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('orangtua.angket.index')
            ->with(
                'success',
                'Angket harian berhasil disimpan.'
            );
    }
}