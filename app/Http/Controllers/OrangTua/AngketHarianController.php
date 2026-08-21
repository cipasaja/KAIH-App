<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\AngketHarian;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AngketHarianController extends Controller
{
    /**
     * Menampilkan riwayat angket harian.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data orang tua berdasarkan akun yang sedang login
        $orangTua = OrangTua::where('id', $user->orang_tua_id)
            ->with('siswa')
            ->first();

        // Kalau akun belum terhubung dengan data orang tua
        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with('error', 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        // Ambil semua angket milik siswa tersebut
        $angket = AngketHarian::where('orang_tua_id', $orangTua->id)
            ->where('siswa_id', $orangTua->siswa_id)
            ->orderByDesc('tanggal')
            ->get();

       return view('admin.orangtua.angket.create', compact(
        'orangTua',
        'siswa'
    ));
    }


    /**
     * Menampilkan form pengisian angket.
     */
    public function create()
    {
        $user = Auth::user();

        // Ambil data orang tua
        $orangTua = OrangTua::where('id', $user->orang_tua_id)
            ->with('siswa')
            ->first();

        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with('error', 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        // Pastikan orang tua memiliki siswa
        if (!$orangTua->siswa) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with('error', 'Data siswa/anak belum terhubung dengan orang tua.');
        }

        return view('orangtua.angket.create', compact(
            'orangTua'
        ));
    }


    /**
     * Menyimpan angket harian.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Ambil data orang tua
        $orangTua = OrangTua::where('id', $user->orang_tua_id)
            ->with('siswa')
            ->first();

        if (!$orangTua) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with('error', 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        if (!$orangTua->siswa) {
            return redirect()
                ->route('orangtua.dashboard')
                ->with('error', 'Data siswa/anak belum terhubung dengan orang tua.');
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi
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
                'max:1000',
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


        /*
        |--------------------------------------------------------------------------
        | Cek apakah tanggal sudah pernah diisi
        |--------------------------------------------------------------------------
        */

        $sudahAda = AngketHarian::where('siswa_id', $orangTua->siswa_id)
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Angket untuk tanggal tersebut sudah pernah diisi.');
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan data
        |--------------------------------------------------------------------------
        */

        $angket = new AngketHarian();

        $angket->orang_tua_id = $orangTua->id;
        $angket->siswa_id = $orangTua->siswa_id;

        $angket->tanggal = $validated['tanggal'];
        $angket->bangun_pagi = $validated['bangun_pagi'] ?? null;

        $angket->sholat_subuh = $request->boolean('sholat_subuh');
        $angket->sholat_ashar = $request->boolean('sholat_ashar');

        $angket->kegiatan_membantu =
            $validated['kegiatan_membantu'] ?? null;

        $angket->sholat_magrib = $request->boolean('sholat_magrib');
        $angket->sholat_isya = $request->boolean('sholat_isya');

        $angket->belajar = $request->boolean('belajar');

        $angket->tidur_malam = $validated['tidur_malam'] ?? null;

        $angket->save();


        /*
        |--------------------------------------------------------------------------
        | Kembali ke riwayat
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('orangtua.angket.index')
            ->with('success', 'Angket harian berhasil disimpan.');
    }
}