<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AngketHarianController extends Controller
{
    /**
     * Halaman daftar / riwayat angket
     */
    public function index()
    {
        $user = Auth::user();

        $orangTua = $user->orangTua()
            ->with('siswa.kelas')
            ->first();

        if (!$orangTua) {
            abort(403, 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa belum terhubung dengan orang tua.');
        }

        // Ambil riwayat angket milik anak ini
        $angket = AngketHarian::where('orang_tua_id', $orangTua->id)
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.orangtua.angket.index', compact(
            'orangTua',
            'siswa',
            'angket'
        ));
    }


    /**
     * Form angket hari ini
     */
    public function create()
    {
        $user = Auth::user();

        $orangTua = $user->orangTua()
            ->with('siswa.kelas')
            ->first();

        if (!$orangTua) {
            abort(403, 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa belum terhubung dengan orang tua.');
        }

        return view('admin.orangtua.angket.create', compact(
            'orangTua',
            'siswa'
        ));
    }


    /**
     * Simpan angket
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $orangTua = $user->orangTua()
            ->with('siswa')
            ->first();

        if (!$orangTua) {
            abort(403, 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        $siswa = $orangTua->siswa;

        if (!$siswa) {
            abort(403, 'Data siswa belum terhubung dengan orang tua.');
        }

        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'bangun_pagi' => [
                'nullable',
                'date_format:H:i',
            ],

            'sholat_subuh' => [
                'nullable',
                'boolean',
            ],

            'sholat_ashar' => [
                'nullable',
                'boolean',
            ],

            'kegiatan_membantu' => [
                'nullable',
                'string',
            ],

            'sholat_magrib' => [
                'nullable',
                'boolean',
            ],

            'sholat_isya' => [
                'nullable',
                'boolean',
            ],

            'belajar' => [
                'nullable',
                'boolean',
            ],

            'tidur_malam' => [
                'nullable',
                'date_format:H:i',
            ],
        ]);


        // Cek apakah tanggal tersebut sudah pernah diisi
        $sudahAda = AngketHarian::where('orang_tua_id', $orangTua->id)
            ->where('siswa_id', $siswa->id)
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Angket untuk tanggal tersebut sudah pernah diisi.'
                );
        }


        // Simpan
        AngketHarian::create([
            'orang_tua_id' => $orangTua->id,
            'siswa_id' => $siswa->id,
            'tanggal' => $validated['tanggal'],

            'bangun_pagi' =>
                $validated['bangun_pagi'] ?? null,

            'sholat_subuh' =>
                $validated['sholat_subuh'] ?? null,

            'sholat_ashar' =>
                $validated['sholat_ashar'] ?? null,

            'kegiatan_membantu' =>
                $validated['kegiatan_membantu'] ?? null,

            'sholat_magrib' =>
                $validated['sholat_magrib'] ?? null,

            'sholat_isya' =>
                $validated['sholat_isya'] ?? null,

            'belajar' =>
                $validated['belajar'] ?? null,

            'tidur_malam' =>
                $validated['tidur_malam'] ?? null,
        ]);


        return redirect()
            ->route('orangtua.angket.index')
            ->with(
                'success',
                'Angket harian berhasil disimpan.'
            );
    }
}